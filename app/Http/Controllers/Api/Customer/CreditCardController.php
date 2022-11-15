<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerCreditCard;
use App\Helper\CustomerFaceliaHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Api\ApiController;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\SendCreditCardCodeNotification;
use Illuminate\Http\Request;

class CreditCardController extends ApiController
{
    public function store($customer_id, $number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        $card = CustomerCreditCard::createCard(
            $wallet->customer,
            $wallet,
            $request->get('type'),
            $request->get('support'),
            $request->get('debit'),
        );

        if ($wallet->Numberofphysicalbankcardsexceeded()) {
            CustomerTransactionHelper::create(
                'debit',
                'frais',
                'Cotisation Carte Bancaire Physique',
                25,
                $wallet->id,
                true,
                'Carte Bancaire Supplémentaire N°' . $card->number_card_oscure,
                now(),
            );
        }

        if ($wallet->Numberofvirtualbankcardsexceeded()) {
            CustomerTransactionHelper::create(
                'debit',
                'frais',
                'Cotisation Carte Bancaire Virtuel',
                10,
                $wallet->id,
                true,
                'Carte Bancaire virtuel Supplémentaire N°' . $card->number_card_oscure,
                now(),
            );
        }

        return response()->json();
    }

    public function update($customer_id, $number_account, $card_id, Request $request)
    {
        $card = \App\Models\Customer\CustomerCreditCard::find($card_id);

        return match ($request->get('action')) {
            "edit" => $this->editCreditCard($card, $request),
            "send_code" => $this->sendCode($card),
            "facelia" => $this->facelia($card, $request)
        };
    }

    private function editCreditCard(\App\Models\Customer\CustomerCreditCard $card, Request $request)
    {
        try {
            $card->update($request->except('_token', 'action'));
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json(null, 500);
        }

        return response()->json();
    }

    private function sendCode(\App\Models\Customer\CustomerCreditCard $card)
    {
        if ($card->wallet->customer->package->name != 'Platine' || $card->wallet->customer->package->name != 'Pro Gold') {
            CustomerTransactionHelper::create(
                'debit',
                'frais',
                'Frais Bancaire',
                0.15,
                $card->wallet->id,
                true,
                'Renvoie du code carte bancaire '.$card->number_card_oscure,
                now()
            );
        }

        $card->wallet->customer->info->notify(new SendCreditCardCodeNotification($card->wallet->customer, base64_decode($card->code), $card));

        return response()->json();
    }

    private function facelia(\App\Models\Customer\CustomerCreditCard $card, Request $request)
    {
        if (CustomerFaceliaHelper::verify($card->wallet->customer, true, $card)) {
            try {
                CustomerFaceliaHelper::create(
                    $card->wallet,
                    $card->wallet->customer,
                    $request->get('amount_available'),
                    $card
                );
            }catch (\Exception $exception) {
                return $this->sendError($exception);
            }
        } else {
            return $this->sendWarning("Ce compte ne présente pas tous les prérequis pour souscrire au crédit FACELIA");
        }

        return $this->sendSuccess();
    }
}

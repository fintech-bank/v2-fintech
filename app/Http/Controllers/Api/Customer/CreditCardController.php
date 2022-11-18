<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerCreditCard;
use App\Helper\CustomerFaceliaHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Api\ApiController;
use App\Models\Core\CreditCardOpposit;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\CancelCreditCardNotification;
use App\Notifications\Customer\SendCreditCardCodeNotification;
use App\Notifications\Customer\SendRequestNotification;
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
            "facelia" => $this->facelia($card, $request),
            "cancel_card" => $this->cancelCard($card),
            "opposit_card" => $this->oppositCard($card, $request)
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
                'Renvoie du code carte bancaire ' . $card->number_card_oscure,
                now()
            );
        }

        $card->wallet->customer->info->notify(new SendCreditCardCodeNotification($card->wallet->customer, base64_decode($card->code), $card));

        return response()->json();
    }

    private function facelia(\App\Models\Customer\CustomerCreditCard $card, Request $request)
    {
        if ($card->facelias()->count() == 0) {
            if (CustomerFaceliaHelper::verify($card->wallet->customer, true, $card)) {
                try {
                    // Création du compte
                    $pret = CustomerLoanHelper::create(
                        $card->wallet->id,
                        $card->wallet->customer,
                        $request->get('amount_available'),
                        6,
                        '36',
                        '20',
                        'open',
                        $card
                    );

                    return $this->sendSuccess(null, $pret);
                } catch (\Exception $exception) {
                    return $this->sendError($exception);
                }
            } else {
                return $this->sendWarning("Ce compte ne présente pas tous les prérequis pour souscrire au crédit FACELIA");
            }
        } else {
            return $this->sendWarning("Cette carte bancaire est déjà affilier à un crédit FACELIA");
        }
    }

    private function cancelCard(\App\Models\Customer\CustomerCreditCard $card)
    {
        $card->update([
            'status' => 'canceled'
        ]);

        $card->wallet->customer->info->notify(new CancelCreditCardNotification($card->wallet->customer, $card));

        return $this->sendSuccess();

    }

    private function oppositCard(\App\Models\Customer\CustomerCreditCard $card, Request $request)
    {
        $opposit = $card->setOpposit($request->get('raison_select'), $request->get('description'));
        $requete = $card->wallet->customer->requests()->create([
            "reference" => generateReference(14),
            "sujet" => "Opposition sur la carte bancaire",
            "commentaire" => "Veuillez nous transmettre les documents relatives à la requete d'opposition.",
            "link_model" => CreditCardOpposit::class,
            "link_id" => $opposit->id,
            "customer_id" => $card->wallet->customer->id,
        ]);

        $card->wallet->customer->info->notify(new SendRequestNotification($card->wallet->customer, $requete));

        return response()->json();
    }
}

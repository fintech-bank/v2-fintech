<?php

namespace App\Http\Controllers\Api\Card;

use App\Helper\CustomerLoanHelper;
use App\Http\Controllers\Api\ApiController;
use App\Jobs\Customer\Card\LimitWithdrawJob;
use App\Models\Customer\CustomerCreditCard;
use Illuminate\Http\Request;

class CardController extends ApiController
{
    public function index()
    {

    }

    public function update($card_id, Request $request)
    {
        $card = CustomerCreditCard::find($card_id);

        return match($request->get('action')) {
            "desactiveCard" => $this->desactiveCard($card),
            "activeCard" => $this->activeCard($card),
            "oppositCard" => $this->oppositCard($card, $request),
            'editLimitPayment' => $this->editLimitPayment($card, $request),
            'editLimitWithdraw' => $this->editLimitWithdraw($card, $request),
            'subscribeAlterna' => $this->subscribeAlterna($card, $request)
        };
    }

    private function desactiveCard(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card)
    {
        $card->update(['status' => 'inactive']);

        return $this->sendSuccess("Carte désactivé");
    }

    private function activeCard(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card)
    {
        $card->update(['status' => 'active']);

        return $this->sendSuccess("Carte activé");
    }

    private function oppositCard(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card, Request $request)
    {
        $opposit = $card->opposition()->create([
            'reference' => generateReference(),
            'type' => $request->get('type'),
            'description' => $request->get('description'),
            'verif_fraude' => $request->get('type') == 'fraude',
            'status' => 'submit',
            'customer_credit_card_id' => $card->id
        ]);

        $card->update(['status' => 'opposit']);

        return $this->sendSuccess("Dossier d'opposition transmis");
    }

    private function editLimitPayment(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card, Request $request)
    {
        $card->update(["limit_payment" => $request->get('limit_payment')]);

        return $this->sendSuccess("Plafond de paiement edité");
    }

    private function editLimitWithdraw(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card, Request $request)
    {
        dispatch(new LimitWithdrawJob($card, $card->limit_retrait))->delay(now()->addDays(2));
        $card->update(['limit_retrait' => $request->get('limit_retrait')]);

        return $this->sendSuccess("Limite de retrait edité");
    }

    private function subscribeAlterna(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card, Request $request)
    {
        dd($request->all());
        try {
            CustomerLoanHelper::create(
                $card->wallet->id,
                $card->wallet->customer,
                \Str::replace('€ ', '', $request->get('amount_available')),
                $request->get('loan_plan_id'),
                $request->get('duration'),
                '10',
                'open',
                $card
            );
            return $this->sendSuccess("Demande de crédit facelia effectué");
        }catch (\Exception $exception) {
            return $this->sendWarning("Erreur", ['errors', $exception]);
        }
    }
}

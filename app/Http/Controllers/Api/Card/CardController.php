<?php

namespace App\Http\Controllers\Api\Card;

use App\Http\Controllers\Api\ApiController;
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
            "oppositCard" => $this->oppositCard($card, $request)
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
}

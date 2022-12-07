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
}

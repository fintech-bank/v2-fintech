<?php

namespace App\Http\Controllers\Customer\Compte;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        return view('customer.compte.card.index', [
            'customer' => Customer::find(auth()->user()->customers->id),
            "wallets" => Customer::find(auth()->user()->customers->id)->wallets
        ]);
    }

    public function show($card_id)
    {
        $card = CustomerCreditCard::find($card_id);
        return view('customer.compte.card.show', [
            'customer' => Customer::find(auth()->user()->customers->id),
            "card" => $card,
            "wallet" => $card->wallet
        ]);
    }

    public function opposit($card_id)
    {
        $card = CustomerCreditCard::find($card_id);
        return view('customer.compte.card.opposit', [
            'customer' => Customer::find(auth()->user()->customers->id),
            "card" => $card,
            "wallet" => $card->wallet
        ]);
    }

    public function piece($card_id, Request $request)
    {
        $request->validate([
            'file' => "required|file|mimes:png,bpm,jpg,jpeg,pdf"
        ]);
        $card = CustomerCreditCard::find($card_id);

        $file = $request->file('file');
        $file->storeAs(public_path('uploads/card/opposit/'.$card->opposition->reference.'/'), $file->getClientOriginalName().'.'.$file->getClientOriginalExtension());

        $card->opposition()->update(['status' => 'progress']);

        return redirect()->back()->with('success', "Votre documents nous à bien été transmis");
    }
}

<?php

namespace App\Http\Controllers\Customer\Profil;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class CashbackController extends Controller
{
    public function __invoke()
    {
        $customer = Customer::find(auth()->user()->customers->id);

        if($customer->setting->cashback) {
            if($customer->setting->tos_cashback) {
                return redirect()->to("https://cashback.fintech.ovh/");
            } else {
                return view('customer.account.profil.cashback', ["customer" => Customer::find(auth()->user()->customers->id)]);
            }
        } else {
            return redirect()->back()->with('error', "Vous n'avez pas accès ou souscrit à ce services");
        }
    }
}

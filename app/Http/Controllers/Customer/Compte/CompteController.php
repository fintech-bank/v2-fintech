<?php

namespace App\Http\Controllers\Customer\Compte;

use App\Http\Controllers\Controller;
use App\Services\GoCardless\Customer;

class CompteController extends Controller
{
    public function index()
    {
        return view('customer.compte.index', [
            'wallets' => Customer::find(auth()->user()->customers->id)->wallets
        ]);
    }
}

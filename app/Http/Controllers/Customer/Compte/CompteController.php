<?php

namespace App\Http\Controllers\Customer\Compte;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class CompteController extends Controller
{
    public function index()
    {
        dd(Customer::find(auth()->user()->customers->id)->wallets()->where('type', 'epargne')->count());
        return view('customer.compte.index', [
            "customer" => Customer::find(auth()->user()->customers->id),
            'wallets' => Customer::find(auth()->user()->customers->id)->wallets()
        ]);
    }
}

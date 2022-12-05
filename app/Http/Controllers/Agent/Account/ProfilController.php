<?php

namespace App\Http\Controllers\Agent\Account;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        return view('customer.account.profil.index', [
            "customer" => Customer::find(auth()->user()->customers->id)
        ]);
    }
}

<?php

namespace App\Http\Controllers\Customer\Profil;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class SouscriptionController extends Controller
{
    public function index()
    {
        return view('customer.account.profil.souscription.index', [
            "customer" => Customer::find(auth()->user()->customers->id)
        ]);
    }
}

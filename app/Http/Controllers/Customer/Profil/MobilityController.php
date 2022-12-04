<?php

namespace App\Http\Controllers\Customer\Profil;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class MobilityController extends Controller
{
    public function index()
    {
        return view('customer.account.profil.mobility.index', [
            'customer' => Customer::find(auth()->user()->customers->id)
        ]);
    }
}

<?php

namespace App\Http\Controllers\Customer\Profil;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerMobility;

class MobilityController extends Controller
{
    public function index()
    {
        return view('customer.account.profil.mobility.index', [
            'customer' => Customer::find(auth()->user()->customers->id)
        ]);
    }

    public function show($ref_mandate)
    {
        $mobility = CustomerMobility::where('ref_mandate', $ref_mandate)->first();
        return view('customer.account.profil.mobility.show', [
            'mobility' => $mobility
        ]);
    }
}

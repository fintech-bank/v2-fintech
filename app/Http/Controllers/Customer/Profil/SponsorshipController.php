<?php

namespace App\Http\Controllers\Customer\Profil;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class SponsorshipController extends Controller
{
    public function __invoke()
    {
        return view('customer.account.profil.sponsorship', [
            'customer' => Customer::find(auth()->user()->customers->id)
        ]);
    }
}

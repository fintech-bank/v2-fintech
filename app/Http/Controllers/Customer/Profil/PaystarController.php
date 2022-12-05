<?php

namespace App\Http\Controllers\Customer\Profil;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class PaystarController extends Controller
{
    public function __invoke()
    {
        return view('customer.account.profil.paystar', [
            'customer' => Customer::find(auth()->user()->customers->id)
        ]);
    }
}

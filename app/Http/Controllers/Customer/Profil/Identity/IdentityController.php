<?php

namespace App\Http\Controllers\Customer\Profil\Identity;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class IdentityController extends Controller
{
    public function __invoke()
    {
        dd(auth()->user()->id);
        return view('customer.account.profil.identity', [
            'customer' => Customer::find(auth()->user()->id)
        ]);
    }
}

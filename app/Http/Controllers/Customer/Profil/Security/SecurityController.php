<?php

namespace App\Http\Controllers\Customer\Profil\Security;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class SecurityController extends Controller
{
    public function __invoke()
    {
        return view('customer.account.profil.security.index', [
            'customer' => Customer::find(auth()->user()->customers->id)
        ]);
    }
}

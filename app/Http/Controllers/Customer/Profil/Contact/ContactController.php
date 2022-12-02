<?php

namespace App\Http\Controllers\Customer\Profil\Contact;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class ContactController extends Controller
{
    public function __invoke()
    {
        return view('customer.account.profil.contact', [
            'customer' => Customer::find(auth()->user()->customers->id)
        ]);
    }
}

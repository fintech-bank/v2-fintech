<?php

namespace App\Http\Controllers\Customer\Profil\Contact;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class GrpdController extends Controller
{
    public function index()
    {
        return view('customer.account.profil.grpd.index', [
            'customer' => Customer::find(auth()->user()->customers->id)
        ]);
    }
}

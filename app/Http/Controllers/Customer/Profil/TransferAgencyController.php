<?php

namespace App\Http\Controllers\Customer\Profil;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class TransferAgencyController extends Controller
{
    public function index()
    {
        return view('customer.account.profil.transfer.index', [
            'customer' => Customer::find(auth()->user()->customers->id)
        ]);
    }
}

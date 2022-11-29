<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('customer.dashboard', [
            'customer' => Customer::find(auth()->user()->customers->id)
        ]);
    }
}

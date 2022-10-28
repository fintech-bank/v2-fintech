<?php

namespace App\Http\Controllers\Agent\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreatePartCustomerController extends Controller
{
    public function info()
    {
        return view('agent.customer.create.part.info');
    }

    public function pro(Request $request)
    {
        session()->put('info', $request->all());

        return view('agent.customer.create.part.pro');
    }
}

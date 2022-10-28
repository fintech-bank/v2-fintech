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
        session()->flush();
        session()->put('perso', $request->except('_token'));

        return view('agent.customer.create.part.pro');
    }
}

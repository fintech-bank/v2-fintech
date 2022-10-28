<?php

namespace App\Http\Controllers\Agent\Customer;

use App\Http\Controllers\Controller;
use App\Models\Core\Package;
use Illuminate\Http\Request;

class CreatePartCustomerController extends Controller
{
    public function info()
    {
        return view('agent.customer.create.part.info');
    }

    public function pro(Request $request)
    {
        session()->put('perso', $request->except('_token'));

        return view('agent.customer.create.part.pro');
    }

    public function package(Request $request)
    {
        session()->put('rent', $request->except('_token'));

        return view('agent.customer.create.part.package');
    }

    public function card(Request $request)
    {
        session()->put('package', Package::find($request->get('package_id')));
        $rent = session('rent');
        dd($rent);

        return view('agent.customer.create.part.card');
    }
}

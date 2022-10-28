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
        $calc_rent = $rent['pro_incoming']+$rent['patrimoine'];
        $calc_charge = $rent['rent']+$rent['divers']+$rent['credit'];

        $calc = ($calc_rent-$calc_charge) / 2;
        if($calc > 7500) {
            $differed_amount = 7500;
        } else {
            $differed_amount = $calc;
        }

        return view('agent.customer.create.part.card', ['differed_amount' => $differed_amount]);
    }

    public function options(Request $request)
    {
        session()->put('card', $request->except('_token'));

        return view('agent.customer.create.part.options');
    }
}

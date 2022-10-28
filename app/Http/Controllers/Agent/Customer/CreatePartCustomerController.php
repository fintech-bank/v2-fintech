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
        $calc_rent = $rent['pro_incoming'] + $rent['patrimoine'];
        $calc_charge = $rent['rent'] + $rent['divers'] + $rent['credit'];

        $calc = ($calc_rent - $calc_charge) / 2;
        if ($calc > 7500) {
            $differed_amount = 7500;
        } else {
            $differed_amount = $calc;
        }

        return view('agent.customer.create.part.card', ['differed_amount' => $differed_amount]);
    }

    public function options(Request $request)
    {
        session()->put('card', $request->except('_token'));
        //dd(session()->all());
        $rent = session('rent');
        $incoming = $rent['pro_incoming'] + $rent['patrimoine'];
        $overdraft = $this->calcOverdraft($incoming, $rent['pro_category']);

        dd($overdraft);

        return view('agent.customer.create.part.options', [
            'overdraft' => $overdraft
        ]);
    }

    private function calcOverdraft($incoming, $situation)
    {
        $r = 0;
        $taux = 5.67;

        $result = $incoming / 3;

        if ($result <= 300) {
            $r--;
            $reason = "Votre revenue est inférieur à " . eur(300);
        } else {
            $r++;
        }

        if ($situation != 'Sans Emploie') {
            $r++;
        } else {
            $reason = "Votre situation professionnel ne permet pas un découvert bancaire";
            $r--;
        }

        if ($r == 2) {
            return [
                'access' => true,
                'value' => $result > 1000 ? 1000 : ceil($result / 100) * 100,
                'taux' => $taux." %"
            ];
        } else {
            return [
                'access' => false,
                'error' => $reason,
            ];
        }
    }
}

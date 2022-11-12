<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerBeneficiaire;
use App\Notifications\Customer\NewBeneficiaireNotification;
use Illuminate\Http\Request;
use Intervention\Validation\Rules\Iban;

class BeneficiaireController extends Controller
{
    public function store($customer_id, Request $request)
    {
        $request->validate([
            'type' => 'required',
            'bankname' => 'required',
            'iban' => new Iban()
        ]);

        $beneficiaire = CustomerBeneficiaire::create([
            'uuid' => \Str::uuid(),
            'type' => $request->get('type'),
            'company' => $request->get('type') != 'retail' ? $request->get('company') : null,
            'civility' => $request->get('type') == 'retail' ? $request->get('civility') : null,
            'firstname' => $request->get('type') == 'retail' ? $request->get('firstname') : null,
            'lastname' => $request->get('type') == 'retail' ? $request->get('lastname') : null,
            'bankname' => $request->get('bankname'),
            'iban' => $request->get('iban'),
            'bic' => $request->get('bic'),
            'titulaire' => $request->has('titulaire') ? 1 : 0,
            'customer_id' => $customer_id,
            'bank_id' => $request->get('bank_id')
        ]);

        $beneficiaire->customer->info->notify(new NewBeneficiaireNotification($beneficiaire->customer));

        return response()->json();
    }
}

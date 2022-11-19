<?php

namespace App\Http\Controllers\Api\Insurance;

use App\Helper\RequestHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerInsurance;
use App\Models\Customer\CustomerInsuranceClaim;
use Request;


class ClaimController extends Controller
{
    public function store($insurance_reference, Request $request)
    {
        $insurance = CustomerInsurance::where('reference', $insurance_reference)->first();

        $claim = $insurance->claims->create([
            'reference' => generateReference(),
            'responsability' => $request->has('responsability'),
            'incidentDate' => $request->get('incidentDate'),
            'incidentTime' => $request->get('incidentTime'),
            'incidentDesc' => $request->get('incidentDesc'),
            'customer_insurance_id' => $insurance->id,
        ]);

        if(auth()->user()->agent) {
            ob_start();
            ?>
            <p>La déclaration de sinitre <strong>N°<?= $claim->reference ?></strong> à été créé ce jour.</p>
            <p>Veuillez revoir les informations ci-dessous et valider cette déclaration.</p>
            <ul>
                <li><strong>Référence de l'incident:</strong> <?= $claim->reference; ?></li>
                <li><strong>Date / Heure de l'incident:</strong> <?= $claim->incidentDate->format('d/m/Y'); ?> <?= $claim->incidentTime->format('H:i'); ?></li>
                <li><strong>Etes-vous responsable ?</strong> <?= $claim->responsability ? 'OUI' : 'NON' ?></li>
                <li><strong>Description de l'incident:</strong> <?= $claim->incidentDesc ?></li>
            </ul>
            <p>Vous devez également nous soumettre un ou plusieurs justificatifs en relation avec ce sinistre.</p>
            <x-form.input-file
                name="justificatif"
                label="Justificatif du sinistre" />
            <?php
            $comment = ob_get_clean();
            RequestHelper::create(
                $insurance->customer,
                'Accepter la déclaration de sinistre',
                $comment,
                CustomerInsuranceClaim::class,
                $claim->id,
            );
        }

        return response()->json();
    }
}

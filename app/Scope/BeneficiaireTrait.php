<?php

namespace App\Scope;

use Illuminate\Support\Str;

trait BeneficiaireTrait
{
    public function createBenef($type, $bankname, $iban, $bic, $company = null, $civility = null, $firstname = null, $lastname = null, $titulaire = 0)
    {
        return $this->create([
            'uuid' => Str::uuid(),
            'type' => $type,
            'company' => $company,
            'civility' => $civility,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'bankname' => $bankname,
            'iban' => $iban,
            'bic' => $bic,
            'titulaire' => $titulaire,
        ]);
    }
}

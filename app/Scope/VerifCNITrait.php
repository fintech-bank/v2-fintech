<?php

namespace App\Scope;

use App\Helper\CountryHelper;
use Carbon\Carbon;

trait VerifCNITrait
{
    public static function version1992(
        string $cni_number1,
        string $cni_number2,
        string $pays,
        string $nom_famille,
        string $departement,
        string $bithdate,
        string $sexe
    )
    {
        $lenght = \Str::length($cni_number1.$cni_number2);

        if($lenght >= 10 && $lenght <= 72) {
            return 'true';
        } else {
            return 'false';
        }
    }
}

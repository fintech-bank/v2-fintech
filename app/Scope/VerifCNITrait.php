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
            dd(strpos($cni_number1, 'ID'));
            if(!strpos($cni_number1, 'ID')) {
                return false;
            }

            if(!strpos($cni_number1, CountryHelper::getCountryByName($pays, 'cca3'))) {
                return false;
            }

            if(!strpos($cni_number1, \Str::upper($nom_famille))) {
                return false;
            }

            if(!strpos($cni_number1, $departement)) {
               return false;
            }

            // deuxième ligne
            if(!strpos($cni_number2, Carbon::createFromTimestamp(strtotime($bithdate))->format('ymd'))) {
                return false;
            }

            if(!strpos($cni_number2, $sexe)) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
}

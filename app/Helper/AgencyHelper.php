<?php

namespace App\Helper;

use App\Models\Core\Agency;
use Illuminate\Support\Str;

class AgencyHelper
{
    public static function getOnline($online)
    {
        if ($online == true) {
            return '<span class="badge badge-success">Banque en ligne</span>';
        } else {
            return '<span class="badge badge-primary">Agence bancaire</span>';
        }
    }

    public static function generateBic($agencyName)
    {
        $replace = Str::replace(' ', '', $agencyName);
        $rep2 = Str::replace('FINTECH', '', $replace);

        $bic =  "FINFRPP".Str::limit($rep2, 3, '');

        $agence = Agency::where('bic', $bic)->count();

        if($agence == 0) {
            return $bic;
        } else {
            return $bic.$agence;
        }
    }
}

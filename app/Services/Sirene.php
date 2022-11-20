<?php

namespace App\Services;

class Sirene
{
    public static function siren($siren)
    {
        return collect(\Http::withToken('05c06cd6-ef2c-3c8c-bf55-f4e757d5c113')->post('https://api.insee.fr/entreprises/sirene/V3/siren', ["q" => "siren:".$siren])->object());
    }

    public static function siret($siret)
    {
        return \Http::withToken('05c06cd6-ef2c-3c8c-bf55-f4e757d5c113')->post('https://api.insee.fr/entreprises/sirene/V3/siret', ["q" => "siret:".$siret])->body();
    }
}

<?php

namespace App\Services;

class Sirene
{
    public static function siren($siren)
    {
        return collect(\Http::withBasicAuth(config("insee.consumer_key"), config("insee.consumer_secret"))->post('https://api.insee.fr/entreprises/sirene/V3/siren', ["q" => "siren:".$siren])->object());
    }

    public static function siret($siret)
    {
        return \Http::withBasicAuth(config("insee.consumer_key"), config("insee.consumer_secret"))->post('https://api.insee.fr/entreprises/sirene/V3/siren', ["q" => "siret:".$siret])->status();
    }
}

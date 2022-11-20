<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GeoHelper
{
    /**
     * Liste des Pays
     *
     * @return mixed
     */
    public static function getAllCountries()
    {
        return \Http::get('https://countriesnow.space/api/v0.1/countries/flag/images')->object()->data;
    }

    /**
     * Liste des villes par pays
     *
     * @param  string  $country // Pays sous format entier
     * @return mixed
     */
    public static function getCitiesFromCountry($country)
    {
        return \Http::post('https://countriesnow.space/api/v0.1/countries/cities', ['country' => \Str::lower($country)])->object()->data;
    }

    public static function getStateFromCountry($country)
    {
        return collect(Http::post('https://countriesnow.space/api/v0.1/countries/states', ['country' => Str::lower($country)])->object()->data->states)->all();
    }

    public static function getSingleCountry($country)
    {
        return Http::post('https://countriesnow.space/api/v0.1/countries/flag/images', ['country' => Str::lower($country)])->object()->data;
    }
}

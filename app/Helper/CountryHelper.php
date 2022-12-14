<?php

namespace App\Helper;

class CountryHelper
{
    public static function getCountryName($code)
    {
        $response = collect(\Http::get('https://restcountries.com/v3.1/alpha/'.$code)->object());

        return $response->first()->name->common;
    }
}

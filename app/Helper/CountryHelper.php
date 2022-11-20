<?php

namespace App\Helper;

class CountryHelper
{
    public static function getAll()
    {
        $response = collect(\Http::get('https://restcountries.com/v3.1/all')->object());

        return $response->all();
    }

    public static function getCountryName($code)
    {
        $response = collect(\Http::get('https://restcountries.com/v3.1/alpha/'.$code)->object());

        return $response->first()->name->common;
    }

    public static function getCountryByName($pays, $field = null)
    {
        $response = collect(\Http::get('https://restcountries.com/v3.1/name/'.$pays)->object());

        return $field ? $response->first()->$field : $response->first()->name->common;
    }
}

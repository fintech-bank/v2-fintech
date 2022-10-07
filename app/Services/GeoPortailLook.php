<?php


namespace App\Services;


use GuzzleHttp\Client;

class GeoPortailLook
{
    public static function call($fullAddress)
    {
        $client = new Client();

        $call = $client->request('GET', 'https://api-adresse.data.gouv.fr/search/?q='.$fullAddress)
            ->getBody()->getContents();

        return json_decode($call);
    }
}

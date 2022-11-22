<?php

namespace App\Services;

class Mapbox
{
    /**
     * insurance/supermarket/bar/contractor/shopping center
     * @return object|array
     */
    public function call(): object|array
    {
        $cat = ['insurance', 'supermarket', 'bar', 'contractor', 'shopping center'];
        $data = [
            'type' => 'poi',
            'limit' => 5,
            'language' => 'fr',
            'country' => 'fr',
            'proximity' => '-1.795493,46.492958',
            'access_token' => config('services.mapbox.api_key')
        ];
        return \Http::get('https://api.mapbox.com/geocoding/v5/mapbox.places/'.$cat[rand(0,4)].'.json', $data)->object();
    }
}

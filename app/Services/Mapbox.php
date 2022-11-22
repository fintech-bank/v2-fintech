<?php

namespace App\Services;

class Mapbox
{
    /**
     * insurance/supermarket/bar/contractor/shopping center
     * @param $category
     * @return object|array
     */
    public function call($category): object|array
    {
        $data = [
            'type' => 'poi',
            'limit' => 5,
            'language' => 'fr',
            'country' => 'fr',
            'proximity' => request()->ip() != '192.168.1.254' ? request()->ip() : '82.66.205.152',
            'access_token' => config('services.mapbox.api_key')
        ];
        return \Http::get('https://api.mapbox.com/geocoding/v5/mapbox.places/'.$category.'.json', $data)->object();
    }
}

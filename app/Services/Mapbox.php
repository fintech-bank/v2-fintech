<?php

namespace App\Services;

class Mapbox
{
    public function call()
    {
        return \Http::get('https://api.mapbox.com/geocoding/v5/mapbox.places/airport.json?type=poi&proximity=-74.70850,40.78375&access_token='.config('services.mapbox.api_key'))->object();
    }
}

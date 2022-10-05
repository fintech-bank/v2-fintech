<?php


namespace App\Services;


class Persona
{
    protected $endpoint;
    protected $api_key;

    public function __construct()
    {
        $this->endpoint = 'https://withpersona.com/api/v1/';
        $this->api_key = config('persona-kyc.api_key');
    }


}

<?php


namespace App\Services\Yousign;


use App\Helper\LogHelper;
use App\Models\Customer\Customer;
use GuzzleHttp\Client;

class YousignApi
{
    protected $endpoint;
    protected $api_key;
    protected $client;

    public function __construct()
    {
        $this->endpoint = "https://api-sandbox.yousign.app/v3";
        $this->api_key = config('services.yousign.api_key');
        $this->client = new Client();
    }

}

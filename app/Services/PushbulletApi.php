<?php


namespace App\Services;


use App\Helper\CustomerHelper;
use App\Models\Customer\Customer;
use GuzzleHttp\Client;
use Jenssegers\Agent\Agent;

class PushbulletApi
{
    protected $api_key;
    protected $endpoint;
    protected $client;

    public function __construct()
    {
        $this->api_key = config('services.pushbullet.access_token');
        $this->endpoint = 'https://api.pushbullet.com/v2';
        $this->client = new Client();
    }

    public function createDevice($firstname, $lastname)
    {
        $agent = new Agent();
        $data = [
            'nickname' => $agent->deviceType().' '.$firstname.' '.$lastname,
            'model' => $agent->deviceType(),
            'manufacturer' => $agent->platform(),
            'icon' => $this->getIcon($agent->deviceType())
        ];

        $response = $this->client->request('POST', $this->endpoint.'/devices', [
            'headers' => [
                'Access-Token' => $this->api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]);

        return json_decode($response->getBody()->getContents());
    }

    private function getIcon($deviceType)
    {
        switch ($deviceType) {
            case 'desktop': return 'desktop';
            case 'phone': return 'phone';
            case 'tablet': return 'tablet';
            case 'robot': return 'system';
        }
    }

}

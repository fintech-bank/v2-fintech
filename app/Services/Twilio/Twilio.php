<?php


namespace App\Services\Twilio;


use App\Helper\LogHelper;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class Twilio
{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $twilio_sid;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $verify_sid;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $token;

    public $client;

    public function __construct()
    {
        $this->twilio_sid = config('services.twilio.twilio_sid');
        $this->token = config('services.twilio.twilio_auth_token');
        $this->verify_sid = config('services.twilio.twilio_verify_sid');
        try {
            $this->client = new Client($this->twilio_sid, $this->token);
        } catch (ConfigurationException $e) {
            LogHelper::notify('critical', $e);
        }
    }
}

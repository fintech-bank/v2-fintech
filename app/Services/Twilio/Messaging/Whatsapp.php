<?php


namespace App\Services\Twilio\Messaging;


use App\Helper\LogHelper;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class Whatsapp extends \App\Services\Twilio\Twilio
{
    private static $client;

    public function __construct()
    {
        parent::__construct();
        self::$client = new Client($this->twilio_sid, $this->token);
    }

    public static function sendNotification($mobile, $message)
    {
        try {
            self::$client->messages->create("whatsapp:$mobile", [
                'body' => $message,
                'from' => config('app.env') == 'local' ? 'whatsapp:+14155238886' : 'whatsapp:+33749061225'
            ]);
        } catch (TwilioException $e) {
            LogHelper::notify('critical', $e);
        }
    }
}

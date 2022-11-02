<?php

namespace App\Services;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class FreeSmsChannel
{
    private string $api_key;
    public function __construct()
    {
        $this->api_key = 'KEWdAAgYYE5V5p';
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toFreeSms($notifiable);
        Http::post('https://smsapi.free-mobile.fr/', [
            'user' => 49176297,
            'pass' => $this->api_key,
            'msg' => $message
        ]);
    }
}

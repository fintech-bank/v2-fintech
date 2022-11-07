<?php

namespace App\Helper;

use Illuminate\Notifications\Notification;

abstract class MyNotification extends Notification
{
    public $message;
    public string $link;

    public function __construct()
    {
        $this->message = $this->getMessage();
        $this->link = "/customer/prlv/".$this->sepa->uuid;
    }

    public function getMessage(){

    }
}

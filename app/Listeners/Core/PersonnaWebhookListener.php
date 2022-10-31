<?php

namespace App\Listeners\Core;

use App\Events\Core\PersonnaWebbhookEvent;
use App\Helper\LogHelper;

class PersonnaWebhookListener
{
    public function __construct()
    {
    }

    public function handle(PersonnaWebbhookEvent $event)
    {
        LogHelper::notify('notice', 'Retour Persona Webhook:', $event);
        dd($event);
    }
}

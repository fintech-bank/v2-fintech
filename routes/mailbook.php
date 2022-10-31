<?php

use App\Mail\MailbookMail;
use Xammie\Mailbook\Facades\Mailbook;

Mailbook::add(MailbookMail::class);
Mailbook::add(function () {
    $customer = \App\Models\Customer\Customer::find(1);
    $link = '/test';
    return new \App\Notifications\Customer\SendVerificationLinkNotification($customer, $link);
});

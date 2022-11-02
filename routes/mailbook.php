<?php

use App\Mail\MailbookMail;
use Xammie\Mailbook\Facades\Mailbook;

Mailbook::add(MailbookMail::class);
Mailbook::add(function () {
    $customer = \App\Models\Customer\Customer::find(1);
    $link = '/';

    return new \App\Mail\Customer\SendVerificationLinkMail($customer, $link);
});

Mailbook::add(function () {
    $customer = \App\Models\Customer\Customer::find(1);

    return new \App\Mail\Customer\UpdateStatusAccountMail($customer, $customer->status_open_account);
});

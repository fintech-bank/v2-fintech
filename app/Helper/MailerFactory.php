<?php


namespace App\Helper;


use Illuminate\Contracts\Mail\Mailer;

class MailerFactory
{
    protected $mailer;
    protected $fromAddress = '';
    protected $fromName = '';

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->fromAddress = config('mail.from.address');
        $this->fromName = config('mail.from.name');
    }
}

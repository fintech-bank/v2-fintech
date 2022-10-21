<?php


namespace App\Helper;


use App\Models\User;
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

    public function sendMailboxEmail($mailbox)
    {
        try {
            foreach ($mailbox->receivers as $receiver) {
                $user = User::find($receiver->receiver_id);
                $this->mailer->send("emails.mailbox.mailbox_send", ['user' => $user, 'mailbox' => $mailbox], function ($message) use ($user, $mailbox) {
                    $message->from($this->fromAddress, $this->fromName)
                        ->to($user->email)->subject($mailbox->subject);
                    if($mailbox->attachments->count() > 0) {
                        foreach($mailbox->attachments as $attachment) {
                            $message->attach(public_path('uploads/mailbox/' . $attachment->attachment));
                        }
                    }
                });
            }
        } catch (\Exception $ex) {
            die("Mailer Factory error: " . $ex->getMessage());
        }
    }
}

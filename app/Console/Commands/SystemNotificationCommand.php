<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SystemNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:notification {dossier} {notification}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate My Notification';
    protected Filesystem $files;

    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $folder = $this->argument('dossier');
        $file = $this->argument('notification');

        $f = "${file}.php";
        $path = app_path('/app/Notifications');

        $f = $path."/${folder}/$f";
        $pathNotif = $path."/${folder}";

        if($this->files->isDirectory($pathNotif)) {
            if($this->files->isFile($f))
                $this->error($file." Le fichier existe déja !");

            if(!$this->files->put($f, $this->content($folder, $file)))
                $this->error('Something went wrong!');

            $this->info("Fichier Généré: ".$f);
        } else {
            $this->files->makeDirectory($pathNotif, 0777, true, true);
            if(!$this->files->put($f, $this->content($folder, $file)))
                $this->error('Something went wrong!');
            $this->info("Fichier Généré: ".$f);
        }
    }

    private function content($folder, $file)
    {
$content = '
<?php
namespace App\Notification\.'.$folder.'

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\CustomerSepa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class '.$file.'
{

    public string $title;
    public string $link;
    public string $message;

    public function __construct()
    {
        $this->title = "";
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        $message = "";
        return $message;
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->sepa->wallet->customer->setting->notif_sms) {
                return [FreeMobileChannel::class];
            }

            if($this->sepa->wallet->customer->setting->notif_mail) {
                return "mail";
            }

            return "database";
        } else {

            if($this->sepa->wallet->customer->setting->notif_sms) {
                return [TwilioChannel::class];
            }

            if($this->sepa->wallet->customer->setting->notif_mail) {
                return "mail";
            }

            return "database";
        }
    }

    public function via($notifiable)
    {
        return $this->choiceChannel();
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "",
            "color" => "",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }

    public function toFreeMobile($notifiable)
    {
        $message = (new FreeMobileMessage());
        $message->message(strip_tags($this->message));

        return $message;
    }

    public function toTwilio($notifiable)
    {
        $message = (new TwilioSmsMessage());
        $message->content(strip_tags($this->message));

        return $message;
    }
}
?>
';
    return $content;
    }
}

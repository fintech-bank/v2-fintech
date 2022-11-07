<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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
        $camel = \Str::snake($file);
        $viewFileName = \Str::replace('_notification', '', $camel);
        $path = app_path('Notifications');

        $f = $path."/${folder}/$f";
        $pathNotif = $path."/${folder}";
        $pathView = "/resources/views/emails/".\Str::lower($folder);
        $fileView = "${viewFileName}.blade.php";

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
        $namespace = "App\Notifications\\${folder}";
        $view_mail = \Str::camel($file);
$content = '
<?php
namespace '.$namespace.';

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class '.$file.' extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->title = "";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->customer = $customer;
    }

    private function getMessage()
    {
        $message = "";
        return $message;
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->customer->setting->notif_sms) {
                return [FreeMobileChannel::class];
            }

            if($this->customer->setting->notif_mail) {
                return "mail";
            }

            return "database";
        } else {

            if($this->customer->setting->notif_sms) {
                return [TwilioChannel::class];
            }

            if($this->customer->setting->notif_mail) {
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
        $message->view("emails.customer.'.$view_mail.'", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

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

    private function contentView()
    {

    }
}

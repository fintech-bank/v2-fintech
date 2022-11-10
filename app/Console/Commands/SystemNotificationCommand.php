<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class SystemNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:notification {dossier} {notification} {--no-sms}';

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
     * Renvoie le nom en majuscule singulier
     * @param $notification
     * @return string
     */
    public function getSingularClassName($notification)
    {
        return ucwords(Pluralizer:: singular($notification));
    }

    /**
     * Renvoie le chemin du fichier stub
     * @return string
     *
     */
    public function getStubPath()
    {
        if ($this->option('no-sms')) {
            return __DIR__ . '/../../../Stubs/notification_no_sms.stub';
        } else {
            return __DIR__ . '/../../../Stubs/notification.stub';
        }
    }

    /**
     **
     * Mappez les variables de stub présentes dans stub à sa valeur
     *
     * @return array
     *
     */
    public function getStubVariables()
    {
        return [
            'NAMESPACE' => 'App\\Notifications\\'.$this->argument('dossier'),
            'CLASS_NAME' => $this->getSingularClassName($this->argument('notification'))."Notification",
            'VIEW_FILE_NAME' => \Str::replace('Send', '', \Str::snake($this->getSingularClassName($this->argument('notification'))))
        ];
    }

    /**
     * Récupère le chemin du stub et les variables du stub
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables ());
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('$'.$search.'$' , $replace, $contents);
        }

        return $contents;

    }

    /**
     * Récupère le chemin complet de la classe de génération
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('app/Notifications') .'/'.$this->argument('dossier').'/' .$this->getSingularClassName($this->argument('notification')) . 'Notification.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $path = $this->getSourceFilePath();
        $this->makeDirectory(dirname($path));
        $contents = $this->getSourceFile();
        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }


    }

    private function content($folder, $file, $viewFileName)
    {
        $namespace = "App\Notifications\\${folder}";

        $content = '

?>
';
        return $content;
    }

    private function contentView()
    {

    }
}

<?php

namespace App;

use MadWeb\Initializer\Contracts\Runner;

class Install
{
    public function production(Runner $run)
    {
        $run->external('composer', 'install', '--no-dev', '--prefer-dist', '--optimize-autoloader')
            ->external('cp', '.env.prod', '.env')
            ->artisan('key:generate', ['--force' => true])
            ->external('php', 'artisan', 'system:seed', '--base')
            ->artisan('storage:link')
    //            ->dispatch(new MakeCronTask)
            ->external('npm', 'install', '--production')
            ->external('npm', 'run', 'production')
            ->artisan('system:clear')
            ->external('screen', '-dmS', 'schedule', 'php', 'artisan', 'schedule:work')
            ->external('screen', '-dmS', 'schedule', 'php', 'artisan', 'queue:work');
    }

    public function local(Runner $run)
    {
        $run->external('composer', 'install')
            ->artisan('key:generate')
            ->external('php', 'artisan', 'system:seed', '--base')
            ->artisan('storage:link')
            ->external('npm', 'install')
            ->external('npm', 'run', 'development')
            ->artisan('system:clear')
            ->external('screen', '-dmS', 'schedule', 'php', 'artisan', 'schedule:work')
            ->external('screen', '-dmS', 'schedule', 'php', 'artisan', 'queue:work');
    }
}

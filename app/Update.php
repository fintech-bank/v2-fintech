<?php

namespace App;

use MadWeb\Initializer\Contracts\Runner;

class Update
{
    public function production(Runner $run)
    {
        $run->artisan('down')
            ->external('composer', 'install', '--no-dev', '--prefer-dist', '--optimize-autoloader')
            ->external('npm', 'install', '--production')
            ->external('npm', 'run', 'production')
            ->external('php', 'artisan', 'system:seed')
            ->artisan('system:clear')
            ->artisan('up');
    }

    public function local(Runner $run)
    {
        $run->artisan('down')
            ->external('composer', 'install')
            ->external('npm', 'install')
            ->external('npm', 'run', 'dev')
            ->external('php', 'artisan', 'system:seed')
            ->artisan('system:clear')
            ->artisan('up');
    }
}

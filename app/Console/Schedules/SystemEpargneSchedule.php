<?php

namespace App\Console\Schedules;

use Illuminate\Console\Scheduling\Schedule;

class SystemEpargneSchedule
{
    public static function boot(Schedule $schedule)
    {
        $schedule->command('epargne activeWallet')
            ->hourly();
    }
}

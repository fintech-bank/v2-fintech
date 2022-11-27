<?php

namespace App\Console\Schedules;

use Illuminate\Console\Scheduling\Schedule;

class SystemSepaSchedule
{
    public static function boot(Schedule $schedule)
    {
        $schedule->command('sepa processedSepa')
            ->everySixHours()
            ->days([2,6]);

    }
}

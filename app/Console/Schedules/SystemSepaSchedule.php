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

        $schedule->command('sepa processedTransaction')
            ->daily()
            ->twiceDailyAt(8,17)
            ->days([2,6]);

    }
}

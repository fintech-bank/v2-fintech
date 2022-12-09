<?php

namespace App\Console\Schedules;

use Illuminate\Console\Scheduling\Schedule;

class SystemTransactionSchedule
{
    public static function boot(Schedule $schedule)
    {
        $schedule->command('transaction transactionComing')
            ->hourly()
            ->twiceDailyAt(8,17)
            ->days([2,6]);

    }
}

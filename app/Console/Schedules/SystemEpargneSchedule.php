<?php

namespace App\Console\Schedules;

use Illuminate\Console\Scheduling\Schedule;

class SystemEpargneSchedule
{
    public static function boot(Schedule $schedule)
    {
        $schedule->command('epargne activeWallet')
            ->hourly()
            ->days([2,6]);

        $schedule->command('epargne executeCalcProfitEpargne')
            ->twiceDailyAt(8,17)
            ->days([2,6]);

        $schedule->command('epargne virProfitEpargne')
            ->twiceDailyAt(8,17)
            ->days([2,6]);
    }
}

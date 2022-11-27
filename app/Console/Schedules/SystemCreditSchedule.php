<?php

namespace App\Console\Schedules;

use Illuminate\Console\Scheduling\Schedule;

class SystemCreditSchedule
{
    public static function boot(Schedule $schedule)
    {
        $schedule->command("credit verifRequestLoanOpen")
            ->everySixHours()
            ->twiceDailyAt(8,17)
            ->days([2,6]);

        $schedule->command("credit chargeLoanAccepted")
            ->dailyAt("08:00:00")
            ->days([2,6]);
    }
}

<?php

namespace App\Console\Schedules;

use Illuminate\Console\Scheduling\Schedule;

class SystemCustomerSchedule
{
    public static function boot(Schedule $schedule)
    {
        $schedule->command('customer updateCotation')
            ->daily()
            ->description("Mise à jour des cotation client [log]");

        $schedule->command('customer executeActiveAccount')
            ->everySixHours()
            ->description("Passage des compte accepté à terminer [log]'");
    }
}

<?php

namespace App\Console\Schedules;

use Illuminate\Console\Scheduling\Schedule;

class SystemCheckSchedule
{
    public static function boot(Schedule $schedule)
    {
        $schedule->command('check setManufactureCheck')
            ->everySixHours()
            ->days([2,6]);

        $schedule->command('check setShipCheck')
            ->everySixHours()
            ->days([2,6]);

        $schedule->command('check setAvailableCheck')
            ->everySixHours()
            ->days([2,6]);

    }
}

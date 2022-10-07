<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // Administration
        $schedule->command('system:admin deleteLog')
            ->twiceMonthly(1, 16, '00:00')
            ->description("Suppression des logs bancaire")
            ->emailOutputTo(config('mail.from.address'));

        $schedule->command('system:admin shipTpe')
            ->dailyAt('08:00')
            ->description("Mise à jour des trackers d'envoie")
            ->emailOutputTo(config('mail.from.address'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require_once base_path('routes/console.php');
    }
}

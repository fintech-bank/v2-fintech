<?php

namespace App\Console\Schedules;

use Illuminate\Console\Scheduling\Schedule;

class SystemAdminSchedule
{
    public static function boot(Schedule $schedule)
    {
        $schedule->command('system:admin deleteLog')
            ->twiceMonthly(1, 16, '00:00')
            ->description("Suppression des logs bancaires [log]");

        $schedule->command('system:admin shipTpe')
            ->dailyAt('08:00')
            ->description("Mise à jour des trackers d'envoie [log]");

        $schedule->command('system:admin generateInvoiceReseller')
            ->lastDayOfMonth()
            ->description("Génération des factures des distributeurs [log]");

        $schedule->command('system:admin notifyResellerInvoicePayment');
    }
}

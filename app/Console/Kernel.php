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

        $schedule->command('system:admin generateInvoiceReseller')
            ->lastDayOfMonth()
            ->description("Génération des factures des distributeurs")
            ->emailOutputTo(config('mail.from.address'));

        $schedule->command('system:admin notifyResellerInvoicePayment')
            ->daily()
            ->description("Paiement des factures de distributeur")
            ->emailOutputTo(config('mail.from.address'));


        // Agent
        $schedule->command('system:agent calendarAlert')
            ->everyFiveMinutes()
            ->description("Alert Evenement");

        $schedule->command('system:agent updateCotation')
            ->daily()
            ->description("Mise à jour des cotation client")
            ->emailOutputTo(config('mail.from.address'));

        // Life
        $schedule->command("life generateCustomers")
            ->everyFourHours()
            ->between('08:00','20:00')
            ->description("Nouveau client")
            ->emailOutputTo(config('mail.from.address'));

        $schedule->command("life generateSalary")
            ->monthlyOn(1)->at('08:00')
            ->description("Virement des Salaires")
            ->emailOutputTo(config('mail.from.address'));

        $schedule->command("life generateDebit")
            ->hourly()
            ->between('08:00','23:59')
            ->description("Génération des débits bancaires")
            ->emailOutputTo(config('mail.from.address'));

        $schedule->command("life generatePrlvSepa")
            ->everySixHours()
            ->between('08:00','17:00')
            ->description("Nouveau prélèvement SEPA")
            ->emailOutputTo(config('mail.from.address'));

        $schedule->command("life generateMensualReleve")
            ->monthlyOn(30)->at('08:00')
            ->description("Génération des débits bancaires")
            ->emailOutputTo(config('mail.from.address'));

        $schedule->command("life limitWithdraw")
            ->dailyAt('08:00')
            ->description("Suppression des retraits bancaire non effectuer/valider")
            ->emailOutputTo(config('mail.from.address'));

        $schedule->command("life alerta")
            ->weeklyOn(7)
            ->between('08:00', '17:00')
            ->description("Envoie d'un relevé flash")
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

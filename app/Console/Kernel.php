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
            ->description("Suppression des logs bancaires [log]");

        $schedule->command('system:admin shipTpe')
            ->dailyAt('08:00')
            ->description("Mise à jour des trackers d'envoie [log]");

        $schedule->command('system:admin generateInvoiceReseller')
            ->lastDayOfMonth()
            ->description("Génération des factures des distributeurs [log]");

        $schedule->command('system:admin notifyResellerInvoicePayment');


        // Agent
        /*$schedule->command('system:agent calendarAlert')
            ->everyFiveMinutes()
            ->description("Alert Evenement [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Alerte d'évènement", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Alerte d'évènement", $output);
            });*/

        $schedule->command('system:agent updateCotation')
            ->daily()
            ->description("Mise à jour des cotation client [log]");

        $schedule->command('system:agent verifRequestLoanOpen')
            ->everySixHours()
            ->description("Vérification des pret ouvert et les met en étude [log]");

        $schedule->command('system:agent chargeLoanAccepted')
            ->dailyAt('08:00:00')
            ->description("Libération du montant du pret bancaire [log]");

        $schedule->command('system:agent executeSepaOrders')
            ->everySixHours()
            ->description("Execution des prélèvements bancaires [log]");

        $schedule->command('system:agent executeTransactionComing')
            ->everySixHours()
            ->description("Execution des transactions entrente [log]");

        $schedule->command('system:agent executeActiveAccount')
            ->everySixHours()
            ->description("Passage des compte accepté à terminer [log]'");

        $schedule->command('system:agent executeVirement')
            ->everySixHours()
            ->description("Exécution des virements bancaires [log]");

        $schedule->command('system:agent executeCalcProfitEpargne')
            ->everySixHours()
            ->description("Calcul des profits des comptes épargnes");

        // Life
        $schedule->command("life generateCustomers")
            ->hourly()
            ->between('08:00','20:00')
            ->description("Nouveau client [log]");

        $schedule->command("life generateSalary")
            ->monthlyOn(1)->at('08:00')
            ->description("Virement des Salaires [log]");

        $schedule->command("life generateDebit")
            ->hourly()
            ->between('08:00','23:59')
            ->description("Génération des débits bancaires [log]");

        $schedule->command("life generatePrlvSepa")
            ->everySixHours()
            ->between('08:00','17:00')
            ->description("Nouveau prélèvement SEPA [log]");

        $schedule->command("life generateMensualReleve")
            ->monthlyOn(30)->at('08:00')
            ->description("Génération des relevés bancaires [log]");

        $schedule->command("life limitWithdraw")
            ->dailyAt('08:00')
            ->description("Suppression des retraits bancaire non effectuer/valider [log]");

        $schedule->command("life alerta")
            ->weeklyOn(7)
            ->between('08:00', '17:00')
            ->description("Envoie d'un relevé flash [log]");
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

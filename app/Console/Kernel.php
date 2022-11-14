<?php

namespace App\Console;

use App\Helper\LogHelper;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Stringable;
use macropage\LaravelSchedulerWatcher\LaravelSchedulerWatcher;

class Kernel extends ConsoleKernel
{
    use LaravelSchedulerWatcher;
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
            ->description("Suppression des logs bancaires [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', 'Suppression des logs bancaire', $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', 'Suppression des logs bancaire', $output);
            });

        $schedule->command('system:admin shipTpe')
            ->dailyAt('08:00')
            ->description("Mise à jour des trackers d'envoie [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Mise à jours des trackers d'envoie", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Mise à jours des trackers d'envoie", $output);
            });

        $schedule->command('system:admin generateInvoiceReseller')
            ->lastDayOfMonth()
            ->description("Génération des factures des distributeurs [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Génération des factures des distributeur", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Génération des factures des distributeur", $output);
            });

        $schedule->command('system:admin notifyResellerInvoicePayment')
            ->daily()
            ->description("Paiement des factures de distributeur [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Paiement des factures de distributeur", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Paiement des factures de distributeur", $output);
            });


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
            ->description("Mise à jour des cotation client [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Mise à jours des cotations clients", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Mise à jours des cotations clients", $output);
            });

        $schedule->command('system:agent verifRequestLoanOpen')
            ->everySixHours()
            ->description("Vérification des pret ouvert et les met en étude [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Vérification des pret ouvert et les mets en étude", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Vérification des pret ouvert et les mets en étude", $output);
            });

        $schedule->command('system:agent chargeLoanAccepted')
            ->dailyAt('08:00:00')
            ->description("Libération du montant du pret bancaire [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Libération du montant du pret bancaire", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Libération du montant du pret bancaire", $output);
            });

        $schedule->command('system:agent executeSepaOrders')
            ->everySixHours()
            ->description("Execution des prélèvements bancaires [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Execution des prélèvements bancaires", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Execution des prélèvements bancaires", $output);
            });

        $schedule->command('system:agent executeTransactionComing')
            ->everySixHours()
            ->description("Execution des transactions entrente [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Transactions Entrentes", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Transactions Entrentes", $output);
            });

        $schedule->command('system:agent executeActiveAccount')
            ->everySixHours()
            ->description("Passage des compte accepté à terminer [log]'")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Passage des comptes accepté vers terminer", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Passage des comptes accepté vers terminer", $output);
            });

        $schedule->command('system:agent executeVirement')
            ->everySixHours()
            ->description("Exécution des virements bancaires [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Exécution des virements bancaires", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Exécution des virements bancaires", $output);
            });

        // Life
        $schedule->command("life generateCustomers")
            ->everyFourHours()
            ->between('08:00','20:00')
            ->description("Nouveau client [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Nouveau client", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Nouveau client", $output);
            });

        $schedule->command("life generateSalary")
            ->monthlyOn(1)->at('08:00')
            ->description("Virement des Salaires [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Virement des Salaires", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Virement des Salaires", $output);
            });

        $schedule->command("life generateDebit")
            ->hourly()
            ->between('08:00','23:59')
            ->description("Génération des débits bancaires [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Génération des débits bancaires", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Génération des débits bancaires", $output);
            });

        $schedule->command("life generatePrlvSepa")
            ->everySixHours()
            ->between('08:00','17:00')
            ->description("Nouveau prélèvement SEPA [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Nouveau prélèvement SEPA", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Nouveau prélèvement SEPA", $output);
            });

        $schedule->command("life generateMensualReleve")
            ->monthlyOn(30)->at('08:00')
            ->description("Génération des relevés bancaires [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Génération des relevés bancaires", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Génération des relevés bancaires", $output);
            });

        $schedule->command("life limitWithdraw")
            ->dailyAt('08:00')
            ->description("Suppression des retraits bancaire non effectuer/valider [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Suppression des retraits bancaire non effectuer/valider", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Suppression des retraits bancaire non effectuer/valider", $output);
            });

        $schedule->command("life alerta")
            ->weeklyOn(7)
            ->between('08:00', '17:00')
            ->description("Envoie d'un relevé flash [log]")
            ->onSuccess(function (Stringable $output) {
                LogHelper::notify('notice', "Envoie du relevé flash", $output);
            })
            ->onFailure(function(Stringable $output) {
                LogHelper::notify('alert', "Envoie du relevé flash", $output);
            });

        $this->monitor($schedule);
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

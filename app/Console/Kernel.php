<?php

namespace App\Console;

use App\Console\Schedules\SystemAdminSchedule;
use App\Console\Schedules\SystemCheckSchedule;
use App\Console\Schedules\SystemCreditSchedule;
use App\Console\Schedules\SystemCustomerSchedule;
use App\Console\Schedules\SystemEpargneSchedule;
use App\Console\Schedules\SystemSepaSchedule;
use App\Console\Schedules\SystemTransactionSchedule;
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
        SystemEpargneSchedule::boot($schedule);
        SystemAdminSchedule::boot($schedule);
        SystemCustomerSchedule::boot($schedule);
        SystemCreditSchedule::boot($schedule);
        SystemCheckSchedule::boot($schedule);
        SystemSepaSchedule::boot($schedule);
        SystemTransactionSchedule::boot($schedule);



        $schedule->command('system:agent executeVirement')
            ->everySixHours()
            ->description("Exécution des virements bancaires [log]");


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

        $schedule->command("life generateReseller")
            ->dailyAt('08:00')
            ->description("Nouveau Distributeur");

        $schedule->command("life GeneratePayment")
            ->everyFiveMinutes()
            ->description("Génération Payment CB");
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

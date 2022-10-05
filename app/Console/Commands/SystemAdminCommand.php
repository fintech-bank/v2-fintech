<?php

namespace App\Console\Commands;

use App\Models\Core\LogBanque;
use Illuminate\Console\Command;

class SystemAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:admin {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commande Administrateur';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'deleteLog':
                $this->DeleteLogBank();
                break;
        }

        return Command::SUCCESS;
    }

    private function DeleteLogBank() {
        $logs = LogBanque::all();
        $bar = $this->output->createProgressBar(count($logs));
        $bar->start();
        foreach ($logs as $log) {
            $log->delete();
            $bar->advance();
        }
        $bar->finish();
        $this->info("Suppression des logs bancaires: ".count($logs));
    }
}

<?php

namespace App\Console\Commands;

use App\Helper\CustomerMobilityHelper;
use App\Models\Customer\CustomerMobility;
use App\Services\BankFintech;
use App\Services\SlackNotifier;
use Carbon\Carbon;
use Illuminate\Console\Command;
use macropage\LaravelSchedulerWatcher\LaravelSchedulerCustomMutex;

class MobilityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mobility {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gestion de la vie des mobilités bancaires';

    public function __construct()
    {
        parent::__construct();
        $this->slack = new SlackNotifier('#fintech-site');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        match ($this->argument('action')) {
            "bank_end" => $this->bankEnd()
        };
        return Command::SUCCESS;
    }

    private function bankEnd()
    {
        $mobilities = CustomerMobility::all();
        $bank = new BankFintech();
        $arr = [];

        foreach ($mobilities as $mobility) {
            if ($mobility->status == 'bank_start' && Carbon::createFromTimestamp(strtotime($mobility->start))->addDays(5)->startOfDay() == now()->startOfDay()) {
                $call = $bank->callTransferDoc($mobility->customer, $mobility->customer->agency, $mobility->mandate);

                foreach ($call->prlv as $prlv) {
                    $mobility->prlvs()->create([
                        'uuid' => $prlv->uuid,
                        'creditor' => $prlv->creditor,
                        'number_mandate' => $prlv->number_mandate,
                        'amount' => $prlv->amount,
                        'customer_mobility_id' => $mobility->id
                    ]);
                }

                foreach ($call->vir_incoming as $vir) {
                    $mobility->incomings()->create([
                        'uuid' => $vir->uuid,
                        'amount' => $vir->amount,
                        'reference' => $vir->reference,
                        'reason' => $vir->reason,
                        'type' => $vir->type,
                        'transfer_date' => $vir->transfer_date ? Carbon::createFromTimestamp(strtotime($vir->transfer_date)) : null,
                        'recurring_start' => $vir->recurring_start ? Carbon::createFromTimestamp(strtotime($vir->recurring_start)) : null,
                        'recurring_end' => $vir->recurring_end ? Carbon::createFromTimestamp(strtotime($vir->recurring_end)) : null,
                        'customer_mobility_id' => $mobility->id,
                    ]);
                }

                foreach ($call->vir_outgoing as $vir) {
                    $mobility->outgoings()->create([
                        'uuid' => $vir->uuid,
                        'amount' => $vir->amount,
                        'reference' => $vir->reference,
                        'reason' => $vir->reason,
                        'transfer_date' => Carbon::createFromTimestamp(strtotime($vir->transfer_date)),
                        'customer_mobility_id' => $mobility->id,
                    ]);
                }

                foreach ($call->cheques as $cheque) {
                    $mobility->cheques()->create([
                        'number' => $cheque->number,
                        'amount' => $cheque->amount,
                        'date_enc' => $cheque->date_enc->date,
                        'creditor' => $cheque->creditor,
                        'file_url' => config('domain.bank').'/storage/'.$mobility->mandate.'/check/'.$cheque->number.'.pdf',
                        'customer_mobility_id' => $mobility->id,
                    ]);
                }

                $mobility->update([
                    'status' => 'bank_return',
                    'comment' => $mobility->comment_text,
                    'updated_at' => now()
                ]);
            }
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->slack->send("Evoie des information de mobilié bancaire au banque");
    }
}

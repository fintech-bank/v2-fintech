<?php

namespace App\Console\Commands;

use App\Helper\CustomerHelper;
use App\Models\Core\Agency;
use App\Models\Core\Invoice;
use App\Models\Core\LogBanque;
use App\Models\Reseller\Reseller;
use App\Notifications\Customer\Customer\Reseller\NewInvoiceNotification;
use App\Notifications\Customer\Customer\Reseller\NewInvoicePaymentNotification;
use App\Services\SlackNotifier;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Console\Command;
use macropage\LaravelSchedulerWatcher\LaravelSchedulerCustomMutex;

class SystemAdminCommand extends Command
{
    use LaravelSchedulerCustomMutex;
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

    public function __construct()
    {
        $this->setSignature('system:admin {action}');
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
        if ($this->checkCustomMutex()) {
            return 0;
        }
        switch ($this->argument('action')) {
            case 'deleteLog':
                $this->DeleteLogBank();
                break;

            case 'shipTpe':
                $this->ShipTpe();
                break;

            case 'generateInvoiceReseller':
                $this->GenerateInvoiceReseller();
                break;
            case 'notifyResellerInvoicePayment':
                $this->NotifyResellerInvoicePayment();
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
        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->info("Suppression des logs bancaires: ".count($logs));
        $this->slack->send("Suppression des logs bancaires: ".count($logs));
    }

    private function ShipTpe()
    {
        $resellers = Reseller::all();
        $i = 0;

        foreach ($resellers as $reseller) {
            foreach ($reseller->shippings as $shipping) {
                if($shipping->updated_at->addDays(1)->startOfDay() == now()->startOfDay()) {
                    $shipping->tracks()->create([
                        'state' => 'prepared',
                        'shipping_id' => $shipping->id
                    ]);
                    $i++;
                } elseif ($shipping->updated_at->addDays(1)->startOfDay() == now()->startOfDay()) {
                    $shipping->tracks()->create([
                        'state' => 'in_transit',
                        'shipping_id' => $shipping->id
                    ]);
                    $i++;
                } elseif ($shipping->updated_at->addDays(2)->startOfDay() == now()->startOfDay()) {
                    $shipping->tracks()->create([
                        'state' => 'delivered',
                        'shipping_id' => $shipping->id
                    ]);
                    $i++;
                } else {
                    $shipping->tracks()->create([
                        'state' => 'ordered',
                        'shipping_id' => $shipping->id
                    ]);
                    $i++;
                }
            }
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->info("Nombre de tracker mis à jours: $i");
        $this->slack->send("Nombre de tracker mis à jours: $i");
    }

    private function GenerateInvoiceReseller()
    {
        $resellers = Reseller::all();
        $i = 0;

        foreach ($resellers as $reseller) {
            $invoice = $reseller->invoices()->create([
                'amount' => 0,
                'reseller_id' => $reseller->id,
                'collection_method' => 'send_invoice',
                'reference' => Invoice::generateReference()
            ]);

            foreach ($reseller->dab->withdraws()->where('status', 'terminated')->whereBetween('updated_at', [now()->startOfMonth(), now()->endOfMonth()])->get() as $withdraw) {
                $invoice->products()->create([
                    'label' => "Retrait du client: ".CustomerHelper::getName($withdraw->wallet->customer, true)." en date du ".$withdraw->updated_at->format("d/m/Y")." d'un montant de ".$withdraw->amount_format,
                    'amount' => $withdraw->amount * $reseller->percent_outgoing / 100,
                    'invoice_id' => $invoice->id
                ]);
            }

            foreach ($reseller->dab->moneys()->where('status', 'terminated')->whereBetween('updated_at', [now()->startOfMonth(), now()->endOfMonth()])->get() as $money) {
                $invoice->products()->create([
                    'label' => "Dépot du client: ".CustomerHelper::getName($money->wallet->customer, true)." en date du ".$money->updated_at->format("d/m/Y")." d'un montant de ".$money->amount_format,
                    'amount' => $money->amount * $reseller->percent_incoming / 100,
                    'invoice_id' => $invoice->id
                ]);
            }

            $invoice->update([
                'amount' => $invoice->products()->sum('amount')
            ]);

            $invoice->payment()->create([
                'amount' => $invoice->amount,
                'state' => 'pending',
                'invoice_id' => $invoice->id
            ]);

            // Génération de la facture & Envoie de la notification
            $document = null;
            $agence = Agency::find(1);
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'chroot' => [
                    realpath(base_path()).'/public/css',
                    realpath(base_path()).'/storage/logo',
                ],
                'enable-local-file-access' => true,
                'viewport-size' => '1280x1024',
            ])->loadView('pdf.reseller.invoice' , [
                'agence' => $agence,
                'title' => $document != null ? $document->name : 'Document',
                'reseller' => $reseller,
                'invoice' => $invoice
            ]);
            $name = 'facture_'.now()->format('dmY').'_'.$invoice->reference;


            $pdf->save(public_path('storage/reseller/'.$reseller->user->id.'/'.$name.'.pdf'));

            $reseller->user->notify(new NewInvoiceNotification($reseller, $invoice, $name));
            $i++;
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->info("Nombre de facture de distributeur générer: ".$i);
        $this->slack->send("Nombre de facture de distributeur générer: ".$i);
    }

    private function NotifyResellerInvoicePayment()
    {
        $invoices = Invoice::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->get();

        foreach ($invoices as $invoice) {
            if($invoice->due_at == now()->startOfDay()) {
                $invoice->payment()->update([
                    'state' => 'succeeded'
                ]);

                $invoice->update([
                    'state' => 'paid'
                ]);

                $invoice->reseller->user->notify(new NewInvoicePaymentNotification($invoice, $invoice->reseller));
            }
        }
    }
}

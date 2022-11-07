<?php

namespace App\Console\Commands;

use App\Models\Core\Event;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use App\Notifications\Agent\CalendarAlert;
use App\Services\CotationClient;
use Illuminate\Console\Command;

class SystemAgentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:agent {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'calendarAlert':
                $this->calendarAlert();
                break;
            case 'updateCotation':
                $this->updateCotation();
                break;

            case 'verifRequestLoanOpen':
                $this->verifRequestLoanOpen();
        }
        return Command::SUCCESS;
    }

    private function calendarAlert()
    {
        $events = Event::all();

        foreach ($events as $event) {
            if($event->start_at->subMinutes(15)->format('d/m/Y H:i') == now()->format('d/m/Y H:i')) {
                $event->user->notify(new CalendarAlert($event));
                foreach ($event->attendees as $attendee) {
                    $attendee->user->notify(new \App\Notifications\Customer\CalendarAlert($event));
                }
            }
        }
    }

    private function updateCotation()
    {
        $cotation = new CotationClient();
        $customers = Customer::all();
        $arr = [];
        foreach ($customers as $customer) {
            $customer->update(['cotation' => $cotation->calc($customer)]);
            $arr[] = [
                "client" => $customer->info->full_name,
                "cotation" => $customer->cotation
            ];
        }
        $this->output->table(["client", "cotation"], $arr);
    }

    private function verifRequestLoanOpen()
    {
        $prets = CustomerPret::where('status', 'open')->get();
        $arr = [];

        foreach ($prets as $pret) {
            $pret->update([
                'status' => 'study'
            ]);

            $pret->customer->info->notify();
        }
    }
}

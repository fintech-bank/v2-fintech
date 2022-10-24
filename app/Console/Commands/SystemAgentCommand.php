<?php

namespace App\Console\Commands;

use App\Models\Core\Event;
use App\Notifications\Agent\CalendarAlert;
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
}

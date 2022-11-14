<?php

namespace App\Providers;

use App\Events\Core\PersonnaWebbhookEvent;
use App\Listeners\Core\PersonnaWebhookListener;
use App\Listeners\LogScheduledTaskFinished;
use App\Listeners\Mailbox\ReceiverMailbox;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\Mailbox\ReceiverMailbox::class => [ReceiverMailbox::class],
        PersonnaWebbhookEvent::class => [PersonnaWebhookListener::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}

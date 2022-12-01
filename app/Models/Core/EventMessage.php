<?php

namespace App\Models\Core;

use App\Models\User;
use App\Notifications\Agent\EventUpdateNotification;
use App\Notifications\Customer\CalendarUpdateNotification;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\EventMessage
 *
 * @property int $id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $event_id
 * @property int $user_id
 * @property int $agent_id
 * @property-read \App\Models\Core\Agent $agent
 * @property-read \App\Models\Core\Event $event
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|EventMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventMessage whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMessage whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventMessage whereUserId($value)
 * @mixin \Eloquent
 */
class EventMessage extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function (EventMessage $message) {
            if($message->agent_id != null) {
                $message->event->user->customers->info->notify(new CalendarUpdateNotification($message->event->user->customers, $message->event, 'Contact avec votre banque'));
            } else {
                $message->event->agent->user->notify(new EventUpdateNotification($message->event->user->customers, $message, $message->event));
            }
        });
    }
}

<?php

namespace App\Models\Core;

use App\Models\User;
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
}

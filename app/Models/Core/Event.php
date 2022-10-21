<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\Event
 *
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property string|null $lieu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLieu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUserId($value)
 * @property int $allDay
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAllDay($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\EventAttendee[] $attendees
 * @property-read int|null $attendees_count
 * @property-read mixed $type_cl
 * @property-read mixed $type_color
 */
class Event extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'start_at', 'end_at'];
    protected $appends = ['type_color', 'type_cl'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attendees()
    {
        return $this->hasMany(EventAttendee::class);
    }

    public function getTypeColorAttribute()
    {
        switch ($this->type) {
            case 'customer': return 'bg-success text-white';
            case 'internal': return 'bg-danger text-white';
            case 'external': return 'bg-info text-white';
        }
    }

    public function getTypeClAttribute()
    {
        switch ($this->type) {
            case 'customer': return 'success';
            case 'internal': return 'danger';
            case 'external': return 'info';
        }
    }
}

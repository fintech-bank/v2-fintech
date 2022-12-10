<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\Agent
 *
 * @property int $id
 * @property string $civility
 * @property string $firstname
 * @property string $lastname
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\Event[] $events
 * @property-read int|null $events_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Agent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereUserId($value)
 * @mixin \Eloquent
 * @property int $agency_id
 * @property-read \App\Models\Core\Agency $agency
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereAgencyId($value)
 * @property-read mixed $full_name
 * @property string $poste
 * @property string|null $phone
 * @method static \Illuminate\Database\Eloquent\Builder|Agent wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent wherePoste($value)
 */
class Agent extends Model
{

    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['full_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }


    public function getFullNameAttribute()
    {
        return $this->civility.'. '.$this->lastname." ".$this->firstname;
    }
}

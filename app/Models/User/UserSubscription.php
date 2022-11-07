<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User\UserSubscription
 *
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $subscribe_type
 * @property int $subscribe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read mixed $sub
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereSubscribeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereSubscribeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereUserId($value)
 */
class UserSubscription extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSubAttribute()
    {
        return $this->subscribe_type::find($this->subscribe_id);
    }
}

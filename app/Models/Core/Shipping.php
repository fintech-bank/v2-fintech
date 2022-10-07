<?php

namespace App\Models\Core;

use App\Models\Reseller\Reseller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\Shipping
 *
 * @property int $id
 * @property string $number_ship
 * @property string $product
 * @property \Illuminate\Support\Carbon $date_delivery_estimated
 * @property \Illuminate\Support\Carbon $date_delivered
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Reseller[] $resellers
 * @property-read int|null $resellers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\ShippingTrack[] $tracks
 * @property-read int|null $tracks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereDateDelivered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereDateDeliveryEstimated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereNumberShip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Shipping extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'date_delivery_estimated', 'date_delivered'];

    public function tracks()
    {
        return $this->hasMany(ShippingTrack::class);
    }

    public function resellers()
    {
        return $this->belongsToMany(Reseller::class);
    }
}

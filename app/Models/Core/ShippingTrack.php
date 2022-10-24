<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\ShippingTrack
 *
 * @property int $id
 * @property string $state
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $shipping_id
 * @property-read mixed $state_color
 * @property-read mixed $state_label
 * @property-read mixed $state_text
 * @property-read \App\Models\Core\Shipping $shipping
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereShippingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShippingTrack extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['state_label', 'state_text'];

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id');
    }

    public function getStateTextAttribute()
    {
        switch ($this->state) {
            case 'ordered': return 'Commande Effectué';
            case 'prepared': return 'Commande Préparé';
            case 'in_transit': return 'Livraison en cours';
            case 'delivered': return 'Livré';
            default: return 'Erreur';
        }
    }

    public function getStateColorAttribute()
    {
        switch ($this->state) {
            case 'ordered': return 'primary';
            case 'prepared': return 'info';
            case 'in_transit': return 'warning';
            case 'delivered': return 'success';
            default: return 'danger';
        }
    }

    public function getStateLabelAttribute()
    {
        return '<span class="badge badge-'.$this->getStateColorAttribute().'">'.$this->getStateTextAttribute().'</span>';
    }
}

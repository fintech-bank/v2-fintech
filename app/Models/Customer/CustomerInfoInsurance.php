<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerInfoInsurance
 *
 * @property int $id
 * @property string|null $secu_number
 * @property int $fume Suis-je Fumeur ?
 * @property int $sport_risk Pratique t'il un sport à risque ?
 * @property int $politique Est-il exposer publiquement ?
 * @property int $politique_proche A t'il une proche personne exposer publiquement ?
 * @property int $manual_travaux Travaux Manuel
 * @property string $dep_pro Déplacement Pro (low: moins de 20 000/km/an)
 * @property string $port_charge Port de charge (0/3/15kg)
 * @property string $work_height Port de charge (0/3-15/15)
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereDepPro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereFume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereManualTravaux($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance wherePolitique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance wherePolitiqueProche($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance wherePortCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereSecuNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereSportRisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereWorkHeight($value)
 * @mixin \Eloquent
 */
class CustomerInfoInsurance extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

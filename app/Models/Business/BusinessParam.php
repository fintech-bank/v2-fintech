<?php

namespace App\Models\Business;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Business\BusinessParam
 *
 * @property int $id
 * @property string $name
 * @property string $forme
 * @property int $financement
 * @property float $ca
 * @property float $achat
 * @property float $frais
 * @property float $salaire
 * @property float $impot
 * @property float $other
 * @property int $customer_id
 * @property-read Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereAchat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereCa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereFinancement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereForme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereFrais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereImpot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereSalaire($value)
 * @mixin \Eloquent
 */
class BusinessParam extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

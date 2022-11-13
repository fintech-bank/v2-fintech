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
 * @property float $apport_personnel
 * @property float $finance
 * @property float $other_product
 * @property float $other_charge
 * @property-read mixed $result_format
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereApportPersonnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereOtherCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereOtherProduct($value)
 * @property float $result
 * @property float $result_finance
 * @property int $indicator
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereIndicator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereResultFinance($value)
 * @property-read mixed $indicator_format
 * @property-read mixed $result_finance_format
 */
class BusinessParam extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['result_format', 'result_finance_format', 'indicator_format'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getResultFormatAttribute()
    {
        return eur($this->result);
    }

    public function getResultFinanceFormatAttribute()
    {
        return eur($this->result_finance);
    }

    public function getIndicatorFormatAttribute()
    {
        if($this->indicator) {
            return '<span class="text-success"><i class="fa-solid fa-check-circle fs-2 text-success me-2"></i> Favorable</span>';
        } else {
            return '<span class="text-danger"><i class="fa-solid fa-xmark-circle fs-2 text-danger me-2"></i> Défavorable</span>';
        }
    }
}

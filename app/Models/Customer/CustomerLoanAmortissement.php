<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerLoanAmortissement
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $date_prlv
 * @property float $amount
 * @property float $capital_du
 * @property string $status
 * @property int $customer_pret_id
 * @property-read \App\Models\Customer\CustomerPret $loan
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereCapitalDu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereCustomerPretId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereDatePrlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereStatus($value)
 * @mixin \Eloquent
 */
class CustomerLoanAmortissement extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['date_prlv'];

    public function loan()
    {
        return $this->belongsTo(CustomerPret::class, 'customer_pret_id');
    }
}

<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerMobilityCreditor
 *
 * @property int $id
 * @property string $uuid
 * @property string $reference
 * @property string $creditor
 * @property float $amount
 * @property \Illuminate\Support\Carbon $date
 * @property int $valid
 * @property int $customer_mobility_id
 * @property-read \App\Models\Customer\CustomerMobility $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor whereCreditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor whereCustomerMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCreditor whereValid($value)
 * @mixin \Eloquent
 */
class CustomerMobilityCreditor extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['date'];

    public function mobility()
    {
        return $this->belongsTo(CustomerMobility::class, 'customer_mobility_id');
    }
}

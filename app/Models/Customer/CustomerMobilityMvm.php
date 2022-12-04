<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerMobilityMvm
 *
 * @property int $id
 * @property string $uuid
 * @property string $type_mvm
 * @property string $reference
 * @property string $creditor
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $date_transfer
 * @property \Illuminate\Support\Carbon|null $date_enc
 * @property int $valid
 * @property int $customer_mobility_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm whereCreditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm whereCustomerMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm whereDateEnc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm whereDateTransfer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm whereTypeMvm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityMvm whereValid($value)
 * @mixin \Eloquent
 */
class CustomerMobilityMvm extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['date_transfer', 'date_enc'];
}
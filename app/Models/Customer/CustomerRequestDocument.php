<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerRequestDocument
 *
 * @property int $id
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_request_id
 * @property-read \App\Models\Customer\CustomerRequest $request
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequestDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequestDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequestDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequestDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequestDocument whereCustomerRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequestDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequestDocument wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequestDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerRequestDocument extends Model
{
    protected $guarded = [];

    public function request()
    {
        return $this->belongsTo(CustomerRequest::class, 'customer_request_id');
    }
}

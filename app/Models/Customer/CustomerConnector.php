<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerConnector
 *
 * @property int $id
 * @property int $connection_id
 * @property string $auth_code
 * @property string $auth_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerConnectorBank[] $banks
 * @property-read int|null $banks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerConnectorBill[] $bills
 * @property-read int|null $bills_count
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnector newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnector newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnector query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnector whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnector whereAuthToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnector whereConnectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnector whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnector whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnector whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnector whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerConnector extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function banks()
    {
        return $this->hasMany(CustomerConnectorBank::class);
    }

    public function bills()
    {
        return $this->hasMany(CustomerConnectorBill::class);
    }
}

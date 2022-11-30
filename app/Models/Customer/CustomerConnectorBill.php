<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerConnectorBill
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_connector_id
 * @property-read \App\Models\Customer\CustomerConnector $connector
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBill query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBill whereCustomerConnectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBill whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerConnectorBill extends Model
{
    protected $guarded = [];

    public function connector()
    {
        return $this->belongsTo(CustomerConnector::class, 'customer_connector_id');
    }
}

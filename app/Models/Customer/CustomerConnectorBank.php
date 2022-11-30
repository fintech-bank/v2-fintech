<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerConnectorBank
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_connector_id
 * @property-read \App\Models\Customer\CustomerConnector $connector
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBank query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBank whereCustomerConnectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerConnectorBank whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerConnectorBank extends Model
{
    protected $guarded = [];

    public function connector()
    {
        return $this->belongsTo(CustomerConnector::class, 'customer_connector_id');
    }
}

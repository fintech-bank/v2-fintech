<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerGrpdDemande
 *
 * @property int $id
 * @property string $type
 * @property string $object
 * @property string $comment
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerGrpdDemande extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

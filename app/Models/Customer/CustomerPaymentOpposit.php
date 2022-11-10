<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerPaymentOpposit
 *
 * @property int $id
 * @property string $status
 * @property string $raison_opposit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_transaction_id
 * @property-read \App\Models\Customer\CustomerTransaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereCustomerTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereRaisonOpposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerPaymentOpposit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function transaction()
    {
        return $this->belongsTo(CustomerTransaction::class, 'customer_transaction_id');
    }
}

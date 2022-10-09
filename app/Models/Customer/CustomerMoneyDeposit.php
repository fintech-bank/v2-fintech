<?php

namespace App\Models\Customer;

use App\Helper\CustomerHelper;
use App\Helper\CustomerWithdrawHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerMoneyDeposit
 *
 * @property int $id
 * @property string $reference
 * @property float $amount
 * @property string $status
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property int|null $customer_transaction_id
 * @property int $customer_withdraw_dab_id
 * @property-read \App\Models\Customer\CustomerWithdrawDab $dab
 * @property-read mixed $amount_format
 * @property-read mixed $customer_name
 * @property-read mixed $decoded_code
 * @property-read mixed $labeled_status
 * @property-read \App\Models\Customer\CustomerTransaction|null $transaction
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereCustomerTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereCustomerWithdrawDabId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerMoneyDeposit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function transaction()
    {
        return $this->belongsTo(CustomerTransaction::class, 'customer_transaction_id');
    }

    public function dab()
    {
        return $this->belongsTo(CustomerWithdrawDab::class, 'customer_withdraw_dab_id');
    }

    public function getDecodedCodeAttribute()
    {
        return base64_decode($this->code);
    }

    public function getLabeledStatusAttribute()
    {
        return CustomerWithdrawHelper::getStatusWithdraw($this->status, true);
    }

    public function getCustomerNameAttribute()
    {
        return CustomerHelper::getName($this->wallet->customer);
    }

    public function getAmountFormatAttribute()
    {
        return eur($this->amount);
    }
}

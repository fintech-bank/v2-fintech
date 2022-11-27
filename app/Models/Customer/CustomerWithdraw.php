<?php

namespace App\Models\Customer;

use App\Helper\CustomerHelper;
use App\Helper\CustomerWithdrawHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerWithdraw
 *
 * @property-read \App\Models\Customer\CustomerWithdrawDab|null $dab
 * @property-read \App\Models\Customer\CustomerTransaction|null $transaction
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerWithdrawFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $reference
 * @property float $amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property int|null $customer_transaction_id
 * @property int $customer_withdraw_dab_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCustomerTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCustomerWithdrawDabId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereUpdatedAt($value)
 * @property string $code
 * @property-read mixed $amount_format
 * @property-read mixed $customer_name
 * @property-read string|bool $decoded_code
 * @property-read mixed $labeled_status
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCode($value)
 * @property-read mixed $status_text
 */
class CustomerWithdraw extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['decoded_code', 'labeled_status', 'customer_name', 'amount_format', 'status_text'];

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

    public static function createWithdraw($wallet_id, $amount, $dab_id, $status = 'pending', $transaction_id = null)
    {
        $code = random_numeric(6);
        return self::create([
            'reference' => generateReference(),
            'status' => $status,
            'amount' => $amount,
            'customer_wallet_id' => $wallet_id,
            'customer_transaction_id' => $transaction_id,
            'customer_withdraw_dab_id' => $dab_id,
            'code' => base64_encode($code)
        ]);
    }

    public function getDecodedCodeAttribute()
    {
        return base64_decode($this->code);
    }

    public function getStatus($format = '')
    {
        if($format == 'text') {
            return match ($this->status) {
                "pending" => "En attente",
                "accepted" => "Accepté",
                "rejected" => "Rejeté",
                default => "Terminé"
            };
        } elseif ($format == "color") {
            return match ($this->status) {
                "pending" => "warning",
                "rejected" => "danger",
                default => "success"
            };
        } else {
            return match ($this->status) {
                "pending" => "fa-spinner fa-spin-pulse",
                "rejected" => "fa-xmark-circle",
                default => "fa-check-circle"
            };
        }
    }

    /**
     * @throws \Exception
     */
    public function getLabeledStatusAttribute()
    {
        return "<span class='badge badge-{$this->getStatus('color')}'><i class='fa-solid {$this->getStatus()} text-white me-2'></i> {$this->getStatus('text')}</span>";
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'pending': return 'En Attente';
            case 'accepted': return 'Accepter';
            case 'rejected': return 'Refuser';
            case 'terminated': return 'Terminer';
        }
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

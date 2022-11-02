<?php

namespace App\Models\Customer;

use App\Models\Core\InvoicePayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerTransaction
 *
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property string $designation
 * @property string|null $description
 * @property float $amount
 * @property int $confirmed
 * @property int $differed
 * @property \Illuminate\Support\Carbon|null $confirmed_at
 * @property \Illuminate\Support\Carbon|null $differed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property int|null $customer_credit_card_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerTransactionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCustomerCreditCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDiffered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDifferedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerTransaction
 * @property-read \App\Models\Customer\CustomerWithdraw|null $withdraw
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheckDeposit[] $check_deposit
 * @property-read int|null $check_deposit_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMoneyDeposit[] $money_deposits
 * @property-read int|null $money_deposits_count
 * @property-read InvoicePayment|null $invoice_payment
 * @property-read mixed $type_icon
 * @property-read mixed $type_symbol
 * @property-read mixed $type_text
 */
class CustomerTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['type_text', 'type_symbol'];

    protected $dates = ['created_at', 'updated_at', 'confirmed_at', 'differed_at'];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function card()
    {
        return $this->belongsTo(CustomerCreditCard::class, 'customer_credit_card_id');
    }

    public function withdraw()
    {
        return $this->hasOne(CustomerWithdraw::class);
    }

    public function check_deposit()
    {
        return $this->hasMany(CustomerCheckDeposit::class);
    }

    public function money_deposits()
    {
        return $this->hasMany(CustomerMoneyDeposit::class);
    }

    public function invoice_payment()
    {
        return $this->hasOne(InvoicePayment::class);
    }

    public function getTypeTextAttribute()
    {
        return \Str::ucfirst($this->type);
    }
    public function getTypeIconAttribute()
    {
        return match ($this->type) {
            'depot' => 'vaadin:money-deposit',
            'retrait' => 'vaadin:money-withdraw',
            'payment' => 'fluent:wallet-credit-card-16-filled',
            'virement' => 'mdi:bank-transfer',
            'sepa' => 'mdi:bank-transfer-out',
            'frais' => 'fluent:feed-16-regular',
            'souscription' => 'eos-icons:activate-subscriptions-outlined',
            'autre' => 'fluent-mdl2:checked-out-by-other-12',
            'facelia' => 'fluent:panel-left-contract-16-filled',
            default => 'carbon:warning-square',
        };
    }

    public function getTypeSymbolAttribute()
    {
        return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="'.$this->getTypeTextAttribute().'">
                    <div class="symbol-label"><span class="iconify" data-icon="'.$this->getTypeIconAttribute().'"  data-width="50" data-height="50"></span></div>
                </div>';
    }
}

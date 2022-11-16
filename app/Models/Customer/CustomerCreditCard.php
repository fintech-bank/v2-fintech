<?php

namespace App\Models\Customer;

use App\Helper\CustomerCreditCardTrait;
use App\Helper\CustomerWalletHelper;
use App\Models\Core\CreditCardOpposit;
use App\Models\Core\CreditCardSupport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerCreditCard
 *
 * @property int $id
 * @property string $currency
 * @property string $exp_month
 * @property string $exp_year
 * @property string $number
 * @property string $status
 * @property string $type
 * @property string $support
 * @property string $debit
 * @property string $cvc
 * @property int $payment_internet
 * @property int $payment_abroad
 * @property int $payment_contact
 * @property string $code
 * @property float $limit_retrait
 * @property float $limit_payment
 * @property float $differed_limit
 * @property int $facelia
 * @property int $visa_spec
 * @property int $warranty
 * @property int $customer_wallet_id
 * @property int|null $customer_pret_id
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelias
 * @property-read \App\Models\Customer\CustomerPret|null $pret
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerCreditCardFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCustomerPretId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCvc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereDifferedLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereExpMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereExpYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereFacelia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereLimitPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereLimitRetrait($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentAbroad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentInternet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereSupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereVisaSpec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereWarranty($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerCreditCard
 * @property-read bool $access_withdraw
 * @property-read mixed $actual_limit_withdraw
 * @property-read mixed $limit_withdraw
 * @property int $credit_card_support_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCreditCardSupportId($value)
 * @property string $facelia_vitesse
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereFaceliaVitesse($value)
 * @property-read mixed $number_card_oscure
 * @property-read mixed $number_format
 * @property-read mixed $debit_format
 * @property-read mixed $expiration
 * @property-read mixed $logo_card
 * @property-read mixed $status_label
 * @property-read bool $is_differed
 * @property-read CreditCardOpposit|null $opposition
 */
class CustomerCreditCard extends Model
{
    use HasFactory, CustomerCreditCardTrait;

    protected $guarded = [];

    public $timestamps = false;
    protected $appends = [
        'limit_withdraw',
        'access_withdraw',
        'actual_limit_withdraw',
        'number_card_oscure',
        'number_format',
        'expiration',
        'debit_format',
        'status_label',
        'logo_card',
        'is_differed'
    ];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function pret()
    {
        return $this->belongsTo(CustomerPret::class, 'customer_pret_id');
    }

    public function facelias()
    {
        return $this->hasOne(CustomerFacelia::class);
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    public function support()
    {
        return $this->belongsTo(CreditCardSupport::class, 'credit_card_support_id');
    }

    public function opposition()
    {
        return $this->hasOne(CreditCardOpposit::class);
    }

    //-------------- Scope -------------------------//


    //-------------- Append -------------------------//

    public function getLimitWithdrawAttribute()
    {
        return $this->getTransactionsMonthWithdraw();
    }

    public function getAccessWithdrawAttribute(): bool
    {
        if($this->wallet->status == 'active' && $this->wallet->solde_remaining < $this->limit_retrait && $this->getTransactionsMonthWithdraw() < $this->limit_retrait && $this->status == 'active') {
            return true;
        } else {
            return false;
        }
    }

    public function getActualLimitWithdrawAttribute()
    {
        return $this->getTransactionsMonthWithdraw() - (-$this->limit_retrait);
    }

    public function getNumberCardOscureAttribute()
    {
        return 'XXXX XXXX XXXX '.\Str::substr($this->number, 12, 16);
    }

    public function getNumberFormatAttribute()
    {
        return \Str::mask($this->number, 'X', 0, 12);
    }

    public function getExpirationAttribute()
    {
        return $this->exp_month <= 9 ? "0".$this->exp_month : $this->exp_month."/".$this->exp_year;
    }

    public function getDebitFormatAttribute()
    {
        if($this->debit == 'immediate') {
            return "Débit Immédiat";
        } else {
            return "Débit Différé";
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-{$this->getStatus('color')}'><i class='fa-solid fa-{$this->getStatus()} me-2 text-white'></i> {$this->getStatus('text')}</span>";
    }

    public function getLogoCardAttribute()
    {
        return '/storage/card/'.$this->support->slug.'.png';
    }

    public function alert($alert)
    {

    }

}

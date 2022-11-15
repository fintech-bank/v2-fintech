<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerCreditCard;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\CreditCardSupport
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $type_customer
 * @property int $payment_internet
 * @property int $payment_abroad
 * @property int $payment_contact
 * @property float $limit_retrait
 * @property float $limit_payment
 * @property int $visa_spec
 * @property int $choice_code
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerCreditCard[] $creditcards
 * @property-read int|null $creditcards_count
 * @property-read \App\Models\Core\CreditCardInsurance|null $insurance
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport query()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereChoiceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereLimitPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereLimitRetrait($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport wherePaymentAbroad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport wherePaymentContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport wherePaymentInternet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereTypeCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereVisaSpec($value)
 * @mixin \Eloquent
 * @property-read mixed $choice_code_text
 * @property-read mixed $payment_abroad_text
 * @property-read mixed $payment_contact_text
 * @property-read mixed $payment_internet_text
 * @property-read mixed $visa_spec_text
 */
class CreditCardSupport extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['payment_internet_text', 'payment_abroad_text', 'payment_contact_text', 'visa_spec_text', 'choice_code_text'];

    public function creditcards()
    {
        return $this->hasMany(CustomerCreditCard::class);
    }

    public function insurance()
    {
        return $this->hasOne(CreditCardInsurance::class);
    }

    public function getPaymentInternetTextAttribute()
    {
        return "Paiement sur Internet";
    }

    public function getPaymentAbroadTextAttribute()
    {
        return "Paiement/Retrait à l'étranger";
    }

    public function getPaymentContactTextAttribute()
    {
        return "Paiement sans contact";
    }

    public function getVisaSpecTextAttribute()
    {
        return "Garantie Visa";
    }

    public function getChoiceCodeTextAttribute()
    {
        return "Possibilité de changer de code secret";
    }
}

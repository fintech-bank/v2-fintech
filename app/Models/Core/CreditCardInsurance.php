<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\CreditCardInsurance
 *
 * @property int $id
 * @property int $insurance_sante
 * @property int $insurance_accident_travel
 * @property int $trip_cancellation
 * @property int $civil_liability_abroad
 * @property int $cash_breakdown_abroad
 * @property int $guarantee_snow
 * @property int $guarantee_loan
 * @property int $guarantee_purchase
 * @property int $advantage
 * @property int $business_travel
 * @property int $credit_card_support_id
 * @property-read \App\Models\Core\CreditCardSupport $support
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance query()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereAdvantage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereBusinessTravel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereCashBreakdownAbroad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereCivilLiabilityAbroad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereCreditCardSupportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereGuaranteeLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereGuaranteePurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereGuaranteeSnow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereInsuranceAccidentTravel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereInsuranceSante($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereTripCancellation($value)
 * @mixin \Eloquent
 */
class CreditCardInsurance extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function support()
    {
        return $this->belongsTo(CreditCardSupport::class, 'credit_card_support_id');
    }
}

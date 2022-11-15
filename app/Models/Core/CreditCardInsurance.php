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
 * @property-read mixed $advantage_text
 * @property-read mixed $business_travel_text
 * @property-read mixed $cash_breakdown_abroad_text
 * @property-read mixed $civil_liability_abroad_text
 * @property-read mixed $guarantee_loan_text
 * @property-read mixed $guarantee_purchase_text
 * @property-read mixed $guarantee_snow_text
 * @property-read mixed $insurance_accident_travel_text
 * @property-read mixed $insurance_sante_text
 * @property-read mixed $trip_cancellation_text
 */
class CreditCardInsurance extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = [
        'insurance_sante_text',
        'insurance_accident_travel_text',
        'trip_cancellation_text',
        'civil_liability_abroad_text',
        'cash_breakdown_abroad_text',
        'guarantee_snow_text',
        'guarantee_loan_text',
        'guarantee_purchase_text',
        'advantage_text',
        'business_travel_text'
    ];

    public function support()
    {
        return $this->belongsTo(CreditCardSupport::class, 'credit_card_support_id');
    }

    public function getInsuranceSanteTextAttribute()
    {
        return "Assistance (hospitalisation à l'étranger, rapatriement, avance des frais médicaux...)";
    }

    public function getInsuranceAccidentTravelTextAttribute()
    {
        return "Assurance accident voyage";
    }

    public function getTripCancellationTextAttribute()
    {
        return "Annulation, modification et interruption de voyage";
    }

    public function getCivilLiabilityAbroadTextAttribute()
    {
        return "Responsabilité civile à l’étranger";
    }

    public function getCashBreakdownAbroadTextAttribute()
    {
        return "Service de dépannage carte ou espèces en France et à l’étranger";
    }

    public function getGuaranteeSnowTextAttribute()
    {
        return "Garantie Neige et Montagne";
    }

    public function getGuaranteeLoanTextAttribute()
    {
        return "Garantie véhicule de location";
    }

    public function getGuaranteePurchaseTextAttribute()
    {
        return "Garantie d'achat";
    }

    public function getAdvantageTextAttribute()
    {
        return "Avantages exclusifs (réductions loc. voitures, voyages,…)";
    }

    public function getBusinessTravelTextAttribute()
    {
        return "Service personnalisé et adapté à vos besoins pour organiser vos déplacements professionnels";
    }
}

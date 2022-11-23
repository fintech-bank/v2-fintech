<?php

namespace App\Models\Customer;

use App\Models\Core\LoanPlan;
use App\Scope\CalcLoanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerPret
 *
 * @property int $id
 * @property string $uuid
 * @property string $reference
 * @property float $amount_loan Montant du crédit demander
 * @property float $amount_interest Montant des interet du par le client
 * @property float $amount_du Total des sommes du par le client (Credit + Interet - mensualités payé)
 * @property float $mensuality Mensualité du par le client par mois
 * @property int $prlv_day Jours du prélèvement de la mensualité
 * @property int $duration Durée total du contrat en année
 * @property string $status
 * @property int $signed_customer
 * @property int $signed_bank
 * @property int $alert
 * @property string $assurance_type
 * @property int $customer_wallet_id
 * @property int $wallet_payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $first_payment_at
 * @property int $loan_plan_id
 * @property int $customer_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelia
 * @property-read \App\Models\Customer\CustomerWallet $payment
 * @property-read LoanPlan $plan
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerPretFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountDu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAssuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereFirstPaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereLoanPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereMensuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret wherePrlvDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereSignedBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereSignedCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereWalletPaymentId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerPret
 * @property-read mixed $status_explanation
 * @property-read mixed $status_label
 * @property-read string $amount_du_format
 * @property-read string $amount_interest_format
 * @property-read string $amount_loan_format
 * @property-read string $assurance_type_format
 * @property-read string $mensuality_format
 * @property-read mixed $taux_variable
 * @property int $required_insurance
 * @property int $required_caution
 * @property mixed|null $caution nom/prénom/datedenaissance/cni/address/telephone
 * @property-read mixed $caution_text
 * @property-read mixed $insurance_text
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereRequiredCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereRequiredInsurance($value)
 * @property string|null $confirmed_at Date de confirmation 'Approve' du pret bancaire
 * @property int|null $customer_insurance_id
 * @property-read \App\Models\Customer\CustomerInsurance|null $insurance
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCustomerInsuranceId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerPretCaution[] $cautions
 * @property-read int|null $cautions_count
 * @property int|null $nb_report_echeance
 * @property int|null $nb_adapt_mensuality
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerLoanAmortissement[] $amortissements
 * @property-read int|null $amortissements_count
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereNbAdaptMensuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereNbReportEcheance($value)
 */
class CustomerPret extends Model
{
    use HasFactory, CalcLoanTrait;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'first_payment_at', 'confirmed_at'];
    protected $append = [
        'status_label',
        'status_explanation',
        'amount_loan_format',
        'amount_interest_format',
        'amount_du_format',
        'mensuality_format',
        'assurance_type_format',
        'taux_variable',
        'caution_text',
        'insurance_text'
    ];

    public function plan()
    {
        return $this->belongsTo(LoanPlan::class, 'loan_plan_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function payment()
    {
        return $this->belongsTo(CustomerWallet::class, 'wallet_payment_id');
    }

    public function card()
    {
        return $this->hasOne(CustomerCreditCard::class);
    }

    public function facelia()
    {
        return $this->hasOne(CustomerFacelia::class);
    }

    public function insurance()
    {
        return $this->belongsTo(CustomerInsurance::class, 'customer_insurance_id');
    }

    public function cautions()
    {
        return $this->hasMany(CustomerPretCaution::class);
    }

    public function amortissements()
    {
        return $this->hasMany(CustomerLoanAmortissement::class);
    }

    //---------- Scope ------------------//

    public static function dataTypeInsurance()
    {
        return collect([
            [
                "id" => "D",
                "name" => "Décès"
            ],
            [
                "id" => "DIM",
                "name" => "Décès, Invalidité, Maladie"
            ],
            [
                "id" => "DIMC",
                "name" => "Décès, Invalidité, Maladie, Perte d'emploi"
            ],
            [
                "id" => "NONE",
                "name" => "Aucune"
            ],

        ]);
    }

    //---------- Attribute -------------//

    public function getStatus($format = '')
    {
        if($format == 'text') {
            return match ($this->status) {
                "open" => "Dossier ouvert",
                "study" => "Dossier en étude",
                "accepted" => "Dossier accepter",
                "refused" => "Dossier refuser",
                "progress" => "Dossier en cours...",
                "terminated" => "Pret remboursé",
                "error" => "Erreur ou problème avec le pret",
            };
        } elseif ($format == 'color') {
            return match ($this->status) {
                "open" => "secondary",
                "study" => "warning",
                "accepted", "terminated", "progress" => "success",
                "refused", "error" => "danger",
            };
        } else {
            return match ($this->status) {
                "open" => "fa-pen",
                "study", "progress" => "fa-spinner fa-spin-pulse",
                "accepted", "terminated" => "fa-check-circle",
                "refused" => "fa-xmark-circle",
                "error" => "fa-exclamation-circle",
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<div class='badge badge-lg badge-{$this->getStatus('color')}'><i class='fa-solid {$this->getStatus()} text-white me-2'></i> {$this->getStatus('text')}</div>";
    }

    public function getStatusExplanationAttribute()
    {
        switch($this->status) {
            case 'open': return 'Votre demande à été transmis à '.config('app.name'); break;
            case 'study': return 'Votre demande est en cours d\'étude par une équipe financier.'; break;
            case 'accepted': return 'Votre demande est accepter.'; break;
            case 'refused': return 'Votre demande à été refusé.<br>Pour en savoir plus, veuillez contacter un conseiller'; break;
            case 'progress': return 'Pret en cours...'; break;
            case 'terminated': return 'Vous avez remboursé votre prêt bancaire'; break;
            case 'error': return 'Une erreur est détécté sur votre dossier.<br>Pour en savoir plus, veuillez contacter un conseiller.'; break;
        }
    }

    public function getAmountLoanFormatAttribute(): string
    {
        return eur($this->amount_loan);
    }

    public function getAmountInterestFormatAttribute(): string
    {
        return eur($this->amount_interest);
    }

    public function getAmountDuFormatAttribute(): string
    {
        return eur($this->amount_du);
    }

    public function getMensualityFormatAttribute(): string
    {
        return eur($this->mensuality);
    }

    public function getTauxVariableAttribute()
    {
        return self::calcLoanIntestVariableTaxe($this);
    }

    public function getAssuranceTypeFormatAttribute(): string
    {
        return match ($this->assurance_type) {
            "D" => "Décès",
            "DIM" => "Décès, Invalidité, Maladie",
            default => "Décès, Invalidité, Maladie, Chomage",
        };
    }

    public function getCautionTextAttribute()
    {
        return $this->required_caution ? "Oui" : "Non";
    }

    public function getInsuranceTextAttribute()
    {
        return $this->required_insurance ? "Oui" : "Non";
    }


}

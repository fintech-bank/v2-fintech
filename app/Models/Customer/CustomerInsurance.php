<?php

namespace App\Models\Customer;

use App\Models\Insurance\InsurancePackage;
use App\Models\Insurance\InsurancePackageForm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerInsurance
 *
 * @property int $id
 * @property string $status
 * @property string $reference
 * @property \Illuminate\Support\Carbon $date_member
 * @property \Illuminate\Support\Carbon $effect_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property float $mensuality
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property int $insurance_package_id
 * @property int $insurance_package_form_id
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read InsurancePackageForm $form
 * @property-read InsurancePackage $package
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereDateMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereEffectDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereInsurancePackageFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereInsurancePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereMensuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $type_prlv
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereTypePrlv($value)
 * @property-read mixed $status_color
 * @property-read mixed $status_label
 * @property-read mixed $status_text
 * @property-read mixed $mensuality_format
 * @property-read mixed $type_prlv_text
 * @property string|null $beneficiaire
 * @property-read \App\Models\Customer\CustomerWallet|null $payment
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereBeneficiaire($value)
 * @property int $customer_wallet_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereCustomerWalletId($value)
 * @property-read \App\Models\Customer\CustomerPret|null $pret
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerInsuranceClaim[] $claims
 * @property-read int|null $claims_count
 */
class CustomerInsurance extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'date_member', 'effect_date', 'end_date'];
    protected $appends = ['status_label', 'mensuality_format', 'type_prlv_text'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function package()
    {
        return $this->belongsTo(InsurancePackage::class, 'insurance_package_id');
    }

    public function form()
    {
        return $this->belongsTo(InsurancePackageForm::class, 'insurance_package_form_id');
    }

    public function payment()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function pret()
    {
        return $this->hasOne(CustomerPret::class);
    }

    public function claims()
    {
        return $this->hasMany(CustomerInsuranceClaim::class);
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            "active" => "Actif",
            "resilied" => "Résilié",
            "terminated" => "Contrat Terminé",
            "suspended" => "Suspendue",
            "juris" => "Contentieux"
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            "active" => "success",
            "resilied" => "danger",
            "terminated" => "success",
            "suspended" => "warning",
            "juris" => "danger"
        };
    }

    public function getStatusLabelAttribute()
    {
        return '<span class="badge badge-'.$this->getStatusColorAttribute().'">'.$this->getStatusTextAttribute().'</span>';
    }

    public function getMensualityFormatAttribute()
    {
        return eur($this->mensuality);
    }

    public function getTypePrlvTextAttribute()
    {
        return match ($this->type_prlv) {
            "mensuel" => "Mensuel",
            "trim" => "Trimestriel",
            "annuel" => "Annuel",
            default => "Ponctuel",
        };
    }
}

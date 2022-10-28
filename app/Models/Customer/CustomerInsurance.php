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
 */
class CustomerInsurance extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'date_member', 'effect_date', 'end_date'];

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
}

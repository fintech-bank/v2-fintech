<?php

namespace App\Models\Insurance;

use App\Models\Customer\CustomerInsurance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Insurance\InsurancePackageForm
 *
 * @property int $id
 * @property string $name
 * @property string|null $synopsis
 * @property float $typed_price
 * @property int $insurance_package_id
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerInsurance[] $insurannces
 * @property-read int|null $insurannces_count
 * @property-read \App\Models\Insurance\InsurancePackage $package
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Insurance\InsurancePackageWarranty[] $warranties
 * @property-read int|null $warranties_count
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm whereInsurancePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm whereSynopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm whereTypedPrice($value)
 * @mixin \Eloquent
 * @property float|null $percent
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm wherePercent($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerInsurance[] $insurances
 * @property-read int|null $insurances_count
 * @property-read mixed $typed_price_format
 */
class InsurancePackageForm extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['typed_price_format'];

    public function package()
    {
        return $this->belongsTo(InsurancePackage::class, 'insurance_package_id');
    }

    public function warranties()
    {
        return $this->hasMany(InsurancePackageWarranty::class);
    }

    public function insurances()
    {
        return $this->hasMany(CustomerInsurance::class);
    }

    public function getTypedPriceFormatAttribute()
    {
        return eur($this->typed_price);
    }
}

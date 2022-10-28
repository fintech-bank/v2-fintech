<?php

namespace App\Models\Insurance;

use App\Models\Customer\CustomerInsurance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Insurance\InsurancePackage
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $synopsis
 * @property string|null $description
 * @property int $insurance_type_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Insurance\InsurancePackageForm[] $forms
 * @property-read int|null $forms_count
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerInsurance[] $insurances
 * @property-read int|null $insurances_count
 * @property-read \App\Models\Insurance\InsuranceType $type
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereInsuranceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereSynopsis($value)
 * @mixin \Eloquent
 */
class InsurancePackage extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo(InsuranceType::class, 'insurance_type_id');
    }

    public function forms()
    {
        return $this->hasMany(InsurancePackageForm::class);
    }

    public function insurances()
    {
        return $this->hasMany(CustomerInsurance::class);
    }
}

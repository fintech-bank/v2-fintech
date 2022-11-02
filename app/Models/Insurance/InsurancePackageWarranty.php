<?php

namespace App\Models\Insurance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Insurance\InsurancePackageWarranty
 *
 * @property int $id
 * @property string $designation
 * @property int $check
 * @property float $price
 * @property int $insurance_package_form_id
 * @property-read \App\Models\Insurance\InsurancePackageForm $form
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereInsurancePackageFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty wherePrice($value)
 * @mixin \Eloquent
 * @property string|null $condition
 * @property int|null $count
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereCount($value)
 */
class InsurancePackageWarranty extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function form()
    {
        return $this->belongsTo(InsurancePackageForm::class, 'insurance_package_form_id');
    }
}

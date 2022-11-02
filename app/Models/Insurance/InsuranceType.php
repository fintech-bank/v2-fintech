<?php

namespace App\Models\Insurance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Insurance\InsuranceType
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Insurance\InsurancePackage[] $package
 * @property-read int|null $package_count
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType whereName($value)
 * @mixin \Eloquent
 */
class InsuranceType extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function package()
    {
        return $this->hasMany(InsurancePackage::class);
    }
}

<?php

namespace App\Models\Core;

use App\Helper\CountryHelper;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerMobility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\Bank
 *
 * @property int $id
 * @property int|null $bridge_id
 * @property string $name
 * @property string $logo
 * @property string $primary_color
 * @property string $country
 * @property string $bic
 * @property string $process_time
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerBeneficiaire[] $beneficiaires
 * @property-read int|null $beneficiaires_count
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereBridgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank wherePrimaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereProcessTime($value)
 * @mixin \Eloquent
 * @mixin IdeHelperBank
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerMobility[] $mobility
 * @property-read int|null $mobility_count
 * @property-read mixed $bank_symbol
 */
class Bank extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $appends = ['bank_symbol'];

    public function beneficiaires()
    {
        return $this->hasMany(CustomerBeneficiaire::class);
    }

    public function mobility()
    {
        return $this->hasMany(CustomerMobility::class);
    }

    public function getCountryAttribute($value)
    {
        return CountryHelper::getCountryName(\Str::upper(\Str::limit($value, 2, '')));
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = \Str::upper(\Str::limit($value, 2, ''));
    }

    public function getBankSymbolAttribute()
    {
        ob_start();
        ?>
        <div class="d-flex flex-row align-items-center">
            <div class="symbol symbol-50px me-3">
                <div class="symbol-label" style="background-image:url('<?= $this->logo ?>')"></div>
            </div>
            <div class="d-flex flex-column">
                <strong><?= $this->name ?></strong>
                <div class="text-muted">BIC: <?= $this->bic ?></div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

<?php

namespace App\Models\Core;

use App\Helper\LogHelper;
use App\Models\Customer\CustomerEpargne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\EpargnePlan
 *
 * @property int $id
 * @property string $name
 * @property float $profit_percent
 * @property int $lock_days
 * @property int $profit_days
 * @property float $init
 * @property float $limit
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerEpargne[] $epargnes
 * @property-read int|null $epargnes_count
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereLockDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereProfitDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereProfitPercent($value)
 * @mixin \Eloquent
 * @mixin IdeHelperEpargnePlan
 * @property string $type_customer
 * @property string $type_epargne
 * @property float $limit_amount
 * @property int $unique
 * @property int $droit_credit
 * @property int $duration
 * @property int $garantie_deces
 * @property int $partial_liberation
 * @property string $description
 * @property mixed $info_versement
 * @property mixed $info_retrait
 * @property mixed|null $info_credit
 * @property mixed|null $info_deces
 * @property mixed|null $info_liberation
 * @property mixed|null $info_frais
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereDroitCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereGarantieDeces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereInfoCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereInfoDeces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereInfoFrais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereInfoLiberation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereInfoRetrait($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereInfoVersement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereLimitAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan wherePartialLiberation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereTypeCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereTypeEpargne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereUnique($value)
 * @property-read mixed $init_format
 * @property-read mixed $limit_amount_format
 * @property-read mixed $profit_percent_format
 */
class EpargnePlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'info_versement' => 'object',
        'info_credit' => 'object',
        'info_retrait' => 'object',
        'info_deces' => 'object',
        'info_frais' => 'object',
        'info_liberation' => 'object'
    ];

    protected $appends = ['profit_percent_format', 'init_format', 'limit_amount_format'];

    public function epargnes()
    {
        return $this->hasMany(CustomerEpargne::class);
    }

    public static function toSelect($query)
    {
        $datas = collect();

        foreach ($query as $value) {
            $datas->push([
                'id' => $value->id,
                'value' => $value->name
            ]);
        }

        return $datas->all();
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($plan) {
            LogHelper::insertLogSystem('success', "Un plan d'épargne à été créer: ".$plan->name);
        });

        static::updated(function ($plan) {
            LogHelper::insertLogSystem('success', "Un plan d'épargne à été éditer: ".$plan->name);
        });

        static::deleted(function () {
            LogHelper::insertLogSystem('success', "Un plan d'épargne à été supprimer");
        });
    }

    public function getProfitPercentFormatAttribute()
    {
        return number_format($this->profit_percent, 2)." %";
    }

    public function getInitFormatAttribute()
    {
        return eur($this->init);
    }

    public function getLimitAmountFormatAttribute()
    {
        return eur($this->limit_amount);
    }
}

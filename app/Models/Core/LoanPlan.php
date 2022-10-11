<?php

namespace App\Models\Core;

use App\Helper\LogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\LoanPlan
 *
 * @property int $id
 * @property string $name
 * @property float $minimum
 * @property float $maximum
 * @property int $duration En Mois
 * @property string|null $instruction
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\LoanPlanInterest[] $interests
 * @property-read int|null $interests_count
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereInstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereMaximum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereMinimum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereName($value)
 * @mixin \Eloquent
 * @mixin IdeHelperLoanPlan
 * @property mixed|null $avantage
 * @property mixed|null $condition
 * @property mixed|null $tarif
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereAvantage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereTarif($value)
 * @property string $type_pret
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereTypePret($value)
 */
class LoanPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;


    public function interests()
    {
        return $this->hasMany(LoanPlanInterest::class);
    }

    public function getAvantageAttribute($value)
    {
        return json_decode($value);
    }

    public function getConditionAttribute($value)
    {
        return json_decode($value);
    }

    public function getTarifAttribute($value)
    {
        return json_decode($value);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($plan) {
            LogHelper::insertLogSystem('success', "Un type de prêt à été créer: ".$plan->name);
        });

        static::updated(function ($plan) {
            LogHelper::insertLogSystem('success', "Un type de prêt à été éditer: ".$plan->name);
        });

        static::deleted(function () {
            LogHelper::insertLogSystem('success', "Un type de prêt à été supprimer");
        });
    }
}

<?php

namespace App\Models\Core;

use App\Helper\LogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\Service
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $type_prlv
 * @property int|null $package_id
 * @property-read \App\Models\Core\Package|null $package
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereTypePrlv($value)
 * @mixin \Eloquent
 * @mixin IdeHelperService
 * @property-read mixed $price_format
 * @property-read mixed $type_prlv_text
 */
class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;
    protected $appends = ['price_format', 'type_prlv_text'];

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function getPriceFormatAttribute()
    {
        return eur($this->price);
    }

    public function getTypePrlvTextAttribute()
    {
        switch ($this->type_prlv) {
            case 'mensual': return "Mensuel";
            case 'trim': return "Trimestriel";
            case 'sem': return "Semestriel";
            case 'ponctual': return "Ponctuel";
            default: return "Annuel";
        }
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($plan) {
            LogHelper::insertLogSystem('success', "Un service bancaire à été créer: ".$plan->name);
        });

        static::updated(function ($plan) {
            LogHelper::insertLogSystem('success', "Un service bancaire à été éditer: ".$plan->name);
        });

        static::deleted(function () {
            LogHelper::insertLogSystem('success', "Un service bancaire à été supprimer");
        });
    }
}

<?php

namespace App\Models\Core;

use App\Helper\LogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\Package
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $type_prlv
 * @property int $visa_classic
 * @property int $check_deposit
 * @property int $payment_withdraw
 * @property int $overdraft
 * @property int $cash_deposit
 * @property int $withdraw_international
 * @property int $payment_international
 * @property int $payment_insurance
 * @property int $check
 * @property int $nb_carte_physique
 * @property int $nb_carte_virtuel
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCashDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCheckDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNbCartePhysique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNbCarteVirtuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereOverdraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentInternational($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTypePrlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereVisaClassic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereWithdrawInternational($value)
 * @mixin \Eloquent
 * @mixin IdeHelperPackage
 * @property string $type_cpt
 * @property int $subaccount
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereSubaccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTypeCpt($value)
 * @property-read mixed $price_format
 * @property-read mixed $type_cpt_label
 * @property-read mixed $type_cpt_text
 * @property-read mixed $type_prlv_text
 */
class Package extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;
    protected $appends = ['price_format', 'type_cpt_label', 'type_cpt_text', 'type_prlv_text'];

    public static function dataTypePrlv()
    {
        $array = [
            [
                'string' => 'mensual',
                'text' => "Mensuel"
            ],
            [
                'string' => 'trim',
                'text' => "Trimestriel"
            ],
            [
                'string' => 'sem',
                'text' => "Semestriel"
            ],
            [
                'string' => 'annual',
                'text' => "Annuel"
            ]
        ];
        return collect($array);
    }

    public static function dataTypeCpt()
    {
        $array = [
            [
                'string' => 'part',
                'text' => "Particulier",
                'color' => 'primary'
            ],
            [
                'string' => 'pro',
                'text' => "Professionnel",
                'color' => 'danger'
            ],
            [
                'string' => 'orga',
                'text' => "Organisation / Service Public",
                'color' => 'info'
            ],
            [
                'string' => 'assoc',
                'text' => "Association",
                'color' => 'success'
            ],
        ];
        return collect($array);
    }

    public function getPriceFormatAttribute()
    {
        return eur($this->price);
    }

    public function getTypeCptLabelAttribute()
    {
        $call = self::dataTypeCpt()->where('string', $this->type_cpt)->first();
        return "<span class='badge badge-".$call['color']."'>".$call['text']."</span>";
    }

    public function getTypeCptTextAttribute()
    {
        return self::dataTypeCpt()->where('string', $this->type_cpt)->first()['text'];
    }

    public function getTypePrlvTextAttribute()
    {
        return self::dataTypePrlv()->where('string', $this->type_prlv)->first()['text'];
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($forfait) {
            LogHelper::insertLogSystem('success', "Un forfait bancaire à été créer: ".$forfait->name);
        });

        static::updated(function ($forfait) {
            LogHelper::insertLogSystem('success', "Un forfait bancaire à été éditer: ".$forfait->name);
        });

        static::deleted(function () {
            LogHelper::insertLogSystem('success', "Un forfait bancaire à été supprimer");
        });
    }
}

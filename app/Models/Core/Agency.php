<?php

namespace App\Models\Core;

use App\Helper\CountryHelper;
use App\Models\Document\DocumentTransmiss;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\Core\Agency
 *
 * @property int $id
 * @property string $name
 * @property string $bic
 * @property string $code_banque
 * @property string $code_agence
 * @property string $address
 * @property string $postal
 * @property string $city
 * @property string $country
 * @property string $phone
 * @property int $online
 * @property-read \Illuminate\Database\Eloquent\Collection|DocumentTransmiss[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCodeAgence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCodeBanque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency wherePostal($value)
 * @mixin \Eloquent
 * @mixin IdeHelperAgency
 * @property-read mixed $online_label
 */
class Agency extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['online_label'];

    public $timestamps = false;

    public function documents()
    {
        return $this->hasMany(DocumentTransmiss::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($agency) {
            \Log::info("Création d'une agence: ".$agency->name);
        });

        static::updated(function ($agency) {
            \Log::info("Mise à jour de l'agence: ".$agency->name);
        });
    }

    public function getCountryAttribute($value)
    {
        return CountryHelper::getCountryName(\Str::upper(\Str::limit($value, 2, '')));
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = \Str::upper(\Str::limit($value, 2, ''));
    }

    public function setCodeBanqueAttribute($value)
    {
        $this->attributes['code_banque'] = mt_rand(10000,99999);
    }

    public function setCodeAgenceAttribute($value)
    {
        $this->attributes['code_agence'] = mt_rand(10000,99999);
    }

    public function getOnlineLabelAttribute()
    {
        if ($this->online == 1) {
            return "<span class='badge badge-success'>En Ligne</span>";
        } else {
            return "<span class='badge badge-info'>Agence Physique</span>";
        }
    }

    public static function generateBic($agencyName)
    {
        $replace = Str::replace(' ', '', $agencyName);
        $rep2 = Str::replace('FINTECH', '', $replace);

        $bic =  "FINFRPP".Str::limit($rep2, 3, '');

        $agence = Agency::where('bic', $bic)->count();

        if($agence == 0) {
            return $bic;
        } else {
            return $bic.$agence;
        }
    }
}

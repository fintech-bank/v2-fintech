<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerMobility;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\MobilityType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $contact_banque
 * @property int $liste_mvm
 * @property int $select_mvm
 * @property int $transmission_rib_orga
 * @property int $cloture
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerMobility[] $mobilities
 * @property-read int|null $mobilities_count
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType query()
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType whereCloture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType whereContactBanque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType whereListeMvm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType whereSelectMvm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobilityType whereTransmissionRibOrga($value)
 * @mixin \Eloquent
 */
class MobilityType extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function mobilities()
    {
        return $this->hasMany(CustomerMobility::class);
    }
}

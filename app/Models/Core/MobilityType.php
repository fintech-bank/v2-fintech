<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerMobility;
use Illuminate\Database\Eloquent\Model;

class MobilityType extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function mobilities()
    {
        return $this->hasMany(CustomerMobility::class);
    }
}

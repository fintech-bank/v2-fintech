<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerMobilityCreditor extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['date'];

    public function mobility()
    {
        return $this->belongsTo(CustomerMobility::class, 'customer_mobility_id');
    }
}

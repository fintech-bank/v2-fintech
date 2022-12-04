<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerMobilityMvm extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['date_transfer', 'date_enc'];
}

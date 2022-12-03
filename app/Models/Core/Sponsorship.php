<?php

namespace App\Models\Core;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

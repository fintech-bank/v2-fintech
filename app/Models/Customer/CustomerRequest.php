<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function documents()
    {
        return $this->hasMany(CustomerRequestDocument::class);
    }
}

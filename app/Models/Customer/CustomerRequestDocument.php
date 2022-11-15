<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerRequestDocument extends Model
{
    protected $guarded = [];

    public function request()
    {
        return $this->belongsTo(CustomerRequest::class, 'customer_request_id');
    }
}

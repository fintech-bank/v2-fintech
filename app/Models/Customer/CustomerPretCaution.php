<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerPretCaution extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'date_naissance', 'signed_at'];

    public function loan()
    {
        return $this->belongsTo(CustomerPret::class, 'customer_pret_id');
    }
}

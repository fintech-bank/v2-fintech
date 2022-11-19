<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerInsuranceClaim extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'incidentDate', 'incidentTime'];

    public function insurance()
    {
        return $this->belongsTo(CustomerInsurance::class, 'customer_insurance_id');
    }
}

<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class CreditCardInsurance extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function support()
    {
        return $this->belongsTo(CreditCardSupport::class, 'credit_card_support_id');
    }
}

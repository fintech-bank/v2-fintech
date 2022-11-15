<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerCreditCard;
use Illuminate\Database\Eloquent\Model;

class CreditCardOpposit extends Model
{
    protected $guarded = [];

    public function card()
    {
        return $this->belongsTo(CustomerCreditCard::class, 'customer_credit_card_id');
    }
}

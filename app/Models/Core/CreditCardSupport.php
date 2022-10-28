<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerCreditCard;
use Illuminate\Database\Eloquent\Model;

class CreditCardSupport extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function creditcards()
    {
        return $this->hasMany(CustomerCreditCard::class);
    }

    public function insurance()
    {
        return $this->hasOne(CreditCardInsurance::class);
    }
}

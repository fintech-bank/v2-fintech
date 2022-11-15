<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerCreditCard;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\CreditCardOpposit
 *
 * @property int $id
 * @property string $reference
 * @property string $type
 * @property string $description
 * @property int $verif_fraude
 * @property string $status
 * @property string|null $link_opposit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_credit_card_id
 * @property-read CustomerCreditCard $card
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit whereCustomerCreditCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit whereLinkOpposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardOpposit whereVerifFraude($value)
 * @mixin \Eloquent
 */
class CreditCardOpposit extends Model
{
    protected $guarded = [];

    public function card()
    {
        return $this->belongsTo(CustomerCreditCard::class, 'customer_credit_card_id');
    }
}

<?php

namespace App\Models\Core;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Core\Sponsorship
 *
 * @property int $id
 * @property string $civility
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $postal
 * @property string $city
 * @property string $code
 * @property int $closed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property-read Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsorship whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 */
class Sponsorship extends Model
{
    use Notifiable;
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

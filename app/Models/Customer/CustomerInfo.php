<?php

namespace App\Models\Customer;

use App\Services\Twilio\Lookup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Customer\CustomerInfo
 *
 * @property int $id
 * @property string $type
 * @property string|null $civility
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 * @property \Illuminate\Support\Carbon|null $datebirth
 * @property string|null $citybirth
 * @property string|null $countrybirth
 * @property string|null $company
 * @property string|null $siret
 * @property string $address
 * @property string|null $addressbis
 * @property string $postal
 * @property string $city
 * @property string $country
 * @property string|null $phone
 * @property string $mobile
 * @property string|null $country_code
 * @property string|null $authy_id
 * @property int $isVerified
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\Customer\CustomerInfoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAddressbis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAuthyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCitybirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountrybirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereDatebirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereSiret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereType($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerInfo
 * @property-read int|null $push_subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo verified()
 * @property-read mixed $account_verified
 * @property-read mixed $mobile_verified
 * @property-read mixed $phone_verified
 * @property-read mixed $type_color
 * @property-read mixed $type_label
 * @property-read mixed $type_text
 * @property-read string|null $full_name
 * @property int $addressVerified
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAddressVerified($value)
 * @property string $email
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereEmail($value)
 * @property int $phoneVerified
 * @property int $mobileVerified
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereMobileVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo wherePhoneVerified($value)
 * @property-read mixed $mobile_verify
 * @property-read mixed $phone_verify
 * @property-read mixed $line_address
 * @property int $incomeVerified
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereIncomeVerified($value)
 */
class CustomerInfo extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['datebirth'];
    protected $appends = ['type_label', 'phone_verify', 'mobile_verify', 'account_verified', 'full_name', 'line_address', 'type_text'];

    public function routeNotificationForTwilio()
    {
        return $this->mobile;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeVerified($query)
    {
        return $query->update([
            'isVerified' => 1
        ]);
    }

    public function getFullNameAttribute(): ?string
    {
        if($this->type == 'part') {
            return $this->civility.'. '.$this->lastname.' '.$this->firstname;
        } else {
            return $this->company;
        }
    }

    public function getType($format = '')
    {
        if($format == 'color') {
            return match ($this->type) {
                "part" => "primary",
                "pro" => "danger",
                "orga" => "info",
                "assoc" => "success"
            };
        } elseif($format == 'text') {
            return match ($this->type) {
                "part" => "Particulier",
                "pro" => "Professionnel",
                "orga" => "Organisation / Public",
                "assoc" => "Association"
            };
        } else {
            return match ($this->type) {
                "part" => "fa-user",
                "pro" => "fa-shop",
                "orga" => "fa-building-columns",
                "assoc" => "fa-handshake"
            };
        }
    }

    public function getTypeTextAttribute()
    {
        return $this->getType('text');
    }

    public function getTypeLabelAttribute()
    {
        return '<span class="badge badge-sm badge-'.$this->getType('color').'"><i class="fa-solid '.$this->getType().' text-white me-2"></i> '.$this->getType('text').'</span>';
    }

    public function setPhoneVerified($phone, $type)
    {
        if(isset($phone)) {
            $lookup = new Lookup();
            if($lookup->verify($phone)) {
                $this->update([
                    $type."Verified" => true
                ]);
            } else {
                $this->update([
                    $type."Verified" => false
                ]);
            }
        }
    }

    public function getPhoneVerifyAttribute()
    {
        if($this->phone != null) {
            if($this->phoneVerified == 1) {
                return '<i class="fa-solid fa-check-circle text-success" data-bs-toggle="tooltip" title="Vérifié"></i>';
            } else {
                return '<i class="fa-solid fa-xmark-circle text-danger" data-bs-toggle="tooltip" title="Numéro invalide"></i>';
            }
        }
    }

    public function getMobileVerifyAttribute()
    {
        if($this->mobile != null) {
            if($this->mobileVerified == 1) {
                return '<i class="fa-solid fa-check-circle text-success" data-bs-toggle="tooltip" title="Vérifié"></i>';
            } else {
                return '<i class="fa-solid fa-xmark-circle text-danger" data-bs-toggle="tooltip" title="Numéro invalide"></i>';
            }
        }
    }

    public function getAccountVerifiedAttribute()
    {
        if($this->isVerified) {
            return '<i class="fa-solid fa-check-circle text-success fa-2x" data-bs-toggle="tooltip" title="Compte vérifié" style="font-size: 20px;"></i>';
        } else {
            return '<i class="fa-solid fa-xmark-circle text-danger fa-2x" data-bs-toggle="tooltip" title="Compte non vérifié" style="font-size: 20px;"></i>';
        }
    }

    public function getLineAddressAttribute()
    {
        return $this->address.', '.$this->postal.' '.$this->city;
    }
}

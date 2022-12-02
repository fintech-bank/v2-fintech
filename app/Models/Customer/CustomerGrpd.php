<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerGrpd
 *
 * @property int $id
 * @property int $edocument
 * @property int $content_com
 * @property int $content_geo
 * @property int $content_social
 * @property int $rip_newsletter
 * @property int $rip_commercial
 * @property int $rip_survey
 * @property int $rip_sponsorship
 * @property int $rip_canal_mail
 * @property int $rip_canal_sms
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereContentCom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereContentGeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereContentSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereEdocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereRipCanalMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereRipCanalSms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereRipCommercial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereRipNewsletter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereRipSponsorship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpd whereRipSurvey($value)
 * @mixin \Eloquent
 */
class CustomerGrpd extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

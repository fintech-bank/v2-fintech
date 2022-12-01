<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerSetting
 *
 * @property int $id
 * @property int $notif_sms
 * @property int $notif_app
 * @property int $notif_mail
 * @property int $nb_physical_card
 * @property int $nb_virtual_card
 * @property int $check
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSettingFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNbPhysicalCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNbVirtualCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifApp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifSms($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerSetting
 * @property int $alerta
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereAlerta($value)
 * @property int $card_code
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCardCode($value)
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @property int $gauge
 * @property int $gauge_show_solde
 * @property int $gauge_show_op_waiting Opération en traitement
 * @property int $gauge_show_last_op
 * @property int $gauge_start
 * @property int $gauge_end
 * @property int|null $customer_wallet_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereGauge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereGaugeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereGaugeShowLastOp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereGaugeShowOpWaiting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereGaugeShowSolde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereGaugeStart($value)
 * @property int $securpass
 * @property string|null $securpass_key
 * @property string|null $securpass_model
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereSecurpass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereSecurpassKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereSecurpassModel($value)
 */
class CustomerSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }
}

<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerTransfer
 *
 * @property int $id
 * @property string $uuid
 * @property float $amount
 * @property string $reference
 * @property string $reason
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $transfer_date
 * @property \Illuminate\Support\Carbon|null $recurring_start
 * @property \Illuminate\Support\Carbon|null $recurring_end
 * @property string $status
 * @property int|null $transaction_id
 * @property int $customer_wallet_id
 * @property int $customer_beneficiaire_id
 * @property-read \App\Models\Customer\CustomerBeneficiaire $beneficiaire
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerTransferFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereCustomerBeneficiaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereRecurringEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereRecurringStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereTransferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerTransfer
 * @property-read mixed $amount_format
 * @property string $access
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereAccess($value)
 * @property-read mixed $status_label
 * @property-read mixed $status_bullet
 * @property-read mixed $date_format
 * @property-read mixed $type_text
 */
class CustomerTransfer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['transfer_date', 'recurring_start', 'recurring_end'];
    protected $appends = ['amount_format', 'status_label', 'status_bullet', 'type_text', 'date_format'];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function beneficiaire()
    {
        return $this->belongsTo(CustomerBeneficiaire::class, 'customer_beneficiaire_id');
    }

    public function getAmountFormatAttribute()
    {
        return eur($this->amount);
    }

    public function getTypeTextAttribute()
    {
        return match ($this->type) {
            "immediat" => "Virement Ponctuel",
            "differed" => "Virement Différé",
            "permanent" => "Virement Permanent"
        };
    }

    public function getStatus($format = 'color')
    {
        if($format == 'text') {
            return match($this->status) {
                "paid" => "Exécuter",
                "pending" => "En attente",
                "in_transit" => "Requete envoyé à la banque distante",
                "canceled" => "Annuler",
                default => "Rejeter"
            };
        } elseif ($format == 'icon') {
            return match($this->status) {
                "paid" => "check-circle",
                "pending" => "spinner fa-spin-pulse",
                "in_transit" => "money-bill-transfer",
                "canceled" => "xmark-circle",
                default => "ban"
            };
        } elseif ($format == 'comment') {
            return match($this->status) {
                "paid" => "Votre ordre de virement à été traité",
                "pending" => "Votre ordre de virement est en cours de validation",
                "in_transit" => "Votre ordre de virement est cours d'exécution",
                "canceled" => "Votre ordre de virement à été annulé",
                default => "Votre ordre de virement à été refusé par notre service financier"
            };
        } else {
            return match($this->status) {
                "paid" => "success",
                "pending" => "info",
                "in_transit" => "warning",
                default => "danger"
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-".$this->getStatus()." badge-sm'><i class='fa-solid fa-".$this->getStatus('icon')." me-2 text-white'></i> ".$this->getStatus('text')."</span>";
    }

    public function getStatusBulletAttribute()
    {
        return '<i class="fa-solid fa-circle-dot fs-1 text-'.$this->getStatus().' me-3"></i> '.$this->getStatus('comment');
    }

    public function getDateFormatAttribute()
    {
        return match ($this->type) {
            "immediat", "differed" => $this->transfer_date->format("d/m/Y"),
            "permanent" => $this->recurring_start->format('d/m/Y')
        };
    }
}

<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerCheck
 *
 * @property int $id
 * @property string $reference
 * @property int $tranche_start
 * @property int $tranche_end
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerCheckFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereTrancheEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereTrancheStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerCheck
 * @property-read mixed $status_label
 */
class CustomerCheck extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status_label'];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function getStatus($format = '')
    {
        if ($format == 'text') {
            return match($this->status) {
                "checkout" => "Commande effectué",
                "manufacture" => "Création en cours...",
                "ship" => "Envoie en cours",
                "outstanding" => "Utilisation en cours",
                "finish" => "Terminé",
                "destroy" => "Détruit"
            };
        } elseif ($format == 'color') {
            return match($this->status) {
                "checkout" => "primary",
                "manufacture", "outstanding" => "info",
                "ship" => "warning",
                "finish" => "success",
                "destroy" => "danger"
            };
        } else {
            return match($this->status) {
                "checkout" => "fa-shopping-bag",
                "manufacture" => "fa-cogs",
                "ship" => "fa-truck-fast",
                "outstanding" => "fa-spinner fa-spin-pulse",
                "finish" => "fa-check-circle",
                "destroy" => "fa-circle-xmark"
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-{$this->getStatus('color')}'><i class='fa-solid {$this->getStatus()} text-white me-2'></i> {$this->getStatus('text')}</span>";
    }
}

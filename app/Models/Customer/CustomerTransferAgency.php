<?php

namespace App\Models\Customer;

use App\Models\Core\Agency;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerTransferAgency
 *
 * @property int $id
 * @property string $reference
 * @property string $status
 * @property int $transfer_account
 * @property int $transfer_joint
 * @property int $transfer_all
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property int $agency_id
 * @property-read Agency $agency
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency whereTransferAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency whereTransferAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency whereTransferJoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransferAgency whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $status_label
 */
class CustomerTransferAgency extends Model
{
    protected $guarded = [];
    protected $appends = ['status_label'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id');
    }

    public function getStatus($format = '')
    {
        if ($format == 'text') {
            return match ($this->status) {
                "waiting" => "En attente",
                "progress" => "Transfert en cours...",
                "terminated" => "Transfert Terminer",
                default => "Transfert Échouer"
            };
        } elseif ($format == 'color') {
            return match ($this->status) {
                "waiting" => "info",
                "progress" => "warning",
                "terminated" => "success",
                default => "danger"
            };
        } else {
            return match ($this->status) {
                "waiting" => "pause",
                "progress" => "spinner fa-spin-pulse",
                "terminated" => "circle-check",
                default => "circle-xmark"
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-{$this->getStatus('color')}'><i class='fa-solid fa-{$this->getStatus()} text-white me-2'></i> {$this->getStatus('text')}</span>";
    }
}

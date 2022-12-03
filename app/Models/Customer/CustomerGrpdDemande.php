<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerGrpdDemande
 *
 * @property int $id
 * @property string $type
 * @property string $object
 * @property string $comment
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGrpdDemande whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $type_text
 * @property-read mixed $status_label
 */
class CustomerGrpdDemande extends Model
{
    protected $guarded = [];
    protected $appends = ['type_text', 'status_label'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getTypeTextAttribute()
    {
        return match ($this->type) {
            "com_prospecting" => "Droit à la prospection des informations clientèle",
            "personal_data" => "Accéder à vos données personnelles traitées",
            "inacurate" => "Rectifier vos données personnelles",
            "erasure" => "Effacement de certaines de vos données personnelles",
            "limit" => "Limiter l’utilisation de vos données personnelles",
            "portability" => "Exercer votre droit à la portabilité",
        };
    }

    public function getStatus($format = '')
    {
        if ($format == 'text') {
            return match ($this->status) {
                "pending" => "En attente",
                "terminated" => "Terminer",
                "cancel" => "Annuler",
                default => "Rejeter"
            };
        } elseif ($format == 'color') {
            return match ($this->status) {
                "pending" => "warning",
                "terminated" => "success",
                default => "danger"
            };
        } else {
            return match ($this->status) {
                "pending" => "fa-spinner fa-spin-pulse",
                "terminated" => "fa-check-circle",
                "cancel" => "fa-ban",
                default => "fa-xmark-circle"
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-{$this->getStatus('color')}'><i class='fa-solid {$this->getStatus()} text-white me-2'></i> {$this->getStatus('text')}</span>";
    }
}

<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerRequest
 *
 * @property int $id
 * @property string $sujet
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerRequestDocument[] $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereSujet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $reference
 * @property string|null $commentaire
 * @property string|null $link_model
 * @property int|null $link_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereLinkModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereReference($value)
 * @property-read mixed $model_data
 * @property-read mixed $status_label
 */
class CustomerRequest extends Model
{
    protected $guarded = [];
    protected $appends = ['model_data', 'status_label'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function documents()
    {
        return $this->hasMany(CustomerRequestDocument::class);
    }

    public function getStatus($format = '')
    {
        if ($format == 'text') {
            return match ($this->status) {
                "waiting" => "En attente",
                "progress" => "Traitement en cours...",
                "terminated" => "Traité",
                default => "Expiré"
            };
        } elseif ($format == 'color') {
            return match ($this->status) {
                "waiting", "progress" => "warning",
                "terminated" => "success",
                default => "danger"
            };
        } else {
            return match ($this->status) {
                "waiting" => "fa-hand",
                "progress" => "fa-spinner fa-spin-pulse",
                "terminated" => "fa-check-circle",
                default => "fa-clock"
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-{$this->getStatus('color')}'><i class='fa-solid {$this->getStatus()} text-white me-2'></i> {$this->getStatus('text')}</span>";
    }

    public function getModelDataAttribute()
    {
        return match ($this->link_model) {
            "App\Models\Customer\CustomerEpargne" => "Compte Epargne",
            "App\Models\Customer\CustomerPret" => "Crédit",
            "App\Models\Customer\CustomerWallet" => "Compte",
        };
    }
}

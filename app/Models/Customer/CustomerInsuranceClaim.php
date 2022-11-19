<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerInsuranceClaim
 *
 * @property int $id
 * @property string $reference
 * @property string $status
 * @property int $responsability
 * @property \Illuminate\Support\Carbon $incidentDate
 * @property \Illuminate\Support\Carbon|null $incidentTime
 * @property string $incidentDesc
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_insurance_id
 * @property-read \App\Models\Customer\CustomerInsurance $insurance
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim whereCustomerInsuranceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim whereIncidentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim whereIncidentDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim whereIncidentTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim whereResponsability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsuranceClaim whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerInsuranceClaim extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'incidentDate', 'incidentTime'];
    protected $appends = ['status_label'];

    public function insurance()
    {
        return $this->belongsTo(CustomerInsurance::class, 'customer_insurance_id');
    }

    public function getStatus($format = '')
    {
        if($format == 'text') {
            return match($this->status) {
                "waiting" => "En attente",
                "progress" => "En cours",
                "finish" => "Terminer",
            };
        } elseif ($format == 'color') {
            return match($this->status) {
                "waiting" => "info",
                "progress" => "warning",
                "finish" => "success",
            };
        } else {
            return match($this->status) {
                "waiting" => "fa-pen",
                "progress" => "fa-spin fa-spinner-pulse",
                "finish" => "fa-check-circle",
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-{$this->getStatus('color')}'><i class='fa-solid {$this->getStatus()} text-white me-2'></i> {$this->getStatus('text')}</span>";
    }
}

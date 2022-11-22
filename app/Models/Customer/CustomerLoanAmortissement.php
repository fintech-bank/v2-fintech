<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerLoanAmortissement
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $date_prlv
 * @property float $amount
 * @property float $capital_du
 * @property string $status
 * @property int $customer_pret_id
 * @property-read \App\Models\Customer\CustomerPret $loan
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereCapitalDu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereCustomerPretId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereDatePrlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerLoanAmortissement whereStatus($value)
 * @mixin \Eloquent
 * @property-read mixed $amount_format
 * @property-read mixed $capital_du_format
 * @property-read mixed $status_label
 */
class CustomerLoanAmortissement extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['date_prlv'];
    protected $appends = ['amount_format', 'capital_du_format', 'status_label'];

    public function loan()
    {
        return $this->belongsTo(CustomerPret::class, 'customer_pret_id');
    }

    public function getAmountFormatAttribute()
    {
        return eur($this->amount);
    }

    public function getCapitalDuFormatAttribute()
    {
        return eur($this->amount);
    }

    public function getStatus($format = '')
    {
        if($format == 'text') {
            return match ($this->status) {
                "program" => "Programmé",
                "progress" => "Echéance en cours...",
                "finish" => "Payé",
                "error" => "Erreur de Paiement",
            };
        } elseif ($format == 'color') {
            return match ($this->status) {
                "program" => "info",
                "progress" => "warning",
                "finish" => "success",
                "error" => "danger",
            };
        } else {
            return match ($this->status) {
                "program" => "fa-clock",
                "progress" => "fa-circle-notch fa-spin ",
                "finish" => "fa-check-circle",
                "error" => "fa-circle-exclamation",
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-{$this->getStatus('color')}'><i class='fa-solid {$this->getStatus()} text-white me-2'></i> {$this->getStatus('text')}</span>";
    }
}

<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\InvoicePayment
 *
 * @property int $id
 * @property float $amount
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $invoice_id
 * @property int|null $customer_transaction_id
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereCustomerTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $amount_format
 * @property-read mixed $status_color
 * @property-read mixed $status_icon
 * @property-read mixed $status_label
 * @property-read mixed $status_text
 * @property-read \App\Models\Core\Invoice $invoice
 * @property-read CustomerTransaction|null $transaction
 */
class InvoicePayment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['amount_format', 'status_text', 'status_label'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function transaction()
    {
        return $this->belongsTo(CustomerTransaction::class, 'customer_transaction_id');
    }

    public function getAmountFormatAttribute()
    {
        return eur($this->amount);
    }

    public function getStatusTextAttribute()
    {
        switch ($this->state) {
            case 'succeeded': return 'Succès';
            case 'pending': return 'En attente';
            case 'failed': return 'Echec';
            default: return 'Inconnue';
        }
    }

    public function getStatusColorAttribute()
    {
        switch ($this->state) {
            case 'succeeded': return 'success';
            case 'pending': return 'warning';
            case 'failed': return 'danger';
            default: return 'light';
        }
    }

    public function getStatusIconAttribute()
    {
        switch ($this->state) {
            case 'succeeded': return '<i class="fa-solid fa-check text-white me-2"></i>';
            case 'pending': return '<i class="fa-solid fa-spinner fa-spin text-white me-2"></i>';
            case 'failed': return '<i class="fa-solid fa-xmark text-white me-2"></i>';
            default: return '';
        }
    }

    public function getStatusLabelAttribute()
    {
        return '<span class="badge badge-'.$this->getStatusColorAttribute().'">'.$this->getStatusIconAttribute().' '.$this->getStatusTextAttribute().'</span>';
    }
}

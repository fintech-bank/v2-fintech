<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\InvoiceProduct
 *
 * @property int $id
 * @property string $label
 * @property float $amount
 * @property int $invoice_id
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereLabel($value)
 * @mixin \Eloquent
 * @property-read mixed $amount_format
 * @property-read \App\Models\Core\Invoice $invoice
 */
class InvoiceProduct extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['amount_format'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function getAmountFormatAttribute()
    {
        return eur($this->amount);
    }
}

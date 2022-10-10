<?php

namespace App\Models\Core;

use App\Models\Customer\Customer;
use App\Models\Reseller\Reseller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\Core\Invoice
 *
 * @property int $id
 * @property string $reference
 * @property float $amount
 * @property string $state
 * @property string $collection_method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $customer_id
 * @property int|null $reseller_id
 * @property-read Customer|null $customer
 * @property-read mixed $amount_format
 * @property-read mixed $status_text
 * @property-read Reseller|null $reseller
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCollectionMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereResellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $status_color
 * @property-read mixed $status_icon
 * @property-read mixed $status_label
 * @property-read \App\Models\Core\InvoicePayment|null $payment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\InvoiceProduct[] $products
 * @property-read int|null $products_count
 * @property-read mixed $due_at
 */
class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['amount_format', 'status_text', 'status_label', 'due_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class, 'reseller_id');
    }

    public function payment()
    {
        return $this->hasOne(InvoicePayment::class);
    }

    public function products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public function getAmountFormatAttribute()
    {
        return eur($this->amount);
    }

    public function getStatusTextAttribute()
    {
        switch ($this->state) {
            case 'draft': return 'Brouillon';
            case 'open': return 'Ouvert';
            case 'paid': return 'Payer';
            case 'uncollectible': return 'Non Recouvrable';
            default: return 'Inconnue';
        }
    }

    public function getStatusColorAttribute()
    {
        switch ($this->state) {
            case 'draft': return 'light';
            case 'open': return 'primary';
            case 'paid': return 'success';
            case 'uncollectible': return 'danger';
            default: return 'light';
        }
    }

    public function getStatusIconAttribute()
    {
        switch ($this->state) {
            case 'draft': return '<i class="fa-solid fa-pen me-2"></i>';
            case 'open': return '<i class="fa-solid fa-unlock text-white me-2"></i>';
            case 'paid': return '<i class="fa-solid fa-check text-white me-2"></i>';
            case 'uncollectible': return '<i class="fa-solid fa-xmark text-white me-2"></i>';
            default: return '';
        }
    }

    public function getStatusLabelAttribute()
    {
        return '<span class="badge badge-'.$this->getStatusColorAttribute().'">'.$this->getStatusIconAttribute().' '.$this->getStatusTextAttribute().'</span>';
    }

    public function getDueAtAttribute()
    {
        return $this->created_at->addDays(7)->startOfDay();
    }

    public static function generateReference()
    {
        return Str::upper(Str::random(8));
    }
}

<?php

namespace App\Models\Customer;

use App\Helper\CustomerTransactionHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerSepa
 *
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCreditor[] $creditor
 * @property string $number_mandate
 * @property float $amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $transaction_id
 * @property int $customer_wallet_id
 * @property-read int|null $creditor_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerSepaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereCreditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereNumberMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerSepa
 * @property-read mixed $amount_format
 * @property-read mixed $status_label
 * @property string $processed_time
 * @property-read mixed $status_comment
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereProcessedTime($value)
 * @property-read mixed $processed_time_format
 * @property-read mixed $status_text
 * @property-read mixed $updated_at_format
 * @property-read \App\Models\Customer\CustomerCreditor|null $creditors
 */
class CustomerSepa extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = [
        'amount_format',
        'status_label',
        'status_comment',
        'status_text',
        'processed_time_format',
        'updated_at_format'
    ];
    protected $dates = ["created_at", "updated_at", "processed_time"];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function creditors()
    {
        return $this->hasOne(CustomerCreditor::class);
    }

    public function getAmountFormatAttribute()
    {
        return eur($this->amount);
    }

    public function getStatus($type = 'icon')
    {
        if($type == 'text') {
            return match ($this->status) {
                "waiting" => "En attente",
                "processed" => "Traité",
                "rejected" => "Rejeté",
                "return" => "Retourné",
                default => "Remboursé"
            };
        } elseif ($type == 'color') {
            return match ($this->status) {
                "waiting" => "warning",
                "processed" => "success",
                "rejected", "return" => "danger",
                default => "info"
            };
        } elseif($type == 'comment') {
            return match ($this->status) {
                "waiting" => "Le prélèvement va se présenter prochainement",
                "processed" => "Le Prélèvement à été traité",
                "rejected" => "Le prélèvement à été rejeté par notre service financier",
                "return" => "Le prélèvement à été retourné à votre créancier",
                default => "Le prélèvement à été remboursé"
            };
        } else {
            return match ($this->status) {
                "waiting" => "spinner fa-spin-pulse",
                "processed" => "check-circle",
                "rejected" => "ban",
                "return" => "rotate-left",
                default => "euro-sign"
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-".$this->getStatus('color')."'><i class='fa-solid fa-".$this->getStatus()." text-white me-2'></i> ".$this->getStatus('text')."</span>";
    }

    public function getStatusCommentAttribute()
    {
        return '<i class="fa-solid fa-circle-dot fs-1 text-'.$this->getStatus('color').' me-3"></i> '.$this->getStatus('comment');
    }

    public function getStatusTextAttribute()
    {
        return $this->getStatus('text');
    }

    public function getProcessedTimeFormatAttribute()
    {
        return $this->processed_time->format("d/m/Y");
    }

    public function getUpdatedAtFormatAttribute()
    {
        return $this->updated_at->format("d/m/Y");
    }

    public function getReasonFromRejected($reason)
    {
        $arr = [
            'reject.debit' => "Solde insuffisant",
        ];

        $collect = collect([
            [
                'key' => 'reject.debit',
                'reason' => "Solde Insuffisant"
            ]
        ]);
        $search = $collect->where('key', $reason)->first();
        return $search['reason'];
    }

    public static function rejected($callback)
    {
        static::registerModelEvent('rejected', $callback);
    }

    public static function boot()
    {
        parent::boot();

        static::rejected(function ($sepa) {
            CustomerTransactionHelper::create(
                'debit',
                'frais',
                "Frais rejet Prélèvement - {$sepa->number_mandate}",
                2.5,
                $sepa->wallet->id,
                true,
                'Frais Bancaire',
                now()
            );
        });
    }
}

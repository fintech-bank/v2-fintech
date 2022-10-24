<?php

namespace App\Models\Reseller;

use App\Helper\LogHelper;
use App\Models\Core\Invoice;
use App\Models\Core\Shipping;
use App\Models\Customer\CustomerWithdrawDab;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reseller\Reseller
 *
 * @property-read CustomerWithdrawDab|null $dab
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller query()
 * @mixin \Eloquent
 * @property int $id
 * @property float $limit_outgoing
 * @property float $limit_incoming
 * @property int $user_id
 * @property int $customer_withdraw_dabs_id
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereCustomerWithdrawDabsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereLimitIncoming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereLimitOutgoing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereUserId($value)
 * @property string $status
 * @property-read mixed $status_label
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereStatus($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Shipping[] $shippings
 * @property-read int|null $shippings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property float $percent_outgoing
 * @property float $percent_incoming
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller wherePercentIncoming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller wherePercentOutgoing($value)
 */
class Reseller extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['status_label'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dab()
    {
        return $this->belongsTo(CustomerWithdrawDab::class, 'customer_withdraw_dabs_id');
    }

    public function shippings()
    {
        return $this->belongsToMany(Shipping::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'open': return '<span class="badge badge-primary">Dossier ouvert</span>';
            case 'pending': return '<span class="badge badge-warning">Vérification en cours</span>';
            case 'active': return '<span class="badge badge-success">Distributeur Actif</span>';
            case 'cancel': return '<span class="badge badge-danger">Dossier Clotûrer</span>';
        }
    }

    public function calcRemainingOutgoing()
    {
        $sum = $this->dab->withdraws()
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->where('status', 'terminated')
            ->sum('amount');

        return $this->limit_outgoing - $sum;
    }

    public function calcRemainingOutgoingPercent()
    {
        $sum = $this->calcRemainingOutgoing();
        return intval($sum * 100 / $this->limit_outgoing);
    }

    public function calcRemainingIncoming()
    {
        $sum = $this->dab->moneys()
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->where('status', 'terminated')
            ->sum('amount');

        return $this->limit_incoming - $sum;
    }

    public function calcRemainingIncomingPercent()
    {
        $sum = $this->calcRemainingIncoming();
        return intval($sum * 100 / $this->limit_incoming);
    }



    public static function boot()
    {
        parent::boot();

        static::created(function ($reseller) {
            LogHelper::insertLogSystem('success', "Un distributeur à été ajouté: ".$reseller->dab->name);
        });

        static::updated(function ($reseller) {
            LogHelper::insertLogSystem('success', "Un distributeur à été edité: ".$reseller->dab->name);
        });

        static::deleted(function () {
            LogHelper::insertLogSystem('success', "Un distributeur à été supprimé");
        });
    }
}

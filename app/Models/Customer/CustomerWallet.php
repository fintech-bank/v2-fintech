<?php

namespace App\Models\Customer;

use App\Helper\CustomerWalletTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerWallet
 *
 * @property int $id
 * @property string $uuid
 * @property string $number_account
 * @property string $iban
 * @property string $rib_key
 * @property string $type
 * @property string $status
 * @property float $balance_actual
 * @property float $balance_coming
 * @property int $decouvert
 * @property float $balance_decouvert
 * @property int $alert_debit
 * @property int $alert_fee
 * @property \Illuminate\Support\Carbon|null $alert_date
 * @property int $customer_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCreditCard[] $cards
 * @property-read int|null $cards_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheck[] $checks
 * @property-read int|null $checks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCreditor[] $creditors
 * @property-read int|null $creditors_count
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \App\Models\Customer\CustomerEpargne|null $epargne
 * @property-read \App\Models\Customer\CustomerEpargne|null $epargne_payment
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelia
 * @property-read \App\Models\Customer\CustomerPret|null $loan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerRefundAccount[] $refunds
 * @property-read int|null $refunds_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerSepa[] $sepas
 * @property-read int|null $sepas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransfer[] $transfers
 * @property-read int|null $transfers_count
 * @method static \Database\Factories\Customer\CustomerWalletFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereAlertDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereAlertDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereAlertFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereBalanceActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereBalanceComing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereBalanceDecouvert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereDecouvert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereNumberAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereRibKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerWallet
 * @property-read \App\Models\Customer\CustomerMobility|null $mobility
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerWithdraw[] $withdraws
 * @property-read int|null $withdraws_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheckDeposit[] $deposit_check
 * @property-read int|null $deposit_check_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheckDeposit[] $depositCheck
 * @property-read string|null $type_text
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheckDeposit[] $deposits
 * @property-read int|null $deposits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMoneyDeposit[] $moneys
 * @property-read int|null $moneys_count
 * @property float $taux_decouvert
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereTauxDecouvert($value)
 * @property int $nb_alert
 * @property-read mixed $name_account
 * @property-read mixed $name_account_generic
 * @property-read mixed $status_label
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereNbAlert($value)
 * @property-read mixed $solde_remaining
 * @property-read mixed $sum_month_operation
 * @property-read mixed $balance_actual_format
 * @property-read mixed $alert_status_comment
 * @property-read mixed $alert_status_text
 * @property-read mixed $status_color
 * @property-read mixed $status_text
 * @property-read mixed $iban_format
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerInsurance[] $insurances
 * @property-read int|null $insurances_count
 */
class CustomerWallet extends Model
{
    use HasFactory, CustomerWalletTrait;

    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['alert_date'];

    protected $appends = [
        'type_text',
        'status_label',
        'status_color',
        'status_text',
        'name_account',
        'name_account_generic',
        'sum_month_operation',
        'solde_remaining',
        'balance_actual_format',
        'alert_status_text',
        'alert_status_comment',
        'iban_format'
    ];

    public static function getState()
    {
        $arr = [
            [
                'name' => 'En attente',
                'slug' => 'pending'
            ],
            [
                'name' => 'Actif',
                'slug' => 'active'
            ],
            [
                'name' => 'Suspendu',
                'slug' => 'suspended'
            ],
            [
                'name' => 'Clôturer',
                'slug' => 'closed'
            ]
        ];

        return collect($arr);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cards()
    {
        return $this->hasMany(CustomerCreditCard::class);
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    public function sepas()
    {
        return $this->hasMany(CustomerSepa::class);
    }

    public function creditors()
    {
        return $this->hasMany(CustomerCreditor::class);
    }

    public function transfers()
    {
        return $this->hasMany(CustomerTransfer::class);
    }

    public function loan()
    {
        return $this->hasOne(CustomerPret::class);
    }

    public function epargne()
    {
        return $this->hasOne(CustomerEpargne::class, 'wallet_id');
    }

    public function epargne_payment()
    {
        return $this->hasOne(CustomerEpargne::class);
    }

    public function checks()
    {
        return $this->hasMany(CustomerCheck::class);
    }

    public function facelia()
    {
        return $this->hasOne(CustomerFacelia::class);
    }

    public function refunds()
    {
        return $this->hasMany(CustomerRefundAccount::class);
    }

    public function mobility()
    {
        return $this->hasOne(CustomerMobility::class);
    }

    public function withdraws()
    {
        return $this->hasMany(CustomerWithdraw::class);
    }

    public function deposits()
    {
        return $this->hasMany(CustomerCheckDeposit::class);
    }

    public function moneys()
    {
        return $this->hasMany(CustomerMoneyDeposit::class);
    }

    public function insurances()
    {
        return $this->hasMany(CustomerInsurance::class);
    }

    /**
     * @return string|null
     */
    public function getTypeTextAttribute(): ?string
    {
        return match ($this->type) {
            'compte' => 'Compte Courant',
            'pret' => 'Pret Bancaire',
            'epargne' => 'Compte Epargne',
            default => null,
        };
    }

    public function getStatus($status, $type = null)
    {
        if ($type == 'text') {
            return match ($status) {
                'pending' => 'En attente',
                'active' => 'Actif',
                'suspended' => 'Suspendue',
                default => 'Clôturer'
            };
        } elseif ($type == 'color') {
            return match ($status) {
                'pending' => 'info',
                'active' => 'success',
                'suspended' => 'warning',
                default => 'danger'
            };
        } else {
            return match ($status) {
                'pending' => 'spinner-third',
                'active' => 'check-circle',
                'suspended' => 'triangle-exclamation',
                default => 'xmark-cirlce'
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return '<span class="badge badge-' . $this->getStatus($this->status, 'color') . '"><i class="fa-solid fa-'.$this->getStatus($this->status).' text-white me-2"></i> ' . $this->getStatus($this->status, 'text') . '</span>';
    }

    public function getStatusColorAttribute()
    {
        return $this->getStatus($this->status, 'color');
    }

    public function getStatusTextAttribute()
    {
        return $this->getStatus($this->status, 'text');
    }

    public function getNameAccountAttribute()
    {
        return $this->customer->info->full_name.' - '.$this->type_text.' N°'.$this->number_account;
    }

    public function getNameAccountGenericAttribute()
    {
        return $this->type_text.' N°'.$this->number_account;
    }

    public function getSoldeRemainingAttribute()
    {
        return $this->balance_actual + $this->balance_decouvert;
    }

    public function getSumMonthOperationAttribute()
    {
        return $this->transactions()->whereBetween('updated_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->where('confirmed', false)
            ->orderBy('updated_at', 'desc')
            ->sum('amount');
    }

    public function getBalanceActualFormatAttribute()
    {
        if($this->balance_actual < 0) {
            return eur($this->balance_actual);
        } else {
            return "+ ".eur($this->balance_actual);
        }
    }

    public function getAlertStatusTextAttribute()
    {
        if($this->nb_alert == 1) {
            return 'Compte Problématique';
        } elseif ($this->nb_alert > 1 && $this->nb_alert <= 3) {
            return 'Compte en danger';
        } else {
            return "Compte dangereux";
        }
    }

    public function getAlertStatusCommentAttribute()
    {
        if($this->nb_alert == 1) {
            return 'Ce compte présente une alerte de débit de niveau 1.<br> Une alerte a été envoyer au client.';
        } elseif ($this->nb_alert > 1 && $this->nb_alert <= 3) {
            return 'Ce compte présente une alerte de débit de niveau 2 ou 3.<br>Veuillez prendre contact avec le client.';
        } else {
            return 'Ce compte présente une alerte de débit de niveau 4.<br>Veuillez prendre contact avec le client afin de lui proposer un compte plus en adéquation.';
        }
    }

    public function requestOverdraft()
    {
        $taux = $this->getTauxOverdraftByType();

        $info = match ($this->customer->info->type) {
            'part' => $this->calcOverdraftPart(),
            'pro', 'orga', 'assoc' => $this->calcOverdraftPro(),
        };

        if($info['result'] == 4) {
            return [
                'access' => true,
                'value' => $info['amount'] > $this->getLimitOverdraftByType() ? eur($this->getLimitOverdraftByType()) : eur(ceil($info['amount']/100) * 100),
                'taux' => $taux." %"
            ];
        } else {
            return [
                'access' => false,
                'errors' => $info['messages']
            ];
        }
    }

    public function getIbanFormatAttribute()
    {
        return \Str::replace("\r\n", " ", chunk_split($this->iban, 4));
    }

    private function calcOverdraftPart()
    {
        $c = 0;
        $r = collect();
        $incoming = $this->customer->income->pro_incoming;

        $result = $incoming / 3;

        if($result <= 300) {
            $c--;
            $r->push(["Votre revenue es inférieur à ".eur(1000)]);
        } else {
            $c++;
        }

        if($this->customer->situation->pro_category !== 'Sans Emploie') {
            $c++;
        } else {
            $c--;
            $r->push(["Votre situation professionnel ne permet pas un découvert bancaire"]);
        }

        if($this->customer->wallets()->where('type', 'compte')->get()->sum('balance_actual') >= 0) {
            $c++;
        } else {
            $c--;
            $r->push(["La somme de vos comptes bancaires est débiteur."]);
        }

        if($this->customer->wallets()->where('type', 'compte')->get()->sum('balance_decouvert') > 0) {
            $c--;
            $r->push(["Vous avez déjà un découvert"]);
        } else {
            $c++;
        }

        return [
            'result' => $c,
            'messages' => $r,
            'amount' => $result
        ];
    }
    private function calcOverdraftPro()
    {
        $c = 0;
        $r = collect();

        $ca = $this->customer->wallets()->where('type', 'compte')->sum('balance_actual') + $this->customer->business->ca;
        $result = $this->customer->wallets()->where('type', 'compte')->sum('balance_actual') + $this->customer->business->result;

        if($ca <= 3000) {
            $c--;
            $r->push(["Votre Chiffre d'affaire est inférieur à ".eur(3000)]);
        } else {
            $c++;
        }

        if($this->customer->wallets()->where('type', 'compte')->get()->sum('balance_actual') >= 0) {
            $c++;
        } else {
            $c--;
            $r->push(["La somme de vos comptes bancaires est débiteur."]);
        }

        if($this->customer->business->indicator) {
            $c++;
        } else {
            $c--;
            $r->push(["L'indicateur prévisionnel indique un avis défavorable"]);
        }

        if($this->customer->wallets()->where('type', 'compte')->get()->sum('balance_decouvert') > 0) {
            $c--;
            $r->push(["Vous avez déjà un découvert"]);
        } else {
            $c++;
        }

        return [
            'result' => $c,
            'messages' => $r,
            'amount' => $result
        ];
    }

    private function getTauxOverdraftByType()
    {
        return match ($this->customer->info->type) {
            'part' => 9.98,
            'pro' => 8.39,
            'orga' => 3.38,
            'assoc' => 2.00
        };
    }

    private function getLimitOverdraftByType()
    {
        return match ($this->customer->info->type) {
            'part' => 1000,
            'pro', 'orga' => 5000,
            'assoc' => 2000
        };
    }

    public function alert($alert)
    {
        return match ($alert) {
            'physical_exceeded' => $this->numberPhysicalBankCardExceeded(),
            'virtual_exceeded' => $this->numberVirtualBankCardExceeded(),
        };
    }

}

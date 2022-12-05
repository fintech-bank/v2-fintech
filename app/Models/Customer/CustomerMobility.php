<?php

namespace App\Models\Customer;

use App\Models\Core\Bank;
use App\Models\Core\MobilityType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Customer\CustomerMobility
 *
 * @mixin IdeHelperCustomerMobility
 * @property int $id
 * @property string $status
 * @property string $old_iban
 * @property string|null $old_bic
 * @property string $mandate
 * @property Carbon $start
 * @property Carbon $end_prov
 * @property string|null $env_real
 * @property Carbon|null $end_prlv
 * @property int $close_account
 * @property string|null $comment
 * @property string|null $code
 * @property int $customer_id
 * @property int $bank_id
 * @property int $customer_wallet_id
 * @property-read Bank $bank
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobilityCheque[] $cheques
 * @property-read int|null $cheques_count
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobilityVirIncoming[] $incomings
 * @property-read int|null $incomings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobilityVirOutgoing[] $outgoings
 * @property-read int|null $outgoings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobilityPrlv[] $prlvs
 * @property-read int|null $prlvs_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCloseAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereEndPrlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereEndProv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereEnvReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereOldBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereOldIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereStatus($value)
 * @property Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereUpdatedAt($value)
 * @property-read mixed $comment_text
 * @property-read mixed $status_color
 * @property-read mixed $status_label
 * @property-read mixed $status_text
 * @property string $name_mandate
 * @property string $ref_mandate
 * @property string $name_account
 * @property string $iban
 * @property string $bic
 * @property string $address
 * @property string|null $addressbis
 * @property string $postal
 * @property string $ville
 * @property string $country
 * @property Carbon $date_transfer
 * @property int $cloture
 * @property Carbon|null $created_at
 * @property int $mobility_type_id
 * @property-read MobilityType $types
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereAddressbis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCloture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereDateTransfer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereMobilityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereNameAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereNameMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereRefMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereVille($value)
 * @property-read MobilityType $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobilityMvm[] $mouvements
 * @property-read int|null $mouvements_count
 */
class CustomerMobility extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'date_transfer'];
    protected $appends = ['status_label'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function type()
    {
        return $this->belongsTo(MobilityType::class, 'mobility_type_id');
    }

    public function mouvements()
    {
        return $this->hasMany(CustomerMobilityMvm::class);
    }


    public function getStatus($format = '')
    {
        if ($format == 'text') {
            return match ($this->status) {
                "pending" => "En attente",
                "bank_start", "creditor_start" => "Demande en cours",
                "select_mvm_bank", "select_mvm_creditor" => "Selection des mouvements",
                "bank_end", "creditor_end" => "Selection transmise",
                "terminated" => "Terminer",
                "error" => "Erreur"
            };
        } elseif ($format == 'color') {
            return match ($this->status) {
                "pending", "creditor_end", "bank_end" => "warning",
                "bank_start", "creditor_start" => "info",
                "select_mvm_bank", "select_mvm_creditor" => "primary",
                "terminated" => "success",
                "error" => "danger"
            };
        } elseif($format == 'comment') {
            return match ($this->status) {
                "pending" => "Votre dossier est pris en compte",
                "bank_start" => "Demande envoyer à la banque distante",
                "select_mvm_bank", "select_mvm_creditor" => "Veuillez sélectionner les mouvements à transférer",
                "bank_end" => "Transfère bancaire terminer",
                "creditor_start" => "Demande envoyer au organisme créditeur",
                "creditor_end" => "Transfère des organismes terminer",
                "terminated" => "Transfère terminer",
                "error" => "Erreur lors du transfère des informations bancaire",
            };
        } else {
            return match ($this->status) {
                "pending" => "spinner fa-spin-pulse",
                "bank_start", "creditor_start", "bank_end", "creditor_end" => "arrow-right-arrow-left",
                "select_mvm_bank", "select_mvm_creditor" => "list-check",
                "terminated" => "circle-check",
                "error" => "triangle-exclamation"
            };
        }
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-{$this->getStatus('color')}' data-bs-toggle='tooltip' title='{$this->getStatus('comment')}'><i class='fa-solid fa-{$this->getStatus()} text-white me-2'></i> {$this->getStatus('text')}</span>";
    }

}

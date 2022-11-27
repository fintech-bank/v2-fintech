<?php

namespace App\Models\Customer;

use App\Helper\CustomerTransferHelper;
use App\Models\Core\Bank;
use App\Scope\BeneficiaireTrait;
use IbanGenerator\Generator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerBeneficiaire
 *
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property string|null $company
 * @property string|null $civility
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string $currency
 * @property string $bankname
 * @property string $iban
 * @property string|null $bic
 * @property int $titulaire
 * @property int $customer_id
 * @property int $bank_id
 * @property-read Bank $bank
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransfer[] $transfers
 * @property-read int|null $transfers_count
 * @method static \Database\Factories\Customer\CustomerBeneficiaireFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereBankname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereTitulaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerBeneficiaire
 * @property-read mixed $iban_format
 */
class CustomerBeneficiaire extends Model
{
    use HasFactory, BeneficiaireTrait;

    protected $guarded = [];
    protected $appends = ['iban_format', 'full_name', 'beneficiaire_select_format'];
    public $timestamps = false;

    public function getFullNameAttribute()
    {
        return CustomerTransferHelper::getNameBeneficiaire($this);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function transfers()
    {
        return $this->hasMany(CustomerTransfer::class);
    }

    public function getIbanFormatAttribute()
    {
        return \Str::replace("\r\n", " ", chunk_split($this->iban, 4));
    }

    public function getBeneficiaireSelectFormatAttribute()
    {
        ob_start();
        ?>
        <div class="d-flex flex-row">
            <div class="symbol symbol-50px me-3">
                <img src="<?= $this->bank->logo ?>" alt=""/>
            </div>
            <div class="d-flex flex-column">
                <div class="fw-bolder"><?= $this->full_name ?></div>
                <div class="text-muted">IBAN: <?= $this->iban_format; ?></div>
                <div class="text-muted">BIC: <?= $this->bic; ?></div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

}

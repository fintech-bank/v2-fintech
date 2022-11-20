<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerPretCaution
 *
 * @property int $id
 * @property string $type_caution
 * @property string $type
 * @property string $status
 * @property string|null $civility
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $company
 * @property int $ficap Organisme par default de cautionnement appartenant à FINTECH / Uniquement pour crédit personnel et à hauteur de 10 000 € maximum
 * @property string $address
 * @property string $postal
 * @property string $city
 * @property string $country En toute lettre
 * @property string $phone Portable ou fixe
 * @property string $email
 * @property string|null $password
 * @property string|null $num_cni
 * @property \Illuminate\Support\Carbon|null $date_naissance
 * @property string|null $country_naissance
 * @property string|null $dep_naissance
 * @property string|null $ville_naissance
 * @property string|null $persona_reference_id
 * @property int $identityVerify
 * @property int $addressVerify
 * @property string|null $type_structure SASU, SARL, ETc..
 * @property string|null $siret
 * @property int $companyVerify
 * @property int $sign_caution
 * @property \Illuminate\Support\Carbon|null $signed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_pret_id
 * @property-read \App\Models\Customer\CustomerPret $loan
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereAddressVerify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereCompanyVerify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereCountryNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereCustomerPretId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereDepNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereFicap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereIdentityVerify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereNumCni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution wherePersonaReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereSignCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereSiret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereTypeCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereTypeStructure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPretCaution whereVilleNaissance($value)
 * @mixin \Eloquent
 * @property-read mixed $status_label
 * @property-read mixed $type_caution_label
 * @property-read mixed $type_label
 */
class CustomerPretCaution extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'date_naissance', 'signed_at'];
    protected $appends = ['type_label', 'type_caution_label', 'status_label'];

    public function loan()
    {
        return $this->belongsTo(CustomerPret::class, 'customer_pret_id');
    }

    public static function getTypeCautionData()
    {
        return collect([
            [
                'id' => 'simple',
                'name' => "Caution simple"
            ],
            [
                'id' => 'solidaire',
                'name' => "Caution Solidaire"
            ],
        ])->toJson();
    }

    public static function getTypeData()
    {
        return collect([
            [
                'id' => 'physique',
                'name' => "Personne Physique"
            ],
            [
                'id' => 'moral',
                'name' => "Personne Moral"
            ],
        ])->toJson();
    }

    public static function getCivilityData()
    {
        return collect([
            ['id' => 'M', 'name' => "Monsieur"],
            ['id' => 'Mme', 'name' => "Madame"],
            ['id' => 'Mlle', 'name' => "Mademoiselle"],
        ])->toJson();
    }

    public static function getTypeEntrepriseData()
    {
        return collect([
            ['id' => 'EI', 'name' => "Entrepreneur individuel"],
            ['id' => 'EURL', 'name' => "Entreprise unipersonnelle à responsabilité limitée"],
            ['id' => 'SARL', 'name' => "Société à responsabilité limitée"],
            ['id' => 'SASU', 'name' => "Société par actions simplifiée unipersonnelle"],
            ['id' => 'SAS', 'name' => "Société par actions simplifiée"],
            ['id' => 'SA', 'name' => "Société anonyme"],
            ['id' => 'SNC', 'name' => "Société en nom collectif"],
            ['id' => 'SCS', 'name' => "Société en commandite simple"],
            ['id' => 'SCA', 'name' => "Société en commandite par actions"],
        ])->toJson();
    }

    public function getTypeCaution($format = '')
    {
        if($format == 'text') {
            return match($this->type_caution) {
                "simple" => "Caution Simple",
                "solidaire" => "Caution Solidaire"
            };
        } elseif ($format == 'color') {
            return match($this->type_caution) {
                "simple" => "primary",
                "solidaire" => "info"
            };
        } else {
            return match($this->type_caution) {
                "simple" => "fa-hand",
                "solidaire" => "fa-hands-praying"
            };
        }
    }

    public function getType($format = '')
    {
        if($format == 'text') {
            return match ($this->type) {
                "physique" => "Personne Physique",
                "moral" => "Personne Moral",
            };
        } else {
            return match ($this->type) {
                "physique" => "fa-user",
                "moral" => "fa-building",
            };
        }
    }

    public function getStatus($format = '')
    {
        if($format == 'text') {
            return match ($this->status) {
                "waiting_validation" => "En attente de validation",
                "waiting_sign" => "En attente de signature",
                "process" => "Caution en cours...",
                "retired" => "Caution retiré",
                "terminated" => "Cautionnement terminé",
            };
        } elseif ($format == 'color') {
            return match ($this->status) {
                "waiting_validation" => "primary",
                "waiting_sign" => "warning",
                "process", "terminated" => "success",
                "retired" => "danger",
            };
        } else {
            return match ($this->status) {
                "waiting_validation", "process" => "fa-spinner fa-spin-pulse",
                "waiting_sign" => "fa-sign",
                "retired" => "fa-xmark-circle",
                "terminated" => "fa-check-circle",
            };
        }
    }

    public function getTypeCautionLabelAttribute()
    {
        return "<span class='badge badge-{$this->getTypeCaution('color')}'><i class='fa-solid {$this->getTypeCaution()} text-white me-2'></i> {$this->getTypeCaution('text')}</span>";
    }

    public function getTypeLabelAttribute()
    {
        return "<span class='badge badge-secondary'><i class='fa-solid {$this->getType()} text-white me-2'></i> {$this->getType('text')}</span>";
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-{$this->getStatus('color')}'><i class='fa-solid {$this->getStatus()} text-white me-2'></i> {$this->getStatus('text')}</span>";
    }
}

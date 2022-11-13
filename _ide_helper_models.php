<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Business{
/**
 * App\Models\Business\BusinessParam
 *
 * @property int $id
 * @property string $name
 * @property string $forme
 * @property int $financement
 * @property float $ca
 * @property float $achat
 * @property float $frais
 * @property float $salaire
 * @property float $impot
 * @property float $other
 * @property int $customer_id
 * @property-read Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereAchat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereCa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereFinancement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereForme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereFrais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereImpot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereSalaire($value)
 * @mixin \Eloquent
 * @property float $apport_personnel
 * @property float $finance
 * @property float $other_product
 * @property float $other_charge
 * @property-read mixed $result_format
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereApportPersonnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereOtherCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereOtherProduct($value)
 * @property float $result
 * @property float $result_finance
 * @property int $indicator
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereIndicator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessParam whereResultFinance($value)
 * @property-read mixed $indicator_format
 * @property-read mixed $result_finance_format
 */
	class BusinessParam extends \Eloquent {}
}

namespace App\Models\Cms{
/**
 * App\Models\Cms\CmsCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cms\CmsSubCategory[] $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory whereSlug($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCmsCategory
 */
	class CmsCategory extends \Eloquent {}
}

namespace App\Models\Cms{
/**
 * App\Models\Cms\CmsPage
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property mixed|null $content
 * @property int $publish
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $subcategory_id
 * @property-read \App\Models\Cms\CmsSubCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage wherePublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCmsPage
 */
	class CmsPage extends \Eloquent {}
}

namespace App\Models\Cms{
/**
 * App\Models\Cms\CmsSubCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property CmsSubCategory|null $parent
 * @property int|null $parent_id
 * @property int $cms_category_id
 * @property-read \App\Models\Cms\CmsCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|CmsSubCategory[] $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereCmsCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereSlug($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCmsSubCategory
 */
	class CmsSubCategory extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Agency
 *
 * @property int $id
 * @property string $name
 * @property string $bic
 * @property string $code_banque
 * @property string $code_agence
 * @property string $address
 * @property string $postal
 * @property string $city
 * @property string $country
 * @property string $phone
 * @property int $online
 * @property-read \Illuminate\Database\Eloquent\Collection|DocumentTransmiss[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCodeAgence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCodeBanque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency wherePostal($value)
 * @mixin \Eloquent
 * @mixin IdeHelperAgency
 * @property-read mixed $online_label
 */
	class Agency extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Bank
 *
 * @property int $id
 * @property int|null $bridge_id
 * @property string $name
 * @property string $logo
 * @property string $primary_color
 * @property string $country
 * @property string $bic
 * @property string $process_time
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerBeneficiaire[] $beneficiaires
 * @property-read int|null $beneficiaires_count
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereBridgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank wherePrimaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereProcessTime($value)
 * @mixin \Eloquent
 * @mixin IdeHelperBank
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerMobility[] $mobility
 * @property-read int|null $mobility_count
 * @property-read mixed $bank_symbol
 */
	class Bank extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\CreditCardInsurance
 *
 * @property int $id
 * @property int $insurance_sante
 * @property int $insurance_accident_travel
 * @property int $trip_cancellation
 * @property int $civil_liability_abroad
 * @property int $cash_breakdown_abroad
 * @property int $guarantee_snow
 * @property int $guarantee_loan
 * @property int $guarantee_purchase
 * @property int $advantage
 * @property int $business_travel
 * @property int $credit_card_support_id
 * @property-read \App\Models\Core\CreditCardSupport $support
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance query()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereAdvantage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereBusinessTravel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereCashBreakdownAbroad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereCivilLiabilityAbroad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereCreditCardSupportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereGuaranteeLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereGuaranteePurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereGuaranteeSnow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereInsuranceAccidentTravel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereInsuranceSante($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardInsurance whereTripCancellation($value)
 * @mixin \Eloquent
 */
	class CreditCardInsurance extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\CreditCardSupport
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $type_customer
 * @property int $payment_internet
 * @property int $payment_abroad
 * @property int $payment_contact
 * @property float $limit_retrait
 * @property float $limit_payment
 * @property int $visa_spec
 * @property int $choice_code
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerCreditCard[] $creditcards
 * @property-read int|null $creditcards_count
 * @property-read \App\Models\Core\CreditCardInsurance|null $insurance
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport query()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereChoiceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereLimitPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereLimitRetrait($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport wherePaymentAbroad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport wherePaymentContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport wherePaymentInternet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereTypeCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardSupport whereVisaSpec($value)
 * @mixin \Eloquent
 */
	class CreditCardSupport extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\DocumentCategory
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerDocument[] $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory whereName($value)
 * @mixin \Eloquent
 * @mixin IdeHelperDocumentCategory
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory whereSlug($value)
 */
	class DocumentCategory extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\EpargnePlan
 *
 * @property int $id
 * @property string $name
 * @property float $profit_percent
 * @property int $lock_days
 * @property int $profit_days
 * @property float $init
 * @property float $limit
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerEpargne[] $epargnes
 * @property-read int|null $epargnes_count
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereLockDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereProfitDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereProfitPercent($value)
 * @mixin \Eloquent
 * @mixin IdeHelperEpargnePlan
 */
	class EpargnePlan extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Event
 *
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property string|null $lieu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLieu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUserId($value)
 * @property int $allDay
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAllDay($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\EventAttendee[] $attendees
 * @property-read int|null $attendees_count
 * @property-read mixed $type_cl
 * @property-read mixed $type_color
 */
	class Event extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\EventAttendee
 *
 * @property-read \App\Models\Core\Event|null $event
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $event_id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereUserId($value)
 */
	class EventAttendee extends \Eloquent {}
}

namespace App\Models\Core{
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
	class Invoice extends \Eloquent {}
}

namespace App\Models\Core{
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
	class InvoicePayment extends \Eloquent {}
}

namespace App\Models\Core{
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
	class InvoiceProduct extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\LoanPlan
 *
 * @property int $id
 * @property string $name
 * @property float $minimum
 * @property float $maximum
 * @property int $duration En Mois
 * @property string|null $instruction
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\LoanPlanInterest[] $interests
 * @property-read int|null $interests_count
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereInstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereMaximum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereMinimum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereName($value)
 * @mixin \Eloquent
 * @mixin IdeHelperLoanPlan
 * @property mixed|null $avantage
 * @property mixed|null $condition
 * @property mixed|null $tarif
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereAvantage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereTarif($value)
 * @property string $type_pret
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereTypePret($value)
 */
	class LoanPlan extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\LoanPlanInterest
 *
 * @property int $id
 * @property float $interest
 * @property int $duration En Mois
 * @property int $loan_plan_id
 * @property-read \App\Models\Core\LoanPlan $plan
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereLoanPlanId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperLoanPlanInterest
 */
	class LoanPlanInterest extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\LogBanque
 *
 * @property int $id
 * @property string $type
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read mixed $type_label
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereUserId($value)
 * @mixin \Eloquent
 */
	class LogBanque extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Mailbox
 *
 * @property int $id
 * @property string $subject
 * @property string|null $body
 * @property int $sender_id
 * @property string $time_sent
 * @property int $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\MailboxAttachment[] $attachments
 * @property-read int|null $attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\MailboxFlags[] $flags
 * @property-read int|null $flags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\MailboxReceiver[] $receivers
 * @property-read int|null $receivers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Mailbox[] $replies
 * @property-read int|null $replies_count
 * @property-read User $sender
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\MailboxTmpReceiver[] $tmpReceivers
 * @property-read int|null $tmp_receivers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\MailboxUserFolder[] $userFolders
 * @property-read int|null $user_folders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereTimeSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Mailbox extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\MailboxAttachment
 *
 * @property int $id
 * @property int $mailbox_id
 * @property string $attachment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class MailboxAttachment extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\MailboxFlags
 *
 * @property int $id
 * @property int $is_unread
 * @property int $is_important
 * @property int $mailbox_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereIsImportant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereIsUnread($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereUserId($value)
 * @mixin \Eloquent
 */
	class MailboxFlags extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\MailboxFolder
 *
 * @property int $id
 * @property string $title
 * @property string $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class MailboxFolder extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\MailboxReceiver
 *
 * @property int $id
 * @property int $mailbox_id
 * @property int $receiver_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Core\Mailbox $mailbox
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class MailboxReceiver extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\MailboxTmpReceiver
 *
 * @property int $id
 * @property int $mailbox_id
 * @property int $receiver_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Core\Mailbox $mailbox
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class MailboxTmpReceiver extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\MailboxUserFolder
 *
 * @property int $id
 * @property int $user_id
 * @property int $mailbox_id
 * @property int $folder_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Core\MailboxFolder $folder
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereUserId($value)
 * @mixin \Eloquent
 */
	class MailboxUserFolder extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\NotificationType
 *
 * @property int $id
 * @property string $type
 * @property string $channel
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereType($value)
 * @mixin \Eloquent
 */
	class NotificationType extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\NotificationUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $notification_type_id
 * @property-read \App\Models\Core\NotificationType|null $type
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereNotificationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereUserId($value)
 * @mixin \Eloquent
 */
	class NotificationUser extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Package
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $type_prlv
 * @property int $visa_classic
 * @property int $check_deposit
 * @property int $payment_withdraw
 * @property int $overdraft
 * @property int $cash_deposit
 * @property int $withdraw_international
 * @property int $payment_international
 * @property int $payment_insurance
 * @property int $check
 * @property int $nb_carte_physique
 * @property int $nb_carte_virtuel
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCashDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCheckDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNbCartePhysique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNbCarteVirtuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereOverdraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentInternational($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTypePrlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereVisaClassic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereWithdrawInternational($value)
 * @mixin \Eloquent
 * @mixin IdeHelperPackage
 * @property string $type_cpt
 * @property int $subaccount
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereSubaccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTypeCpt($value)
 * @property-read mixed $price_format
 * @property-read mixed $type_cpt_label
 * @property-read mixed $type_cpt_text
 * @property-read mixed $type_prlv_text
 */
	class Package extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Service
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $type_prlv
 * @property int|null $package_id
 * @property-read \App\Models\Core\Package|null $package
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereTypePrlv($value)
 * @mixin \Eloquent
 * @mixin IdeHelperService
 * @property-read mixed $price_format
 * @property-read mixed $type_prlv_text
 */
	class Service extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Shipping
 *
 * @property int $id
 * @property string $number_ship
 * @property string $product
 * @property \Illuminate\Support\Carbon $date_delivery_estimated
 * @property \Illuminate\Support\Carbon $date_delivered
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Reseller[] $resellers
 * @property-read int|null $resellers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\ShippingTrack[] $tracks
 * @property-read int|null $tracks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereDateDelivered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereDateDeliveryEstimated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereNumberShip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Shipping extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\ShippingTrack
 *
 * @property int $id
 * @property string $state
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $shipping_id
 * @property-read mixed $state_color
 * @property-read mixed $state_label
 * @property-read mixed $state_text
 * @property-read \App\Models\Core\Shipping $shipping
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereShippingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingTrack whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ShippingTrack extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Ticket
 *
 * @property int $id
 * @property string $subject
 * @property string $status
 * @property string $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperTicket
 */
	class Ticket extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\TicketCategory
 *
 * @mixin IdeHelperTicketCategory
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory whereUpdatedAt($value)
 */
	class TicketCategory extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\TicketConversation
 *
 * @property int $id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $agent_id
 * @property int $customer_id
 * @property int $ticket_id
 * @property-read User $agent
 * @property-read User $customer
 * @property-read \App\Models\Core\Ticket $ticket
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperTicketConversation
 */
	class TicketConversation extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\TicketSubCategory
 *
 * @mixin IdeHelperTicketSubCategory
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory whereUpdatedAt($value)
 */
	class TicketSubCategory extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\TypeVersion
 *
 * @property int $id
 * @property string $name
 * @property string $color Html Code color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\Version[] $versions
 * @property-read int|null $versions_count
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion whereName($value)
 * @mixin \Eloquent
 */
	class TypeVersion extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Version
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $publish
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\TypeVersion[] $types
 * @property-read int|null $types_count
 * @method static \Illuminate\Database\Eloquent\Builder|Version newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Version newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Version query()
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version wherePublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Version extends \Eloquent {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\VersionType
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $type_version_id
 * @property int $version_id
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType whereTypeVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType whereVersionId($value)
 * @mixin \Eloquent
 */
	class VersionType extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\Customer
 *
 * @property int $id
 * @property string $status_open_account
 * @property int $cotation Cotation bancaire du client
 * @property string $auth_code
 * @property int $ficp
 * @property int $fcc
 * @property int|null $agent_id
 * @property int $user_id
 * @property int $package_id
 * @property int $agency_id
 * @property-read Agency|null $agency
 * @property-read User|null $agent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerBeneficiaire[] $beneficiaires
 * @property-read int|null $beneficiaires_count
 * @property-read \App\Models\Customer\CustomerSituationCharge|null $charge
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerDocument[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerEpargne[] $epargnes
 * @property-read int|null $epargnes_count
 * @property-read \App\Models\Customer\CustomerSituationIncome|null $income
 * @property-read \App\Models\Customer\CustomerInfo|null $info
 * @property-read Package $package
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerPret[] $prets
 * @property-read int|null $prets_count
 * @property-read \App\Models\Customer\CustomerSetting|null $setting
 * @property-read \App\Models\Customer\CustomerSituation|null $situation
 * @property-read \Illuminate\Database\Eloquent\Collection|DocumentTransmiss[] $transmisses
 * @property-read int|null $transmisses_count
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerWallet[] $wallets
 * @property-read int|null $wallets_count
 * @method static \Database\Factories\Customer\CustomerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFcc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFicp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStatusOpenAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobility[] $mobilities
 * @property-read int|null $mobilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read mixed $status_color
 * @property-read mixed $status_label
 * @property-read mixed $status_text
 * @property-read mixed $sum_account
 * @property-read mixed $sum_epargne
 * @property-read \App\Models\Customer\CustomerInfoInsurance|null $info_insurance
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerInsurance[] $insurances
 * @property-read int|null $insurances_count
 * @property string|null $persona_reference_id
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePersonaReferenceId($value)
 * @property-read mixed $next_debit_package
 * @property-read BusinessParam|null $business
 */
	class Customer extends \Eloquent {}
}

namespace App\Models\Customer{
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
	class CustomerBeneficiaire extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerCheck
 *
 * @property int $id
 * @property string $reference
 * @property int $tranche_start
 * @property int $tranche_end
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerCheckFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereTrancheEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereTrancheStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerCheck
 */
	class CustomerCheck extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerCheckDeposit
 *
 * @property int $id
 * @property string $state
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property-read string|null $status_label
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheckDepositList[] $lists
 * @property-read int|null $lists_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $reference
 * @property-read \App\Models\Customer\CustomerTransaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereReference($value)
 * @property int|null $customer_transaction_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereCustomerTransactionId($value)
 */
	class CustomerCheckDeposit extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerCheckDepositList
 *
 * @property int $id
 * @property string $number
 * @property float $amount
 * @property string $name_deposit
 * @property string $bank_deposit
 * @property \Illuminate\Support\Carbon $date_deposit
 * @property int $customer_check_deposit_id
 * @property-read \App\Models\Customer\CustomerCheckDeposit $deposit
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereBankDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereCustomerCheckDepositId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereDateDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereNameDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereNumber($value)
 * @mixin \Eloquent
 * @property int $verified
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereVerified($value)
 * @property-read mixed $date_deposit_format
 * @property-read mixed $is_verified_label
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList isUnverified()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList isVerified()
 */
	class CustomerCheckDepositList extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerCreditCard
 *
 * @property int $id
 * @property string $currency
 * @property string $exp_month
 * @property string $exp_year
 * @property string $number
 * @property string $status
 * @property string $type
 * @property string $support
 * @property string $debit
 * @property string $cvc
 * @property int $payment_internet
 * @property int $payment_abroad
 * @property int $payment_contact
 * @property string $code
 * @property float $limit_retrait
 * @property float $limit_payment
 * @property float $differed_limit
 * @property int $facelia
 * @property int $visa_spec
 * @property int $warranty
 * @property int $customer_wallet_id
 * @property int|null $customer_pret_id
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelias
 * @property-read \App\Models\Customer\CustomerPret|null $pret
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerCreditCardFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCustomerPretId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCvc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereDifferedLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereExpMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereExpYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereFacelia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereLimitPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereLimitRetrait($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentAbroad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentInternet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereSupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereVisaSpec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereWarranty($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerCreditCard
 * @property-read bool $access_withdraw
 * @property-read mixed $actual_limit_withdraw
 * @property-read mixed $limit_withdraw
 * @property int $credit_card_support_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCreditCardSupportId($value)
 * @property string $facelia_vitesse
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereFaceliaVitesse($value)
 * @property-read mixed $number_card_oscure
 * @property-read mixed $number_format
 * @property-read mixed $debit_format
 * @property-read mixed $expiration
 */
	class CustomerCreditCard extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerCreditor
 *
 * @property int $id
 * @property string $name
 * @property int $opposit
 * @property int $customer_wallet_id
 * @property int $customer_sepa_id
 * @property-read \App\Models\Customer\CustomerSepa $sepa
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerCreditorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereCustomerSepaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereOpposit($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerCreditor
 */
	class CustomerCreditor extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerDocument
 *
 * @property int $id
 * @property string $name
 * @property string $reference
 * @property int $signable Le document est-il signable ?
 * @property int $signed_by_client Le document est signé par le client
 * @property int $signed_by_bank Le document est signé par la bank
 * @property string|null $code_sign
 * @property \Illuminate\Support\Carbon|null $signed_at Date de signature du document
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property int $document_category_id
 * @property-read DocumentCategory $category
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereCodeSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereDocumentCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignedByBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignedByClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerDocument
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument signedByClient()
 * @property-read mixed $signed_by_client_label
 * @property-read mixed $url_folder
 * @property-read mixed $url_bread
 * @property-read mixed $size_file
 */
	class CustomerDocument extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerEpargne
 *
 * @property int $id
 * @property string $uuid
 * @property string $reference
 * @property float $initial_payment
 * @property float $monthly_payment
 * @property int $monthly_days
 * @property int $wallet_id
 * @property int $wallet_payment_id
 * @property int $epargne_plan_id
 * @property-read \App\Models\Customer\CustomerWallet $payment
 * @property-read EpargnePlan $plan
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerEpargneFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereEpargnePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereInitialPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereMonthlyDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereMonthlyPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereWalletPaymentId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerEpargne
 */
	class CustomerEpargne extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerFacelia
 *
 * @property int $id
 * @property string $reference
 * @property float $amount_available
 * @property float $amount_interest
 * @property float $amount_du
 * @property float $mensuality
 * @property \Illuminate\Support\Carbon|null $next_expiration
 * @property int $wallet_payment_id
 * @property int $customer_pret_id
 * @property int|null $customer_credit_card_id
 * @property int $customer_wallet_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\CustomerWallet $payment
 * @property-read \App\Models\Customer\CustomerPret $pret
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerFaceliaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereAmountAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereAmountDu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereAmountInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereCustomerCreditCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereCustomerPretId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereMensuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereNextExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereWalletPaymentId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerFacelia
 */
	class CustomerFacelia extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerInfo
 *
 * @property int $id
 * @property string $type
 * @property string|null $civility
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 * @property \Illuminate\Support\Carbon|null $datebirth
 * @property string|null $citybirth
 * @property string|null $countrybirth
 * @property string|null $company
 * @property string|null $siret
 * @property string $address
 * @property string|null $addressbis
 * @property string $postal
 * @property string $city
 * @property string $country
 * @property string|null $phone
 * @property string $mobile
 * @property string|null $country_code
 * @property string|null $authy_id
 * @property int $isVerified
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\Customer\CustomerInfoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAddressbis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAuthyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCitybirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountrybirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereDatebirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereSiret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereType($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerInfo
 * @property-read int|null $push_subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo verified()
 * @property-read mixed $account_verified
 * @property-read mixed $mobile_verified
 * @property-read mixed $phone_verified
 * @property-read mixed $type_color
 * @property-read mixed $type_label
 * @property-read mixed $type_text
 * @property-read string|null $full_name
 * @property int $addressVerified
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAddressVerified($value)
 * @property string $email
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereEmail($value)
 * @property int $phoneVerified
 * @property int $mobileVerified
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereMobileVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo wherePhoneVerified($value)
 * @property-read mixed $mobile_verify
 * @property-read mixed $phone_verify
 */
	class CustomerInfo extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerInfoInsurance
 *
 * @property int $id
 * @property string|null $secu_number
 * @property int $fume Suis-je Fumeur ?
 * @property int $sport_risk Pratique t'il un sport à risque ?
 * @property int $politique Est-il exposer publiquement ?
 * @property int $politique_proche A t'il une proche personne exposer publiquement ?
 * @property int $manual_travaux Travaux Manuel
 * @property string $dep_pro Déplacement Pro (low: moins de 20 000/km/an)
 * @property string $port_charge Port de charge (0/3/15kg)
 * @property string $work_height Port de charge (0/3-15/15)
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereDepPro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereFume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereManualTravaux($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance wherePolitique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance wherePolitiqueProche($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance wherePortCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereSecuNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereSportRisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfoInsurance whereWorkHeight($value)
 * @mixin \Eloquent
 */
	class CustomerInfoInsurance extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerInsurance
 *
 * @property int $id
 * @property string $status
 * @property string $reference
 * @property \Illuminate\Support\Carbon $date_member
 * @property \Illuminate\Support\Carbon $effect_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property float $mensuality
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property int $insurance_package_id
 * @property int $insurance_package_form_id
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read InsurancePackageForm $form
 * @property-read InsurancePackage $package
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereDateMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereEffectDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereInsurancePackageFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereInsurancePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereMensuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $type_prlv
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInsurance whereTypePrlv($value)
 * @property-read mixed $status_color
 * @property-read mixed $status_label
 * @property-read mixed $status_text
 * @property-read mixed $mensuality_format
 * @property-read mixed $type_prlv_text
 */
	class CustomerInsurance extends \Eloquent {}
}

namespace App\Models\Customer{
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
 */
	class CustomerMobility extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerMobilityCheque
 *
 * @mixin IdeHelperCustomerMobilityCheque
 * @property int $id
 * @property string $number
 * @property float $amount
 * @property \Illuminate\Support\Carbon $date_enc
 * @property string $creditor
 * @property string $file_url
 * @property int $valid
 * @property int $customer_mobility_id
 * @property-read \App\Models\Customer\CustomerMobility|null $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereCreditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereCustomerMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereDateEnc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereValid($value)
 */
	class CustomerMobilityCheque extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerMobilityPrlv
 *
 * @mixin IdeHelperCustomerMobilityPrlv
 * @property int $id
 * @property string $uuid
 * @property string $creditor
 * @property string $number_mandate
 * @property float $amount
 * @property int $valid
 * @property int $customer_mobility_id
 * @property-read \App\Models\Customer\CustomerMobility $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereCreditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereCustomerMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereNumberMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereValid($value)
 */
	class CustomerMobilityPrlv extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerMobilityVirIncoming
 *
 * @mixin IdeHelperCustomerMobilityVirIncoming
 * @property int $id
 * @property string $uuid
 * @property float $amount
 * @property string $reference
 * @property string $reason
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $transfer_date
 * @property \Illuminate\Support\Carbon|null $recurring_start
 * @property \Illuminate\Support\Carbon|null $recurring_end
 * @property int $valid
 * @property int $customer_mobility_id
 * @property-read \App\Models\Customer\CustomerMobility $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereCustomerMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereRecurringEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereRecurringStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereTransferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereValid($value)
 */
	class CustomerMobilityVirIncoming extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerMobilityVirOutgoing
 *
 * @mixin IdeHelperCustomerMobilityVirOutgoing
 * @property int $id
 * @property string $uuid
 * @property float $amount
 * @property string $reference
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $transfer_date
 * @property int $valid
 * @property int $customer_mobility_id
 * @property-read \App\Models\Customer\CustomerMobility $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereCustomerMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereTransferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereValid($value)
 */
	class CustomerMobilityVirOutgoing extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerMoneyDeposit
 *
 * @property int $id
 * @property string $reference
 * @property float $amount
 * @property string $status
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property int|null $customer_transaction_id
 * @property int $customer_withdraw_dab_id
 * @property-read \App\Models\Customer\CustomerWithdrawDab $dab
 * @property-read mixed $amount_format
 * @property-read mixed $customer_name
 * @property-read mixed $decoded_code
 * @property-read mixed $labeled_status
 * @property-read \App\Models\Customer\CustomerTransaction|null $transaction
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereCustomerTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereCustomerWithdrawDabId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMoneyDeposit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class CustomerMoneyDeposit extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerPaymentOpposit
 *
 * @property int $id
 * @property string $status
 * @property string $raison_opposit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_transaction_id
 * @property-read \App\Models\Customer\CustomerTransaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereCustomerTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereRaisonOpposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPaymentOpposit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class CustomerPaymentOpposit extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerPret
 *
 * @property int $id
 * @property string $uuid
 * @property string $reference
 * @property float $amount_loan Montant du crédit demander
 * @property float $amount_interest Montant des interet du par le client
 * @property float $amount_du Total des sommes du par le client (Credit + Interet - mensualités payé)
 * @property float $mensuality Mensualité du par le client par mois
 * @property int $prlv_day Jours du prélèvement de la mensualité
 * @property int $duration Durée total du contrat en année
 * @property string $status
 * @property int $signed_customer
 * @property int $signed_bank
 * @property int $alert
 * @property string $assurance_type
 * @property int $customer_wallet_id
 * @property int $wallet_payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $first_payment_at
 * @property int $loan_plan_id
 * @property int $customer_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelia
 * @property-read \App\Models\Customer\CustomerWallet $payment
 * @property-read LoanPlan $plan
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerPretFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountDu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAssuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereFirstPaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereLoanPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereMensuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret wherePrlvDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereSignedBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereSignedCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereWalletPaymentId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerPret
 * @property-read mixed $status_explanation
 * @property-read mixed $status_label
 */
	class CustomerPret extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerRefundAccount
 *
 * @property int $id
 * @property string $stripe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerRefundAccount
 */
	class CustomerRefundAccount extends \Eloquent {}
}

namespace App\Models\Customer{
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
 */
	class CustomerSepa extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerSetting
 *
 * @property int $id
 * @property int $notif_sms
 * @property int $notif_app
 * @property int $notif_mail
 * @property int $nb_physical_card
 * @property int $nb_virtual_card
 * @property int $check
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSettingFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNbPhysicalCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNbVirtualCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifApp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifSms($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerSetting
 * @property int $alerta
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereAlerta($value)
 * @property int $card_code
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCardCode($value)
 */
	class CustomerSetting extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerSituation
 *
 * @property int $id
 * @property string|null $legal_capacity
 * @property string|null $family_situation
 * @property string|null $logement
 * @property \Illuminate\Support\Carbon $logement_at
 * @property int $child
 * @property int $person_charged
 * @property string|null $pro_category
 * @property string|null $pro_category_detail
 * @property string|null $pro_profession
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSituationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereChild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereFamilySituation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereLegalCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereLogement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereLogementAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation wherePersonCharged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereProCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereProCategoryDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereProProfession($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerSituation
 */
	class CustomerSituation extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerSituationCharge
 *
 * @property int $id
 * @property float $rent Loyer, Pret Immobilier, etc...
 * @property int $nb_credit Nombre de crédit actuel
 * @property float $credit Valeur total des mensualité de crédit
 * @property float $divers Autres charges (pension, etc...)
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSituationChargeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereDivers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereNbCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereRent($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerSituationCharge
 */
	class CustomerSituationCharge extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerSituationIncome
 *
 * @property int $id
 * @property float $pro_incoming Revenue Salarial, Aide état RSA, etc...
 * @property float $patrimoine Revenue Mensuel du patrimoine
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSituationIncomeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome wherePatrimoine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome whereProIncoming($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerSituationIncome
 */
	class CustomerSituationIncome extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerTransaction
 *
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property string $designation
 * @property string|null $description
 * @property float $amount
 * @property int $confirmed
 * @property int $differed
 * @property \Illuminate\Support\Carbon|null $confirmed_at
 * @property \Illuminate\Support\Carbon|null $differed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property int|null $customer_credit_card_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerTransactionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCustomerCreditCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDiffered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDifferedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerTransaction
 * @property-read \App\Models\Customer\CustomerWithdraw|null $withdraw
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheckDeposit[] $check_deposit
 * @property-read int|null $check_deposit_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMoneyDeposit[] $money_deposits
 * @property-read int|null $money_deposits_count
 * @property-read InvoicePayment|null $invoice_payment
 * @property-read mixed $type_icon
 * @property-read mixed $type_symbol
 * @property-read mixed $type_text
 * @property-read mixed $amount_format
 * @property-read \App\Models\Customer\CustomerPaymentOpposit|null $opposit
 * @property-read mixed $is_opposit
 */
	class CustomerTransaction extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerTransfer
 *
 * @property int $id
 * @property string $uuid
 * @property float $amount
 * @property string $reference
 * @property string $reason
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $transfer_date
 * @property \Illuminate\Support\Carbon|null $recurring_start
 * @property \Illuminate\Support\Carbon|null $recurring_end
 * @property string $status
 * @property int|null $transaction_id
 * @property int $customer_wallet_id
 * @property int $customer_beneficiaire_id
 * @property-read \App\Models\Customer\CustomerBeneficiaire $beneficiaire
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerTransferFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereCustomerBeneficiaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereRecurringEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereRecurringStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereTransferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerTransfer
 * @property-read mixed $amount_format
 * @property string $access
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereAccess($value)
 * @property-read mixed $status_label
 * @property-read mixed $status_bullet
 * @property-read mixed $date_format
 * @property-read mixed $type_text
 */
	class CustomerTransfer extends \Eloquent {}
}

namespace App\Models\Customer{
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
 */
	class CustomerWallet extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerWithdraw
 *
 * @property-read \App\Models\Customer\CustomerWithdrawDab|null $dab
 * @property-read \App\Models\Customer\CustomerTransaction|null $transaction
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerWithdrawFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $reference
 * @property float $amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property int|null $customer_transaction_id
 * @property int $customer_withdraw_dab_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCustomerTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCustomerWithdrawDabId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereUpdatedAt($value)
 * @property string $code
 * @property-read mixed $amount_format
 * @property-read mixed $customer_name
 * @property-read string|bool $decoded_code
 * @property-read mixed $labeled_status
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCode($value)
 * @property-read mixed $status_text
 */
	class CustomerWithdraw extends \Eloquent {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerWithdrawDab
 *
 * @property-read \App\Models\Customer\CustomerWithdraw|null $withdraw
 * @method static \Database\Factories\Customer\CustomerWithdrawDabFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string|null $address
 * @property string|null $postal
 * @property string|null $city
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $img
 * @property int $open
 * @property string|null $place_id
 * @property-read Reseller|null $reseller
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereType($value)
 * @property-read mixed $address_format
 * @property-read mixed $status_format
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerWithdraw[] $withdraws
 * @property-read int|null $withdraws_count
 * @property string|null $phone
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab wherePhone($value)
 * @property-read mixed $type_string
 * @property-read mixed $open_text
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMoneyDeposit[] $moneys
 * @property-read int|null $moneys_count
 */
	class CustomerWithdrawDab extends \Eloquent {}
}

namespace App\Models\Document{
/**
 * App\Models\Document\DocumentTransmiss
 *
 * @property int $id
 * @property string $type_document
 * @property string|null $commentaire
 * @property int $file_transfered
 * @property \Illuminate\Support\Carbon|null $date_transmiss
 * @property string|null $file_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $agency_id
 * @property int $customer_id
 * @property-read Agency $agency
 * @property-read Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereDateTransmiss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereFileTransfered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereTypeDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperDocumentTransmiss
 */
	class DocumentTransmiss extends \Eloquent {}
}

namespace App\Models\Insurance{
/**
 * App\Models\Insurance\InsurancePackage
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $synopsis
 * @property string|null $description
 * @property int $insurance_type_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Insurance\InsurancePackageForm[] $forms
 * @property-read int|null $forms_count
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerInsurance[] $insurances
 * @property-read int|null $insurances_count
 * @property-read \App\Models\Insurance\InsuranceType $type
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereInsuranceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackage whereSynopsis($value)
 * @mixin \Eloquent
 */
	class InsurancePackage extends \Eloquent {}
}

namespace App\Models\Insurance{
/**
 * App\Models\Insurance\InsurancePackageForm
 *
 * @property int $id
 * @property string $name
 * @property string|null $synopsis
 * @property float $typed_price
 * @property int $insurance_package_id
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerInsurance[] $insurannces
 * @property-read int|null $insurannces_count
 * @property-read \App\Models\Insurance\InsurancePackage $package
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Insurance\InsurancePackageWarranty[] $warranties
 * @property-read int|null $warranties_count
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm whereInsurancePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm whereSynopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm whereTypedPrice($value)
 * @mixin \Eloquent
 * @property float|null $percent
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageForm wherePercent($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerInsurance[] $insurances
 * @property-read int|null $insurances_count
 * @property-read mixed $typed_price_format
 */
	class InsurancePackageForm extends \Eloquent {}
}

namespace App\Models\Insurance{
/**
 * App\Models\Insurance\InsurancePackageWarranty
 *
 * @property int $id
 * @property string $designation
 * @property int $check
 * @property float $price
 * @property int $insurance_package_form_id
 * @property-read \App\Models\Insurance\InsurancePackageForm $form
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereInsurancePackageFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty wherePrice($value)
 * @mixin \Eloquent
 * @property string|null $condition
 * @property int|null $count
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePackageWarranty whereCount($value)
 */
	class InsurancePackageWarranty extends \Eloquent {}
}

namespace App\Models\Insurance{
/**
 * App\Models\Insurance\InsuranceType
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Insurance\InsurancePackage[] $package
 * @property-read int|null $package_count
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceType whereName($value)
 * @mixin \Eloquent
 */
	class InsuranceType extends \Eloquent {}
}

namespace App\Models\Reseller{
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
	class Reseller extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $admin
 * @property int $agent
 * @property int $customer
 * @property string|null $identifiant
 * @property string|null $last_seen
 * @property int|null $agency_id
 * @property-read Agency|null $agency
 * @property-read Customer|null $customers
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Package|null $package
 * @property-read \Illuminate\Database\Eloquent\Collection|\NotificationChannels\WebPush\PushSubscription[] $pushSubscriptions
 * @property-read int|null $push_subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TicketConversation[] $ticket
 * @property-read int|null $ticket_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdentifiant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperUser
 * @property-read Reseller|null $reseller
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read Reseller|null $revendeur
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReseller($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @property string|null $pushbullet_device_id
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePushbulletDeviceId($value)
 * @property string|null $avatar
 * @method static Builder|User whereAvatar($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|LogBanque[] $log
 * @property-read int|null $log_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UserFile[] $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UserFolder[] $folder
 * @property-read int|null $folder_count
 * @property-read mixed $avatar_symbol
 * @property-read mixed $email_verified
 * @property-read \Illuminate\Database\Eloquent\Collection|EventAttendee[] $attendees
 * @property-read int|null $attendees_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Event[] $events
 * @property-read int|null $events_count
 * @property-read mixed $user_group_color
 * @property-read mixed $user_group_label
 * @property-read mixed $user_group_text
 * @property-read \Illuminate\Database\Eloquent\Collection|UserNotificationSetting[] $settingnotification
 * @property-read int|null $settingnotification_count
 * @property string|null $authy_id
 * @property string|null $authy_status
 * @property string|null $authy_one_touch_uuid
 * @method static Builder|User whereAuthyId($value)
 * @method static Builder|User whereAuthyOneTouchUuid($value)
 * @method static Builder|User whereAuthyStatus($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|UserSubscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read mixed $next_debit_package
 */
	class User extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\UserFile
 *
 * @property int $id
 * @property string $name
 * @property string $size
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_folder_id
 * @property int $user_id
 * @property-read \App\Models\User\UserFolder $folder
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereUserFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereUserId($value)
 * @mixin \Eloquent
 */
	class UserFile extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\UserFolder
 *
 * @property int $id
 * @property string $name
 * @property int $parent
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\UserFile[] $files
 * @property-read int|null $files_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereUserId($value)
 * @mixin \Eloquent
 */
	class UserFolder extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\UserNotificationSetting
 *
 * @property int $id
 * @property int $mail
 * @property int $app
 * @property int $site
 * @property int $sms
 * @property int $user_id
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereApp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereSms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereUserId($value)
 * @mixin \Eloquent
 */
	class UserNotificationSetting extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\UserSubscription
 *
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $subscribe_type
 * @property int $subscribe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read mixed $sub
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereSubscribeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereSubscribeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereUserId($value)
 */
	class UserSubscription extends \Eloquent {}
}


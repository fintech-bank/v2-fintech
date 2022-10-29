<?php

namespace App\Helper;

use App\Models\Core\CreditCardSupport;
use App\Models\Core\DocumentCategory;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
use App\Notifications\Customer\NewContractInsurance;
use App\Notifications\Customer\SendPasswordNotification;
use App\Notifications\Customer\WelcomeNotification;
use App\Notifications\Testing\Customer\SendCreditCardCodeNotification;
use App\Services\BankFintech;
use App\Services\PushbulletApi;
use App\Services\Twilio\Messaging\Whatsapp;
use App\Services\Twilio\Verify;
use IbanGenerator\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CustomerHelper
{
    public static function getTypeCustomerArray()
    {
        return json_encode([
            [
                'name' => 'part',
            ],
            [
                'name' => 'pro',
            ],
        ]);
    }

    public static function getTypeCustomer($type, $labeled = false)
    {
        if ($labeled == false) {
            switch ($type) {
                case 'part':
                    return 'Particulier';
                default:
                    return 'Professionnel';
            }
        } else {
            switch ($type) {
                case 'part':
                    return '<span class="badge badge-primary">Particulier</span>';
                default:
                    return '<span class="badge badge-danger">Professionnel</span>';
            }
        }
    }

    public static function getVerified($verified)
    {
        if ($verified == 1) {
            return '<i class="fa fa-check-circle fa-lg text-success"></i>';
        } else {
            return '<i class="fa fa-times-circle fa-lg text-danger"></i>';
        }
    }

    public static function getStatusOpenAccount($status, $labeled = false)
    {
        if ($labeled == false) {
            switch ($status) {
                case 'open':
                    return 'Ouverture en cours';
                    break;
                case 'completed':
                    return 'Dossier Complet';
                    break;
                case 'accepted':
                    return 'Dossier Accepter';
                    break;
                case 'declined':
                    return 'Dossier Refuser';
                    break;
                case 'suspended':
                    return 'Suspendue';
                    break;
                case 'closed':
                    return 'Dossier Clotûrer';
                    break;
                default:
                    return 'Compte Actif';
                    break;
            }
        } else {
            switch ($status) {
                case 'open':
                    return '<span class="badge badge-primary">Ouverture en cours</span>';
                    break;
                case 'completed':
                    return '<span class="badge badge-warning">Dossier Complet</span>';
                    break;
                case 'accepted':
                    return '<span class="badge badge-success">Dossier Accepter</span>';
                    break;
                case 'declined':
                    return '<span class="badge badge-danger">Dossier Refuser</span>';
                    break;
                case 'suspended':
                    return '<span class="badge badge-warning">Dossier Suspendue</span>';
                    break;
                case 'closed':
                    return '<span class="badge badge-danger">Dossier Clotûrer</span>';
                    break;
                default:
                    return '<span class="badge badge-secondary">Compte Actif</span>';
                    break;
            }
        }
    }

    public static function getName($customer, $first = false)
    {
        if ($first == true) {
            if ($customer->info->type == 'part') {
                return $customer->info->lastname . ' ' . $customer->info->firstname;
            } else {
                return $customer->info->company;
            }
        } else {
            if ($customer->info->type == 'part') {
                return $customer->info->civility . '. ' . $customer->info->lastname . ' ' . $customer->info->firstname;
            } else {
                return $customer->info->company;
            }
        }
    }

    public static function getFirstname($customer)
    {
        if ($customer->info->type == 'pro') {
            return $customer->info->company;
        } else {
            return $customer->info->firstname;
        }
    }

    public static function getAmountAllDeposit($customer)
    {
        $calc = 0;
        $wallets = $customer->wallets();

        foreach ($wallets->get() as $wallet) {
            $ds = $wallet->transactions()->where('type', 'depot')->get();
            foreach ($ds as $transaction) {
                $calc += $transaction->amount;
            }
        }

        return eur($calc);
    }

    public static function getAmountAllWithdraw($customer)
    {
        $calc = 0;
        $wallets = $customer->wallets();

        foreach ($wallets->get() as $wallet) {
            $ds = $wallet->transactions()->where('type', 'retrait')->get();
            foreach ($ds as $transaction) {
                $calc += $transaction->amount;
            }
        }

        return eur($calc);
    }

    public static function getAmountAllTransfers($customer)
    {
        $calc = 0;
        $wallets = $customer->wallets();

        foreach ($wallets->get() as $wallet) {
            $ds = $wallet->transactions()->where('type', 'virement')->orWhere('type', 'sepa')->get();
            foreach ($ds as $transaction) {
                $calc += $transaction->amount;
            }
        }

        return eur($calc);
    }

    public static function getAmountAllTransactions($customer)
    {
        $calc = 0;
        $wallets = $customer->wallets();

        foreach ($wallets->get() as $wallet) {
            $ds = $wallet->transactions()->get()->count();
            $calc += $ds;
        }

        return $calc;
    }

    public static function getCountAllLoan($customer)
    {
        return $customer->prets()->get()->count();
    }

    public static function getCoutAllEpargnes($customer)
    {
        return $customer->wallets()->where('type', 'epargne')->get()->count();
    }

    public static function getCountAllBeneficiaires($customer)
    {
        return $customer->beneficiaires()->count();
    }

    /**
     * @param $revenue
     * @param $pro_category
     * @return float|int
     */
    public static function calcOverdraft($revenue, $pro_category): float
    {
        $taux = 9.98;
        $result = $revenue / 3;

        if ($result >= 300) {
            if ($pro_category != 'Sans Emploie') {
                return $result > 1000 ? 1000 : ceil($result / 100) * 100;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    /**
     * @param $session
     * @return Model|User
     */
    public function createCustomer($session): Model|User
    {
        $password = \Str::random(8);
        $pushbullet = new PushbulletApi();
        $twilio = new Verify();

        $user = User::create([
            'name' => $session->perso['lastname'] . ' ' . $session->perso['firstname'],
            'email' => $session->perso['email'],
            'password' => \Hash::make($password),
            'identifiant' => UserHelper::generateID(),
            'agency_id' => 2
        ]);

        $user->settingnotification()->create(['user_id' => $user->id]);
        $iden = $pushbullet->createDevice($session->perso['firstname'], $session->perso['lastname']);
        $user->update([
            'pushbullet_device_id' => $iden->iden
        ]);
        $twilio->create($session->perso['mobile']);

        $this->createsCustomer($session, $user, $password);

        return $user;
    }

    private function createsCustomer($session, $user, $password)
    {
        $code_auth = rand(1000, 9999);
        $bank = new BankFintech();
        $ficp = $bank->callInter();

        $customer = Customer::create([
            'status_open_account' => 'open',
            'auth_code' => base64_encode($code_auth),
            'user_id' => $user->id,
            'package_id' => $session->package->id,
            'agency_id' => $user->agency_id,
            'ficp' => $ficp->ficp ? 1 : 0,
            'fcc' => $ficp->fcc ? 1 : 0,
        ]);

        $info = CustomerInfo::create([
            'type' => 'part',
            'civility' => $session->perso['civility'],
            'lastname' => $session->perso['lastname'],
            'middlename' => $session->perso['middlename'],
            'firstname' => $session->perso['firstname'],
            'datebirth' => Carbon::createFromTimestamp(strtotime($session->perso['datebirth'])),
            'citybirth' => $session->perso['citybirth'],
            'countrybirth' => $session->perso['countrybirth'],
            'address' => $session->perso['address'],
            'addressbis' => $session->perso['addressbis'],
            'postal' => $session->perso['postal'],
            'city' => $session->perso['city'],
            'country' => $session->perso['country'],
            'phone' => $session->perso['phone'],
            'mobile' => $session->perso['mobile'],
            'country_code' => '+33',
            'customer_id' => $customer->id,
        ]);

        $setting = CustomerSetting::create([
            'customer_id' => $customer->id,
        ]);

        $situation = CustomerSituation::create([
            'legal_capacity' => $session->perso['legal_capacity'],
            'family_situation' => $session->perso['family_situation'],
            'logement' => $session->perso['logement'],
            'logement_at' => $session->perso['logement_at'],
            'child' => $session->perso['child'],
            'person_charged' => $session->perso['person_charged'],
            'pro_category' => $session->rent['pro_category'],
            'pro_profession' => $session->rent['pro_profession'],
            'customer_id' => $customer->id,
        ]);

        $income = CustomerSituationIncome::create([
            'pro_incoming' => $session->rent['pro_incoming'],
            'patrimoine' => $session->rent['patrimoine'],
            'customer_id' => $customer->id,
        ]);

        $charge = CustomerSituationCharge::create([
            'rent' => $session->rent['rent'],
            'nb_credit' => $session->rent['nb_credit'],
            'credit' => $session->rent['credit'],
            'divers' => $session->rent['divers'],
            'customer_id' => $customer->id,
        ]);

        $wallet = $this->createWallet($customer);
        $card = $this->createCreditCard($wallet, $session);

        // Envoie du mot de passe provisoire par SMS avec identifiant
        try {
            config('app.env') != 'local' ?
                $user->notify(new SendPasswordNotification($customer, $password)) :
                $user->notify(new \App\Notifications\Testing\Customer\SendPasswordNotification($customer, $password));

            config('app.env') == 'local' ? Whatsapp::sendNotification($customer->info->mobile, "Votre mot de passe provisoire est: $password") : null;
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
        }

        \Storage::disk('public')->makeDirectory('gdd/' . $user->id . '/documents');
        \Storage::disk('public')->makeDirectory('gdd/' . $user->id . '/account');
        foreach (DocumentCategory::all() as $doc) {
            \Storage::disk('public')->makeDirectory('gdd/' . $user->id . '/documents/' . $doc->name);
        }

        DocumentFile::createDoc(
            $customer,
            'Convention Preuve',
            'Convention de Preuve - CUS' . $customer->user->identifiant,
            3,
            null,
            true,
            true,
            false,
            true,
            []);

        DocumentFile::createDoc(
            $customer,
            'Certification Fiscal',
            'Formulaire d\'auto-certification de résidence fiscale - CUS' . $customer->user->identifiant,
            3,
            null,
            true,
            true,
            false,
            true,
            []);

        DocumentFile::createDoc(
            $customer,
            'Synthese Echange',
            'Synthese Echange - CUS' . $customer->user->identifiant,
            3,
            null,
            false,
            false,
            false,
            true,
            ["card" => $card]);

        DocumentFile::createDoc(
            $customer,
            'Contrat Banque Distance',
            'Contrat Banque à distance - CUS' . $customer->user->identifiant,
            3,
            null,
            true,
            true,
            false,
            true,
            []);

        $document = DocumentFile::createDoc(
            $customer,
            'Contrat Banque Souscription',
            'Convention de compte - CUS' . $customer->user->identifiant,
            3,
            'CNT' . \Str::upper(\Str::random(6)),
            true,
            true,
            false,
            true,
            ["card" => $card, "wallet" => $wallet]);

        DocumentFile::createDoc(
            $customer,
            'Info Tarif',
            'Information Tarifaire',
            5,
            null,
            false,
            false,
            false,
            false,
            []);

        DocumentFile::createDoc(
            $customer,
            'Rib',
            'Relevé Identité Bancaire',
            5,
            null,
            false,
            false,
            false,
            false,
            ["wallet" => $wallet]);

        \Storage::disk('public')->copy('gdd/shared/info_tarif.pdf', 'gdd/' . $user->id . '/documents/Courriers/info_tarif.pdf');

        $documents = [];

        $docs = $customer->documents()->where('document_category_id', 3)->get();
        foreach ($docs as $document) {
            $documents[] = [
                'url' => 'gdd/' . $user->id . '/documents/Contrats/' . $document->name . '.pdf'
            ];
        }

        $user->notify(new WelcomeNotification($customer, $documents));

        $this->setOptions($session, $customer, $wallet, $card, $setting);

        return $customer;
    }

    /**
     * @param $customer
     * @return CustomerWallet|Model
     */
    private function createWallet($customer): Model|CustomerWallet
    {
        $number_account = rand(10000000000, 99999999999);
        $ibanC = new Generator($customer->user->agency->code_banque, $number_account, 'FR');
        $iban = $ibanC->generate();
        $rib_key = \Str::substr($iban, 18, 2);

        return CustomerWallet::create([
            'uuid' => \Str::uuid(),
            'number_account' => $number_account,
            'iban' => $iban,
            'rib_key' => $rib_key,
            'type' => 'compte',
            'status' => 'active',
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * @param CustomerWallet $wallet
     * @param $session
     * @return CustomerCreditCard|Model
     */
    private function createCreditCard(CustomerWallet $wallet, $session): Model|CustomerCreditCard
    {
        $creditcard = new \Plansky\CreditCard\Generator();
        $card_number = $creditcard->single();
        $card_code = rand(1000, 9999);

        $card = \App\Models\Customer\CustomerCreditCard::create([
            'exp_month' => \Str::length(now()->month) <= 1 ? '0' . now()->month : now()->month,
            'number' => $card_number,
            'credit_card_support_id' => CreditCardSupport::where('slug', $session->card['card_support'])->first()->id,
            'debit' => $session->card['card_debit'] != null ? 'differed' : 'immediate',
            'cvc' => rand(100, 999),
            'code' => base64_encode($card_code),
            'limit_payment' => \App\Helper\CustomerCreditCard::calcLimitPayment(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
            'limit_retrait' => \App\Helper\CustomerCreditCard::calcLimitRetrait(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
            'customer_wallet_id' => $wallet->id,
        ]);

        config('app.env') != 'local' ?
            $wallet->customer->user->notify(new \App\Notifications\Customer\SendCreditCardCodeNotification($card_code, $card)) :
            $wallet->customer->user->notify(new SendCreditCardCodeNotification($card_code, $card));

        config('app.env') == 'local' ? Whatsapp::sendNotification($card->wallet->customer->info->mobile, "Le code de votre carte bleu N°$card->number est le $card_code") : null;

        return $card;
    }

    private function setOptions($session, Customer $customer, CustomerWallet $wallet, CustomerCreditCard $card, CustomerSetting $setting)
    {
        // Configuration par rapport au package choisie
        switch ($session->package['name']) {
            case 'Cristal':
                $setting->update([
                    'nb_physical_card' => 1,
                    'nb_virtual_card' => 0,
                    'check' => 0,
                ]);
                break;

            case 'Gold':
                $setting->update([
                    'nb_physical_card' => 1,
                    'nb_virtual_card' => 5,
                    'check' => 1,
                ]);
                break;

            case 'Platine':
                $setting->update([
                    'nb_physical_card' => 5,
                    'nb_virtual_card' => 5,
                    'check' => 1,
                ]);
                if (isset($session->subscribe['overdraft'])) {
                    $wallet->update([
                        'decouvert' => 1,
                        'balance_decouvert' => $session->subscribe['ouverdraft_amount']
                    ]);
                }
        }
        if (isset($session->subscribe['alerta'])) {
            $setting->update([
                'alerta' => 1
            ]);
        }

        if (isset($session->subscribe['daily_insurance'])) {
            $this->createDailyAssuranceContract($customer);
        }

        if (isset($session->subscribe['card_code'])) {
            $setting->update([
                'card_code' => true
            ]);
        }

        if (isset($session->subscribe['offert'])) {
            CustomerTransactionHelper::create(
                'credit',
                'autre',
                'Chèque cadeau 80 EUR OFFERTS',
                80,
                $wallet->id,
                true,
                'Chèque cadeau 80 EUR OFFERTS',
                now()
            );
        }
    }

    private function createDailyAssuranceContract(Customer $customer)
    {
        $contract = $customer->insurances()->create([
            'reference' => random_numeric(),
            'date_member' => now()->startOfDay(),
            'effect_date' => now()->addDay()->startOfDay(),
            'end_date' => now()->addYear()->endOfDay(),
            'mensuality' => 0,
            'customer_id' => $customer->id,
            'insurance_package_id' => 11,
            'insurance_package_form_id' => 26
        ]);

        $contract->update([
            'mensuality' => $contract->form->typed_price
        ]);

        DocumentFile::createDoc($customer,
            'condition general ' . $contract->package->name,
            'Condition Général ' . $contract->package->name,
            1,
            $contract->reference,
            false,
            false,
            false,
            true
        );

        DocumentFile::createDoc($customer,
            'ddac ' . $contract->package->name,
            'DDAC ' . $contract->package->name,
            1,
            $contract->reference,
            true,
            true,
            true,
            true
        );

        DocumentFile::createDoc($customer,
            "Document information produit assurance " . $contract->package->name,
            "Document d'information sur le produit d'assurance " . $contract->package->name,
            1,
            $contract->reference,
            false,
            false,
            false,
            true,
            ['package' => $contract->package]
        );

        DocumentFile::createDoc($customer,
            'synthese echange ' . $contract->package->name,
            "Synthèse des echanges " . $contract->package->name,
            1,
            $contract->reference,
            true,
            true,
            true,
            true,
            []
        );

        DocumentFile::createDoc($customer,
            'condition particuliere ' . $contract->package->name,
            "Condition Particuliere " . $contract->package->name,
            1,
            $contract->reference,
            true,
            true,
            true,
            true,
            ["contract" => $contract]
        );

        DocumentFile::createDoc($customer,
            'condition operation bancaire',
            "Conditions appliquees au operation bancaire",
            1,
            $contract->reference,
            false,
            false,
            false,
            true,
            []
        );

        $documents = [];
        $docs = $customer->documents()->where('document_category_id', 1)->get();
        foreach ($docs as $document) {
            $documents[] = [
                'url' => 'gdd/' . $customer->user->id . '/documents/Assurance/' . $document->name . '.pdf'
            ];
        }

        $customer->user->notify(new NewContractInsurance($customer, $contract, $documents));

        return $contract;
    }
}

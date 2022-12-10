<?php

namespace App\Console\Commands;

use App\Helper\CustomerHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\DocumentFile;
use App\Helper\GeoHelper;
use App\Helper\LogHelper;
use App\Helper\UserHelper;
use App\Models\Business\BusinessParam;
use App\Models\Core\Agency;
use App\Models\Core\Bank;
use App\Models\Core\CreditCardSupport;
use App\Models\Core\DocumentCategory;
use App\Models\Core\Package;
use App\Models\Core\Shipping;
use App\Models\Core\ShippingTrack;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerCheckDeposit;
use App\Models\Customer\CustomerCheckDepositList;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerCreditor;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerInsurance;
use App\Models\Customer\CustomerMoneyDeposit;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerPretCaution;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerWallet;
use App\Models\Customer\CustomerWithdraw;
use App\Models\Customer\CustomerWithdrawDab;
use App\Models\Reseller\Reseller;
use App\Models\User;
use App\Notifications\Customer\MensualReleverNotification;
use App\Notifications\Customer\NewPrlvPresented;
use App\Notifications\Customer\SendAlertaInfoNotification;
use App\Notifications\Reseller\ShipTpeNotificationP;
use App\Notifications\Reseller\WelcomeNotificationP;
use App\Scope\TransactionTrait;
use App\Services\Fintech\Payment\Sepa;
use App\Services\Mapbox;
use App\Services\SlackNotifier;
use App\Services\Stripe;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Exception;
use Faker\Factory;
use IbanGenerator\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use macropage\LaravelSchedulerWatcher\LaravelSchedulerCustomMutex;
use Vicopo\Vicopo;

class LifeCommand extends Command
{
    use LaravelSchedulerCustomMutex, TransactionTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'life {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    private $slack;

    public function __construct()
    {
        $this->setSignature('life {action}');
        parent::__construct();
        $this->slack = new SlackNotifier('#fintech-site');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->checkCustomMutex()) {
            return 0;
        }
        match ($this->argument('action')) {
            'generateCustomers' => $this->generateCustomers(),
            'generateSalary' => $this->generateSalary(),
            'generateDebit' => $this->generateDebit(),
            'generatePrlvSepa' => $this->generatePrlvSepa(),
            'generateMensualReleve' => $this->generateMensualReleve(),
            'limitWithdraw' => $this->limitWithdraw(),
            'alerta' => $this->sendAlertaInfo(),
            "generateReseller" => $this->generateReseller(),
            'GeneratePayment' => $this->generatePaymentCB()
        };
        return Command::SUCCESS;

    }

    /**
     * Tous les jours à 08:00/11:00/14:00/18:00
     * @return void
     */
    private function generateCustomers()
    {
        $stripe = new Stripe();
        $r = rand(1, 5);
        $arr = [];
        $faker = Factory::create('fr_FR');
        $civility = ['M', 'Mme', 'Mlle'];
        $civ = $civility[rand(0, 2)];
        $customer_type = ['part', 'pro', 'orga', 'assoc'];

        $users = collect();
        for ($i = 1; $i <= $r; $i++) {
            $customer_type_choice = $customer_type[rand(0, 3)];
            $firstname = $customer_type_choice == 'part' ? ($civ != 'M' ? $faker->firstNameFemale : $faker->firstNameMale) : '';
            $lastname = $customer_type_choice == 'part' ? $faker->lastName : '';
            $company = $customer_type_choice != 'part' ? $faker->company : null;

            $users->push(User::create([
                'name' => $customer_type_choice == 'part' ? $lastname . ' ' . $firstname : $company,
                'email' => $customer_type_choice != 'part' ? Str::camel($company)."@".$faker->safeEmailDomain : $firstname.'.'.$lastname.'@'.$faker->safeEmailDomain,
                'password' => Hash::make('password'),
                'identifiant' => UserHelper::generateID(),
                'type_customer' => $customer_type_choice,
                'agency_id' => Agency::all()->random()->id,
            ]));
        }

        foreach ($users as $user) {
            $name = explode(' ', $user->name);
            if($user->type_customer == 'part') {
                $firstname = Str::upper($name[0]);
                $lastname = $name[1];
            }
            $state_account = ['open', 'completed', 'accepted', 'declined', 'terminated', 'suspended', 'closed'];
            $state = $state_account[rand(0, 6)];

            $customer = Customer::create([
                'status_open_account' => $state,
                'cotation' => 8,
                'auth_code' => base64_encode('1234'),
                'ficp' => $faker->boolean(),
                'fcc' => $faker->boolean(),
                'agent_id' => User::where('agent', 1)->get()->random()->id,
                'persona_reference_id' => null,
                'user_id' => $user->id,
                'package_id' => Package::where('type_cpt', $user->type_customer)->get()->random()->id,
                'agency_id' => Agency::all()->random()->id,
            ]);

            $customer->update(['persona_reference_id' => 'customer_' . now()->format('dmYhi') . "_" . $customer->id]);

            $user->subscriptions()->create([
                'subscribe_type' => Package::class,
                'subscribe_id' => $customer->package_id,
                'user_id' => $user->id
            ]);

            $postcode = $faker->postcode;
            $info = CustomerInfo::create([
                'type' => $user->type_customer,
                'customer_id' => $customer->id,
                'civility' => $user->type_customer == 'part' ? $civ : null,
                'firstname' => $user->type_customer == 'part' ? $firstname : null,
                'lastname' => $user->type_customer == 'part' ? $lastname : null,
                'datebirth' => Carbon::createFromTimestamp($faker->dateTimeBetween('1980-01-01', now()->endOfYear()->subYears(18))->getTimestamp()),
                'citybirth' => $faker->city,
                'countrybirth' => "FR",
                'company' => $user->type_customer != 'part' ? $faker->company : null,
                'siret' => $user->type_customer != 'part' ? random_numeric(9) . '000' . random_numeric(2) : null,
                'address' => $faker->streetAddress,
                'postal' => Str::replace('.0', '', round(intval($postcode), -1)),
                'city' => collect(Vicopo::https(Str::replace('.0', '', round(intval($postcode), -1))))[0]->city ?? 'Les Sables d Olonne',
                'country' => 'FR',
                'phone' => $faker->e164PhoneNumber,
                'mobile' => "+33".rand(6,7).random_numeric(8),
                'country_code' => "+33",
                'email' => $user->email,
                'isVerified' => $faker->boolean,
                'mobileVerified' => $faker->boolean,
                'addressVerified' => $faker->boolean,
                'incomeVerified' => $faker->boolean,
            ]);

            $s_customer = $stripe->client->customers->create([
                'address' => [
                    'city' => $info->city,
                    'country' => 'FR',
                    'line1' => $info->address,
                    'postal_code' => $info->postal,
                ],
                'email' => $user->email,
                'name' => $info->full_name,
                'phone' => $info->mobile,
            ]);

            $customer->update(["stripe_customer_id" => $s_customer->id]);

            if ($info->type != 'part') {
                $forme_type = ['EI', 'EURL', 'SASU', 'SAS', 'SARL', 'SCI', 'Other'];
                $forme = $forme_type[rand(0,6)];
                BusinessParam::create([
                    'name' => $info->full_name,
                    'forme' => $forme,
                    'financement' => $faker->boolean,
                    'apport_personnel' => $faker->randomFloat(0, 1000),
                    'finance' => $faker->randomFloat(0, 1000),
                    'ca' => $faker->randomFloat(0, 1000),
                    'achat' => $faker->randomFloat(0, 1000),
                    'frais' => $faker->randomFloat(0, 1000),
                    'salaire' => $faker->randomFloat(0, 1000),
                    'impot' => $faker->randomFloat(0, 1000),
                    'other_product' => $faker->randomFloat(0, 1000),
                    'other_charge' => $faker->randomFloat(0, 1000),
                    'result' => $faker->randomFloat(0, 10000),
                    'result_finance' => $faker->randomFloat(0, 10000),
                    'indicator' => $faker->boolean,
                    'customer_id' => $customer->id,
                ]);
            }

            CustomerSetting::create([
                'customer_id' => $customer->id,
                'notif_sms' => $faker->boolean,
                'notif_app' => $faker->boolean,
                'notif_mail' => $faker->boolean,
                'nb_physical_card' => $customer->package->nb_carte_physique,
                'nb_virtual_card' => $customer->package->nb_carte_virtuel,
                'check' => $customer->package->check,
                'alerta' => $faker->boolean,
                'cashback' => $customer->package->cashback,
                'paystar' => $customer->package->paystar
            ]);

            CustomerSituation::create([
                'customer_id' => $customer->id,
                'child' => $customer->type == 'part' ? rand(0,5) : 0,
                'person_charged' => $customer->type == 'part' ? rand(0,5) : 0,
            ]);

            CustomerSituationCharge::factory()->create([
                'customer_id' => $customer->id,
            ]);

            CustomerSituationIncome::factory()->create([
                'customer_id' => $customer->id,
            ]);

            $account = CustomerWallet::factory()->create([
                'type' => 'compte',
                'balance_actual' => 0,
                'balance_coming' => 0,
                'customer_id' => $customer->id,
            ]);

            $s_intent = $stripe->client->setupIntents->create([
                'customer' => $customer->stripe_customer_id,
                'payment_method_types' => ['card', 'sepa_debit'],
                'payment_method_data' => [
                    'type' => 'sepa_debit',
                    'sepa_debit' => [
                        'iban' => $account->iban
                    ],
                    'billing_details' => [
                        'address' => [
                            'city' => $info->city,
                            'country' => 'FR',
                            'line1' => $info->address,
                            'postal_code' => $info->postal,
                        ],
                        'name' => $info->full_name,
                        'email' => $user->email,
                        'phone' => $info->mobile
                    ]
                ],
                'confirm' => true,
                'return_url' => config('app.url'),
                'mandate_data' => [
                    'customer_acceptance' => [
                        'type' => 'offline',
                        'accepted_at' => now()->timestamp,
                    ]
                ]
            ]);
            $account->update(["sepa_stripe_mandate" => $s_intent->mandate]);
            $pm_stripe = $stripe->client->paymentMethods->create([
                'type' => "sepa_debit",
                'sepa_debit' => [
                    'iban' => $account->iban
                ],
                'billing_details' => [
                    'address' => [
                        'city' => $info->city,
                        'country' => 'FR',
                        'line1' => $info->address,
                        'postal_code' => $info->postal,
                    ],
                    'name' => $info->full_name,
                    'email' => $user->email,
                    'phone' => $info->mobile
                ]
            ]);

            $card = CustomerCreditCard::factory()->create([
                'customer_wallet_id' => $account->id,
                'credit_card_support_id' => CreditCardSupport::where('type_customer', $user->type_customer)->get()->random()->id,
            ]);

            $card_type = collect([
                '4242424242424242',
                '4000056655665556',
                '5555555555554444',
                '2223003122003222',
                '5200828282828210',
                '4000002500003155',
                '4001000360000005'
            ]);
            $pm_stripe = $stripe->client->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'exp_year' => $card->exp_year,
                    'exp_month' => $card->exp_month,
                    'number' => $card_type[rand(0,6)],
                    'cvc' => $card->cvc
                ],
                'billing_details' => [
                    'address' => [
                        'city' => $info->city,
                        'country' => 'FR',
                        'line1' => $info->address,
                        'postal_code' => $info->postal,
                    ],
                    'name' => $info->full_name,
                    'email' => $user->email,
                    'phone' => $info->mobile
                ]
            ]);

            $stripe->client->paymentMethods->attach($pm_stripe->id, ['customer' => $customer->stripe_customer_id]);

            if ($customer->status_open_account == 'terminated') {

                CustomerBeneficiaire::factory(rand(1, 10))->create([
                    'customer_id' => $customer->id,
                ]);

                if ($customer->info->type == 'part') {
                    // Transfers du salaire
                    $title = 'Virement Salaire ' . now()->monthName;
                    CustomerTransactionHelper::create(
                        'credit',
                        'virement',
                        $title,
                        $customer->income->pro_incoming,
                        $account->id,
                        true,
                        $title,
                        now());

                    if ($card->facelia == 1) {
                        $this->createFacelia($customer, $card);
                    }
                } else {
                    $title_pro = "Dépot de capital en compte courant";
                    CustomerTransactionHelper::create(
                        'credit',
                        'depot',
                        $title_pro,
                        rand(1, 99999999),
                        $account->id,
                        true,
                        $title_pro,
                        now()
                    );
                }

                // Prise de la souscription
                if ($customer->package->price > 0) {
                    CustomerTransactionHelper::create(
                        'debit',
                        'souscription',
                        'Cotisation Pack ' . $customer->package->name . ' - ' . now()->monthName,
                        $customer->package->price,
                        $account->id,
                        true,
                        'Cotisation Pack ' . $customer->package->name . ' - ' . now()->monthName,
                        now()
                    );
                }

                \Storage::disk('gdd')->makeDirectory($user->id . '/documents');
                \Storage::disk('gdd')->makeDirectory($user->id . '/account');
                foreach (DocumentCategory::all() as $doc) {
                    \Storage::disk('gdd')->makeDirectory($user->id . '/documents/' . $doc->slug);
                }

            }


            $arr [] = [
                $customer->info->full_name,
                $customer->status_open_account
            ];
        }

        $this->line("Date: " . now()->format("d/m/Y à H:i"));
        $this->line('Nombre de nouveau client: ' . $r);
        $this->output->table(['client', 'Etat du compte'], $arr);

        $this->slack->send("Nouveau client", json_encode($arr));
    }

    /**
     * Tous les 1er du mois à 08:00
     * @return void
     */
    private function generateSalary()
    {
        $customers = Customer::where('status_open_account', 'terminated')->get();

        foreach ($customers as $customer) {
            if ($customer->info->type == 'part') {
                $wallet = $customer->wallets()->where('type', 'compte')->first();
                $title = "Virement Salaire " . now()->monthName;

                CustomerTransactionHelper::create(
                    'credit',
                    'virement',
                    $title,
                    $customer->income->pro_incoming,
                    $wallet->id,
                    true,
                    $title,
                    now()
                );
            }
        }

        $this->line("Date: " . now()->format("d/m/Y à H:i"));
        $this->line('Check des virements des salaires terminer');
        $this->slack->send("Check des virements des salaires terminer");
    }

    /**
     * Toute les 15 minutes
     * @return void
     */
    private function generateDebit()
    {
        $customers = Customer::where('status_open_account', 'terminated')->get();
        $retrait = 0;
        $payment = 0;
        $depot_espece = 0;
        $depot_chq = 0;

        foreach ($customers as $customer) {
            foreach ($customer->wallets()->where('type', 'compte')->where('status', 'active')->get() as $wallet) {
                for ($i = 0; $i <= rand(0, 5); $i++) {
                    $category_debit = ['retrait', 'payment'];
                    $type = ['debit', 'credit'];
                    $faker = Factory::create('fr_FR');
                    $now = now();

                    if ($type[rand(0, 1)] == 'debit') {
                        if($wallet->cards()->where('status', 'active')->count() != 0) {
                            switch ($category_debit[rand(0, 1)]) {
                                case 'retrait':
                                    $amount = $faker->randomFloat(2, 0, 1200);
                                    $card = $wallet->cards()->where('status', 'active')->get()->random();
                                    $dab = CustomerWithdrawDab::where('open', 1)->get()->random();
                                    $status_type = ['pending', 'accepted', 'rejected', 'terminated'];
                                    $status = $status_type[rand(0, 3)];

                                    if($amount <= $card->actual_limit_withdraw) {
                                        $withdraw = CustomerWithdraw::createWithdraw($wallet->id, $amount, $dab->id, $status);

                                        $transaction = CustomerTransactionHelper::createDebit(
                                            $wallet->id,
                                            'retrait',
                                            Str::upper("Carte {$card->number_format} Retrait DAB FH {$now->format('d/m')} {$now->format('H:i')} " . Str::limit($dab->name, 10, '')),
                                            Str::upper("Carte {$card->number_format} Retrait DAB FH {$now->format('d/m')} {$now->format('H:i')} " . Str::limit($dab->name, 10, '')),
                                            $amount,
                                            true,
                                            $now
                                        );

                                        $withdraw->update(["customer_transaction_id" => $transaction->id]);
                                        $retrait++;
                                    }
                                    break;

                                case 'payment':
                                    $amount = $faker->randomFloat(2, 0, 1200);
                                    $card = $wallet->cards()->where('status', 'active')->get()->random();
                                    $confirmed = $faker->boolean;
                                    $differed = !$confirmed ? $faker->boolean : false;

                                    if($amount <= $card->actual_limit_payment) {
                                        CustomerTransactionHelper::createDebit(
                                            $wallet->id,
                                            'payment',
                                            "Carte {$card->number_format} {$now->format('d/m')} {$faker->companySuffix}",
                                            "Carte {$card->number_format} {$now->format('d/m')} {$faker->companySuffix}",
                                            $amount,
                                            $confirmed,
                                            $confirmed ? $now : null,
                                            $differed,
                                            $differed ? $now->endOfMonth() : null,
                                            null,
                                            $card->id
                                        );
                                        $payment++;
                                    }
                            }
                        }
                    } else {
                        $type_depot = ['money', 'check'];
                        $td = $type_depot[rand(0, 1)];
                        $dab = CustomerWithdrawDab::all()->random();
                        $amount = $faker->randomFloat(2, 0, 1200);

                        if ($td == 'money') {
                            $status_type = ['pending', 'accepted', 'rejected', 'terminated'];
                            $status = $status_type[rand(0, 3)];
                            $deposit = CustomerMoneyDeposit::createDeposit($amount, $wallet->id, $dab->id);
                            $transaction = CustomerTransactionHelper::createCredit(
                                $wallet->id,
                                'depot',
                                "Dépot d'espèce N°{$deposit->reference}",
                                "Dépot d'espèce N°{$deposit->reference} - {$dab->name}",
                                $amount,
                                $status == 'terminated',
                                $status == 'terminated' ? $now : null
                            );
                            $deposit->update([
                                'customer_transaction_id' => $transaction->id
                            ]);
                            $depot_espece++;
                        } else {
                            if($customer->setting->check) {
                                $status_type = ['pending', 'progress', 'terminated'];
                                $status = $status_type[rand(0, 2)];
                                $deposit = CustomerCheckDeposit::createDeposit($wallet->id, $amount, $status);
                                for ($i = 1; $i <= rand(1, 9); $i++) {
                                    $am = $faker->randomFloat(2, 10, 2500);
                                    CustomerCheckDepositList::insertCheck(
                                        $deposit->id,
                                        random_numeric(7),
                                        $am,
                                        $faker->name,
                                        Bank::where('check_manage', 1)->get()->random()->id,
                                        Carbon::create($now->year, rand(1, 12), rand(1, 30)),
                                        $faker->boolean
                                    );
                                }
                                $calc = CustomerCheckDepositList::where('customer_check_deposit_id', $deposit->id)->sum('amount');
                                $deposit->update(["amount" => $calc]);
                                match ($status) {
                                    "progress" => $transaction = CustomerTransactionHelper::createCredit(
                                        $wallet->id,
                                        'depot',
                                        "Remise de chèque N°" . $deposit->reference,
                                        "Remise de " . CustomerCheckDepositList::where('customer_check_deposit_id', $deposit->id)->count() . " Chèques",
                                        $deposit->amount,
                                        false,
                                        null
                                    ),
                                    "terminated" => $transaction =  CustomerTransactionHelper::createCredit(
                                        $wallet->id,
                                        'depot',
                                        "Remise de chèque N°" . $deposit->reference,
                                        "Remise de " . CustomerCheckDepositList::where('customer_check_deposit_id', $deposit->id)->count() . " Chèques",
                                        $deposit->amount,
                                        true,
                                        $now
                                    ),
                                    default => null
                                };
                                $deposit->update([
                                    'customer_transaction_id' => $transaction->id
                                ]);
                                $depot_chq++;
                            }
                        }
                    }
                }
            }
        }

        $this->slack->send("Génération des débits bancaires", json_encode([strip_tags("Nombre de retrait bancaire: ").$retrait]));
        $this->slack->send("Génération des débits bancaires", json_encode([strip_tags("Nombre de paiement par carte: ").$payment]));
        $this->slack->send("Génération des débits bancaires", json_encode([strip_tags("Nombre de depot d'espèce: ").$depot_espece]));
        $this->slack->send("Génération des débits bancaires", json_encode([strip_tags("Nombre de depot de chèque: ").$depot_chq]));

    }

    /**
     * Tous les jours à 08:00/14:00
     * @return void
     */
    private function generatePrlvSepa()
    {
        $customers = Customer::where('status_open_account', 'terminated')->get();
        $arr = [];

        foreach ($customers as $customer) {
            foreach ($customer->wallets()->where('status', 'active')->where('type', 'compte')->get() as $wallet) {
                if (rand(0, 1) == 1) {
                    $sepas = [];
                    for ($i = 0; $i <= rand(1, 5); $i++) {
                        $faker = Factory::create('fr_FR');
                        $sepas[] = CustomerSepa::create([
                            'uuid' => Str::uuid(),
                            'creditor' => $faker->company,
                            'number_mandate' => generateReference(rand(8, 15)),
                            'amount' => -rand(5, 3500),
                            'status' => 'waiting',
                            'customer_wallet_id' => $wallet->id,
                            'processed_time' => now()->addDays(rand(1, 5))->startOfDay()
                        ]);
                    }

                    foreach ($sepas as $sepa) {
                        try {
                            $creditor = CustomerCreditor::where('name', 'LIKE', '%' . $sepa->creditor . '%')->count();
                            if ($creditor == 0) {
                                $s = new Sepa();
                                CustomerCreditor::create([
                                    'name' => $sepa->creditor,
                                    'customer_wallet_id' => $wallet->id,
                                    'customer_sepa_id' => $sepa->id,
                                    'identifiant' => $s->generateICS()
                                ]);
                            }
                        } catch (Exception $exception) {
                            LogHelper::notify('critical', $exception);
                        }

                        try {
                            $customer->user->notify(new NewPrlvPresented($sepa, "Comptes & Moyens de paiement"));
                        } catch (Exception $exception) {
                            LogHelper::notify('critical', $exception);
                        }
                        $arr[] = [
                            $customer->info->full_name,
                            $sepa->creditor,
                            $sepa->amount_format,
                            $sepa->updated_at->format("d/m/Y")
                        ];
                    }
                }
            }
        }

        $this->line("Date: " . now()->format("d/m/Y à H:i"));
        $this->output->table(['Client', 'Mandataire', 'Montant', 'Date de Prélèvement'], $arr);
        $this->slack->send("Génération des prélèvement bancaire", json_encode($arr));
    }

    /**
     * Tous les 30 du mois
     * @return void
     */
    private function generateMensualReleve()
    {
        $wallets = CustomerWallet::where('type', 'compte')->where('status', 'active')->get();
        $i = 0;

        foreach ($wallets as $wallet) {
            $file = DocumentFile::createDoc(
                $wallet->customer,
                'wallet.relever_mensuel',
                'Relever Mensuel ' . now()->monthName,
                2,
                null,
                false,
                false,
                false,
                true,
                [
                    'wallet' => $wallet,
                ]
            );

            $wallet->customer->user->notify(new MensualReleverNotification($wallet->customer, $file->append('url_folder'), 'Comptes & Moyens de paiement'));
            $i++;
        }

        $this->line("Date: " . now()->format("d/m/Y à H:i"));
        $this->info('Nombre de relevé généré: ' . $i);
        $this->slack->send("Génération des relevé mensuel", json_encode(["Nombre de relevé: " . $i]));
    }

    /**
     * Tous les jours à 08:00
     * @return int
     */
    private function limitWithdraw()
    {
        $withdraws = CustomerWithdraw::where('status', 'pending')->get();
        $i = 0;

        foreach ($withdraws as $withdraw) {
            $limit = $withdraw->created_at->addDays(5);
            if ($limit->startOfDay() == now()->startOfDay()) {
                $withdraw->transaction()->delete();
                $withdraw->delete();
                $i++;
            }
        }

        $this->slack->send("Suppression des retraits non effectuer", json_encode(["Retrait supprime: " . $i]));
        return 0;
    }

    private function sendAlertaInfo()
    {
        $customers = Customer::where('status_open_account', 'terminated')->get();
        $i = 0;

        foreach ($customers as $customer) {
            if ($customer->setting->alerta) {
                $wallet = $customer->wallets()
                    ->where('type', 'compte')
                    ->where('status', 'active')->first();

                $waiting = $wallet->transactions()
                    ->where('confirmed', false)
                    ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->orderBy('updated_at', 'desc')
                    ->first();

                $mouvement = $wallet->transactions()
                    ->whereBetween('confirmed_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->orderBy('confirmed_at', 'desc')
                    ->first();

                $customer->info->notify(new SendAlertaInfoNotification($wallet, $waiting, $mouvement));
                $i++;
            }
        }

        $this->slack->send("Envoie ALERTA", json_encode(["Nombre d'alerte envoye: " . $i]));
    }

    private function createFacelia(Customer $customer, CustomerCreditCard $card)
    {
        $faker = Factory::create('fr_FR');
        $amount = [500, 1000, 1500, 2000, 2500, 3000];
        $duration = ['low', 'middle', 'fast'];
        $amount_loan = $amount[rand(0, 5)];
        $vitesse = $duration[rand(0, 2)];
        $status_wallet_type = ['pending', 'active', 'suspended', 'closed'];
        $status_wallet = $status_wallet_type[rand(0,3)];
        $payment_wallet = $customer->wallets()->where('type', 'compte')->where('status', 'active')->first();

        $number_account = random_numeric(9);
        $ibanG = new Generator($customer->user->agency->code_banque, $number_account, 'fr');

        $cpt_pret = CustomerWallet::create([
            'uuid' => Str::uuid(),
            'number_account' => $number_account,
            'iban' => $ibanG->generate($customer->user->agency->code_banque, $number_account, 'fr'),
            'rib_key' => $ibanG->getBban($customer->user->agency->code_banque, $number_account),
            'type' => 'pret',
            'status' => $status_wallet,
            'balance_actual' => 0,
            'customer_id' => $customer->id,
        ]);

        $req_caution = $faker->boolean;
        $req_insurance = $faker->boolean;
        $pr = CustomerPret::create([
            "uuid" => Str::uuid(),
            "reference" => generateReference(),
            "amount_loan" => $amount_loan,
            "amount_du" => 0,
            "amount_interest" => 0,
            "mensuality" => 0,
            "duration" => 36,
            "status" => "progress",
            "signed_customer" => 1,
            "signed_bank" => 1,
            "wallet_payment_id" => $payment_wallet->id,
            'customer_wallet_id' => $cpt_pret->id,
            "first_payment_at" => Carbon::create(now()->year, now()->addMonth()->month, 5),
            'required_caution' => $req_caution,
            'required_insurance' => $req_insurance,
            'confirmed_at' => now(),
            'loan_plan_id' => 8,
            'customer_id' => $customer->id,
        ]);
        $interestTaxe = CustomerLoanHelper::calcLoanIntestVariableTaxe($pr);
        $interest = CustomerLoanHelper::getLoanInterest($amount_loan, $interestTaxe);
        $du = $amount_loan + $interest;

        $pr->update([
            'amount_du' => $du,
            'mensuality' => $du / CustomerLoanHelper::getPeriodicMensualityFromVitess($vitesse),
            'amount_interest' => $interest
        ]);

        if($req_insurance) {
            $insurance = CustomerInsurance::create([
                'status' => 'active',
                'reference' => generateReference(),
                'date_member' => now(),
                'effect_date' => now(),
                'end_date' => now()->addMonths(36),
                'beneficiaire' => $customer->info->full_name,
                'customer_id' => $customer->id,
                'insurance_package_id' => 18,
                'insurance_package_form_id' => rand(39,41),
                'customer_wallet_id' => $cpt_pret->id,
            ]);

            DocumentFile::createDoc(
                $customer,
                'insurance.synthese_echange',
                $insurance->reference. ' - Synthèse Echange',
                1,
                $insurance->reference,
                false,
                false,
                false,
                true,
                ["insurance" => $insurance]
            );

            DocumentFile::createDoc(
                $customer,
                'insurance.bordereau_retractation',
                $insurance->reference.' - Bordereau de retractation',
                1,
                $insurance->reference,
                false,
                false,
                false,
                true,
                ["insurance" => $insurance]
            );

            $cnt_insu = DocumentFile::createDoc(
                $customer,
                'insurance.contrat_assurance',
                $insurance->reference. " - Contrat assurance",
                1,
                $insurance->reference,
                true,
                true,
                true,
                true,
                ['insurance' => $insurance]
            );
        }

        if($req_caution) {
            for($i=0; $i <= rand(1,3); $i++) {
                $civility_type = ["M", "Mme", "Mlle"];
                $civility = $civility_type[rand(0,2)];
                $type_caution_type = ['simple', 'solidaire'];
                $type_type = ['physique', 'moral'];
                $status_type = ['process', 'retired'];
                $type_caution = $type_caution_type[rand(0,1)];
                $type = $type_type[rand(0,1)];
                $status = $status_type[rand(0,1)];
                $ficap = $faker->boolean;
                $postal = $faker->postcode;

                $caution = CustomerPretCaution::create([
                    'type_caution' => $type_caution,
                    'type' => $type,
                    'status' => $status,
                    'civility' => $type == 'physique' ? $civility : null,
                    'firstname' => $type == 'physique' ? ($civility == 'M' ? $faker->firstNameMale : $faker->firstNameFemale) : null,
                    'lastname' => $type == 'physique' ? $faker->lastName : null,
                    'company' => $type == 'moral' ? $faker->company : null,
                    'ficap' => $ficap,
                    'address' => $faker->address,
                    'postal' => $postal,
                    'city' => collect(Vicopo::https(Str::replace('.0', '', round(intval($postal), -1))))[0]->city ?? 'Les Sables d Olonne',
                    'country' => "France",
                    'phone' => $faker->e164PhoneNumber,
                    'email' => $faker->email,
                    'password' => $ficap ? Hash::make('password') : null,
                    'num_cni' => $type == 'physique' ? Str::random(36) : null,
                    'date_naissance' => $type == 'physique' ? Carbon::create(now()->subYears(rand(0,40))->year, rand(1,12), rand(1,30)) : null,
                    'country_naissance' => $type == 'physique' ? $faker->boolean(75) ? 'France' : $faker->country : null,
                    'dep_naissance' => $type == 'physique' ? GeoHelper::getStateFromCountry('France')->random()->name : null,
                    'ville_naissance' => $type == 'physique' ? GeoHelper::getCitiesFromCountry('France')->random() : null,
                    'persona_reference_id' => 'caution_'.now()->format('dmYHis'),
                    'identityVerify' => 1,
                    'addressVerify' => 1,
                    'siret' => $type == 'moral' ? random_numeric(9) . '000' . random_numeric(2) : null,
                    'companyVerify' => 1,
                    'sign_caution' => 1,
                    'signed_at' => now(),
                    'customer_pret_id' => $pr->id,
                ]);

                DocumentFile::createDoc(
                    $customer,
                    'loan.caution_'.$type_caution,
                    $pr->reference." - Caution ".Str::ucfirst($type_caution)." - {$caution->full_name}",
                    3,
                    $pr->reference,
                    true,
                    true,
                    false,
                    true,
                    ['caution' => $caution],
                    '',
                    '',
                    'simple'
                );
            }
        }

        $card->update([
            'customer_pret_id' => $pr->id,
        ]);

        $facelia = CustomerFacelia::create([
            'reference' => generateReference(),
            'amount_available' => $amount_loan,
            'amount_interest' => 0,
            'amount_du' => 0,
            'mensuality' => 0,
            'next_expiration' => null,
            'customer_pret_id' => $pr->id,
            'customer_credit_card_id' => $card->id,
            'customer_wallet_id' => $cpt_pret->id,
            'wallet_payment_id' => $card->wallet->id,
        ]);

        $customer->user->subscriptions()->create([
            'subscribe_type' => CustomerPret::class,
            'subscribe_id' => $pr->id
        ]);

        DocumentFile::createDoc(
            $customer,
            'loan.plan_damortissement',
            $pr->reference . " - Plan d'amortissement",
            3,
            $pr->reference,
            false,
            false,
            false,
            true,
            ['credit' => $pr]
        );


        DocumentFile::createDoc(
            $customer,
            'loan.contrat_de_credit_facelia',
            $pr->reference . ' - Contrat de Crédit FACELIA',
            3,
            null,
            true,
            true,
            false,
            true,
            ['pret' => $pr]
        );

        DocumentFile::createDoc(
            $customer,
            'general.fiche_de_dialogue',
            $pr->reference . ' - Fiche de Dialogue',
            3,
            null,
            false,
            false,
            false,
            true,
            []
        );

        DocumentFile::createDoc(
            $customer,
            'loan.information_precontractuel_normalise',
            $pr->reference . ' - Information Précontractuel Normalisé',
            3,
            null,
            true,
            true,
            false,
            true,
            ['credit' => $pr]
        );

        DocumentFile::createDoc(
            $customer,
            'general.mandat_prelevement_sepa',
            $pr->reference . ' - Mandat Prélèvement SEPA',
            3,
            null,
            false,
            false,
            false,
            true,
            ["wallet" => $payment_wallet->id]
        );

    }

    private function generateReseller()
    {
        $map = new Mapbox();
        $collects = collect($map->call()->features);
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i <= rand(0, 4); $i++) {
            $password = Str::random(8);
            $reseller = $collects->random();

//            LogHelper::error("Reseller", $reseller);

            $user = User::create([
                'name' => $reseller->text,
                'email' => Str::snake(Str::limit($reseller->text, 15, '')) . '@' . $faker->safeEmailDomain,
                'password' => \Hash::make($password),
                'customer' => 0,
                'reseller' => 1,
                'identifiant' => UserHelper::generateID(),
                'agency_id' => 1
            ]);

            $dab = CustomerWithdrawDab::create([
                'type' => $reseller->properties->category,
                'name' => $reseller->text,
                'address' => $reseller->properties->address,
                'postal' => $reseller->context[1]->text,
                'city' => $reseller->context[2]->text,
                'latitude' => $reseller->center[0],
                'longitude' => $reseller->center[1],
                'img' => null,
                'open' => rand(0, 1),
                'phone' => null
            ]);

            $res = Reseller::create([
                'limit_outgoing' => ceil(random_numeric(4)),
                'limit_incoming' => ceil(random_numeric(4)),
                'user_id' => $user->id,
                'customer_withdraw_dabs_id' => $dab->id
            ]);

            $shipTPE = Shipping::create([
                'number_ship' => Str::random(18),
                'product' => 'TPE Distributeur',
                'date_delivery_estimated' => now()->addDays(5)
            ]);

            ShippingTrack::create([
                'state' => 'ordered',
                'shipping_id' => $shipTPE->id,
            ]);
            $res->shippings()->attach($shipTPE->id);
            $res->user->notify(new ShipTpeNotificationP($res, $shipTPE));

            $document = null;
            $agence = Agency::find(1);

            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'chroot' => [
                    realpath(base_path()) . '/public/css',
                    realpath(base_path()) . '/storage/logo',
                ],
                'enable-local-file-access' => true,
                'viewport-size' => '1280x1024',
            ])->loadView('pdf.reseller.contrat', [
                'agence' => $agence,
                'title' => $document != null ? $document->name : 'Document',
                'reseller' => $reseller
            ]);

            $pdf->save(public_path('storage/reseller/' . $user->id . '/contrat.pdf'));
            $res->user->notify(new WelcomeNotificationP($res, $password));

        }
    }

    private function generatePaymentCB()
    {
        $faker = Factory::create('fr_FR');
        $wallets = CustomerWallet::where('type', 'compte')->where('status', 'active')->get();

        if($faker->boolean(30)) {
            foreach ($wallets as $wallet) {
                $cards = $wallet->cards()->where('status', 'active')->get();
                foreach ($cards as $card) {
                    $day = now()->subDays(rand(0,2));
                    if($card->is_differed) {
                        if($faker->boolean) {
                            CustomerTransactionHelper::createDebit(
                                $wallet->id,
                                'payment',
                                "CARTE {$card->number_card_oscure} {$day->format('d/m')} {$faker->company}",
                                "CARTE {$card->number_card_oscure} {$day->format('d/m')} {$faker->company}",
                                $faker->randomFloat(2, 0.01, 200),
                                false,
                                null,
                                true,
                                $day->endOfMonth(),
                                now(),
                                $card->id,
                            );
                        } else {
                            CustomerTransactionHelper::createDebit(
                                $wallet->id,
                                'payment',
                                "CARTE {$card->number_card_oscure} {$day->format('d/m')} {$faker->company}",
                                "CARTE {$card->number_card_oscure} {$day->format('d/m')} {$faker->company}",
                                $faker->randomFloat(2, 0.01, 200),
                                true,
                                $day,
                                false,
                                null,
                                now(),
                                $card->id,
                            );
                        }
                    }
                    if($card->facelia) {
                        if($faker->boolean) {
                            CustomerTransactionHelper::createDebit(
                                $wallet->id,
                                'facelia',
                                "CARTE {$card->number_card_oscure} {$day->format('d/m')} {$faker->company}",
                                "CARTE {$card->number_card_oscure} {$day->format('d/m')} {$faker->company}",
                                $faker->randomFloat(2, 0.01, 200),
                                true,
                                $day,
                                false,
                                null,
                                now(),
                                $card->id,
                            );
                        } else {
                            CustomerTransactionHelper::createDebit(
                                $wallet->id,
                                'payment',
                                "CARTE {$card->number_card_oscure} {$day->format('d/m')} {$faker->company}",
                                "CARTE {$card->number_card_oscure} {$day->format('d/m')} {$faker->company}",
                                $faker->randomFloat(2, 0.01, 200),
                                true,
                                $day,
                                false,
                                null,
                                now(),
                                $card->id,
                            );
                        }
                    }
                }
            }
        }
    }
}

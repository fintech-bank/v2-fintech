<?php

namespace App\Console\Commands;

use App\Helper\CustomerFaceliaHelper;
use App\Helper\CustomerHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Helper\UserHelper;
use App\Models\Business\BusinessParam;
use App\Models\Core\Agency;
use App\Models\Core\CreditCardSupport;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerCreditor;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerWallet;
use App\Models\Customer\CustomerWithdraw;
use App\Models\User;
use App\Notifications\Customer\MensualReleverNotification;
use App\Notifications\Customer\NewPrlvPresented;
use App\Notifications\Customer\SendAlertaInfoNotification;
use App\Scope\TransactionTrait;
use App\Services\Fintech\Payment\Sepa;
use App\Services\SlackNotifier;
use App\Services\Twilio\Verify;
use Carbon\Carbon;
use Exception;
use Faker\Factory;
use IbanGenerator\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use macropage\LaravelSchedulerWatcher\LaravelSchedulerCustomMutex;

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
            'alerta' => $this->sendAlertaInfo()
        };
        return Command::SUCCESS;

    }

    /**
     * Tous les jours à 08:00/11:00/14:00/18:00
     * @return void
     */
    private function generateCustomers()
    {
        $r = rand(0, 5);
        $arr = [];
        $faker = Factory::create('fr_FR');
        $civility = ['M', 'Mme', 'Mlle'];
        $civ = $civility[rand(0, 2)];
        $customer_type = ['part', 'pro', 'orga', 'assoc'];
        $customer_type_choice = $customer_type[rand(0,3)];
        $firstname = $customer_type_choice == 'part' ? ($civ != 'M' ? $faker->firstNameFemale : $faker->firstNameMale) : '';
        $lastname = $customer_type_choice == 'part' ? $faker->lastName : '';
        $company = $customer_type_choice != 'part' ? $faker->company : null;

        $users = User::factory($r)->create([
            'identifiant' => UserHelper::generateID(),
            'agency_id' => Agency::all()->random()->id,
            'email' => $customer_type_choice != 'part' ? $faker->companyEmail : $faker->email,
            'name' => $customer_type_choice == 'part' ? $lastname.' '.$firstname : $company,
        ]);

        foreach ($users as $user) {

            $customer = Customer::factory()->create([
                'user_id' => $user->id,
                'package_id' => Package::where('type_cpt', $customer_type_choice)->get()->random()->id,
                'agent_id' => User::where('agent', 1)->get()->random()->id,
            ]);
            $customer->update(['persona_reference_id' => 'customer_' . now()->format('dmYhi') . "_" . $customer->id]);

            $user->subscriptions()->create([
                'subscribe_type' => Package::class,
                'subscribe_id' => $customer->package_id,
                'user_id' => $user->id
            ]);

            $info = CustomerInfo::factory()->create([
                'customer_id' => $customer->id,
                'email' => $user->email,
                'type' => $customer_type_choice,
                'civility' => $customer_type_choice == 'part' ? $civ : '',
                'firstname' => $firstname,
                'lastname' => $lastname,
                'datebirth' => $customer_type_choice == 'part' ? Carbon::createFromTimestamp($faker->dateTimeBetween('1980-01-01', now()->endOfYear()->subYears(18))->getTimestamp()) : null,
                'citybirth' => $customer_type_choice == 'part' ? $faker->city : null,
                'countrybirth' => $customer_type_choice == 'part' ? "FR" : null,
                'company' => $company,
                'siret' => $customer_type_choice != 'part' ? random_numeric(9).'000'.random_numeric(2) : null,
            ]);

            $info->setPhoneVerified($info->phone, 'phone');
            $info->setPhoneVerified($info->mobile, 'mobile');

            $user->update([
                'name' => $info->type != 'part' ? $info->company : $info->firstname." ".$info->lastname
            ]);

            if($info->type != 'part') {
                BusinessParam::create([
                    'name' => $info->full_name,
                    'customer_id' => $customer->id,
                ]);
            }

            CustomerSetting::factory()->create([
                'customer_id' => $customer->id,
            ]);

            CustomerSituation::factory()->create([
                'customer_id' => $customer->id,
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

            $card = CustomerCreditCard::factory()->create([
                'customer_wallet_id' => $account->id,
                'credit_card_support_id' => CreditCardSupport::where('type_customer', $customer_type_choice)->get()->random()->id,
            ]);

            if ($customer->status_open_account == 'terminated') {

                CustomerBeneficiaire::factory(rand(1, 10))->create([
                    'customer_id' => $customer->id,
                ]);

                if ($card->facelia == 1) {
                    $this->createFacelia($customer, $card);
                }

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
                } else {
                    $title = "Dépot de capital en compte courant";
                    CustomerTransactionHelper::create(
                        'credit',
                        'depot',
                        $title,
                        rand(1,99999999),
                        $account->id,
                        true,
                        $title,
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


            }

            $arr [] = [
                $customer->info->full_name,
                $customer->status_open_account
            ];
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
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
            if($customer->info->type == 'part') {
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

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
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
        $nb = 0;
        $arr = [];

        foreach ($customers as $customer) {
            $wallet = $customer->wallets()->where('type', 'compte')->where('status', 'active')->first();
            if (isset($wallet)) {
                $select = rand(0, 2);
                $balance_wallet = $wallet->balance_actual + $wallet->balance_decouvert;

                if (rand(0, 1) == 1) {
                    try {
                        if ($balance_wallet > 0) {
                            for ($i=1; $i <= rand(1,5); $i++) {
                                $confirmed = rand(0, 1);
                                $transaction = match ($select) {
                                    0 => $this->generateDepot($wallet->id),
                                    1 => $this->generateRetrait($wallet->id),
                                    2 => $this->generatePayment($wallet)
                                };
                                $nb++;
                                $arr[] = [
                                    $transaction->wallet->customer->info->full_name,
                                    $transaction->designation,
                                    $transaction->amount_format
                                ];
                            }

                        }
                    } catch (Exception $exception) {
                        $this->error($exception->getMessage());
                    }
                }
            }
        }
        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->line('Génération des Transactions: ' . $nb);
        $this->output->table(['Client', 'Mouvement', 'Montant'], $arr);
        $this->slack->send("Génération des Transactions", json_encode($arr));
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
                    for ($i = 0; $i <= rand(1,5); $i++) {
                        $faker = Factory::create('fr_FR');
                        $sepas[] = CustomerSepa::create([
                            'uuid' => Str::uuid(),
                            'creditor' => $faker->company,
                            'number_mandate' => generateReference(rand(8,15)),
                            'amount' => -rand(5,3500),
                            'status' => 'waiting',
                            'customer_wallet_id' => $wallet->id,
                            'processed_time' => now()->addDays(rand(1,5))->startOfDay()
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
                            $customer->user->notify(new NewPrlvPresented($sepa));
                        }catch (Exception $exception) {
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

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
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
                'Relever Mensuel',
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

            $wallet->customer->user->notify(new MensualReleverNotification($file->append('url_folder')));
            $i++;
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->info('Nombre de relevé généré: ' . $i);
        $this->slack->send("Génération des relevé mensuel", json_encode(["Nombre de relevé: ".$i]));
    }

    /**
     * Tous les jours à 08:00
     * @return int
     */
    private function limitWithdraw()
    {
        $withdraws = CustomerWithdraw::where('status', 'pending')->get();
        $arr = [];

        foreach ($withdraws as $withdraw) {
            $limit = $withdraw->created_at->addDays(5);
            if ($limit->startOfDay() == now()->startOfDay()) {
                $withdraw->transaction()->delete();
                $withdraw->delete();
                $arr[] = [
                    'reference' => $withdraw->reference,
                    'amount' => eur($withdraw->amount),
                    'customer' => CustomerHelper::getName($withdraw->wallet->customer)
                ];
            }
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->table(['Reference', 'Montant', 'Client'], $arr);
        $this->slack->send("Suppression des retraits non effectuer");
        return 0;
    }

    private function sendAlertaInfo()
    {
        $customers = Customer::where('status_open_account', 'terminated')->get();

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
            }
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
    }

    private function createFacelia(Customer $customer, CustomerCreditCard $card)
    {
        $amount = [500, 1000, 1500, 2000, 2500, 3000];
        $duration = ['low', 'middle', 'fast'];
        $amount_loan = $amount[rand(0, 5)];
        $vitesse = $duration[rand(0, 2)];

        $number_account = random_numeric(9);
        $ibanG = new Generator($customer->user->agency->code_banque, $number_account, 'fr');

        $cpt_pret = CustomerWallet::query()->create([
            'uuid' => Str::uuid(),
            'number_account' => $number_account,
            'iban' => $ibanG->generate($customer->user->agency->code_banque, $number_account, 'fr'),
            'rib_key' => $ibanG->getBban($customer->user->agency->code_banque, $number_account),
            'type' => 'pret',
            'status' => 'active',
            'balance_actual' => $amount_loan,
            'customer_id' => $customer->id,
        ]);

        $pr = CustomerPret::factory()->create([
            'amount_loan' => $amount_loan,
            'amount_interest' => 0,
            'amount_du' => 0,
            'mensuality' => 0,
            'prlv_day' => 30,
            'duration' => CustomerLoanHelper::getPeriodicMensualityFromVitess($vitesse),
            'status' => 'accepted',
            'customer_wallet_id' => $cpt_pret->id,
            'wallet_payment_id' => $card->wallet->id,
            'first_payment_at' => Carbon::create(now()->year, now()->addMonth()->month, 30),
            'loan_plan_id' => 6,
            'customer_id' => $customer->id,
        ]);
        $interestTaxe = CustomerLoanHelper::calcLoanIntestVariableTaxe($pr);
        $interest = CustomerLoanHelper::getLoanInterest($amount_loan, $interestTaxe);
        $du = $amount_loan + $interest;

        $pr->update([
            'amount_du' => $du,
            'mensuality' => $du / CustomerLoanHelper::getPeriodicMensualityFromVitess($vitesse),
            'interest' => $interest
        ]);

        $card->update([
            'customer_pret_id' => $pr->id,
        ]);

        $facelia = CustomerFacelia::query()->create([
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
            'Plan d\'amortissement',
            $pr->reference . " - Plan d'amortissement",
            3,
            null,
            false,
            false,
            false,
            true,
            ['loan' => $pr, 'card' => $card]
        );

        DocumentFile::createDoc(
            $customer,
            'Assurance Emprunteur',
            $pr->reference . ' - Assurance Emprunteur',
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
            'Avis de conseil relatif assurance',
            $pr->reference . ' - Avis de conseil Relatif au assurance emprunteur',
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
            'contrat de credit facelia',
            $pr->reference . ' - Contrat de Crédit FACELIA',
            3,
            null,
            true,
            true,
            false,
            true,
            ['loan' => $pr]
        );

        DocumentFile::createDoc(
            $customer,
            'Fiche de dialogue',
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
            'Information précontractuel normalise',
            $pr->reference . ' - Information Précontractuel Normalisé',
            3,
            null,
            true,
            true,
            false,
            true,
            ['loan' => $pr]
        );

        DocumentFile::createDoc(
            $customer,
            'Mandat Prélevement sepa',
            $pr->reference . ' - Mandat Prélèvement SEPA',
            3,
            null,
            false,
            false,
            false,
            true,
            ['loan' => $pr]
        );

    }
}

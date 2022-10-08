<?php

namespace App\Http\Controllers\Auth;

use App\Helper\CustomerSituationHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Helper\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\DocumentCategory;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\SendPasswordNotification;
use App\Notifications\Customer\UpdateStatusAccountNotification;
use App\Notifications\Customer\WelcomeNotification;
use App\Notifications\Testing\Customer\SendCreditCardCodeNotification;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\BankFintech;
use App\Services\Ovh;
use App\Services\PushbulletApi;
use App\Services\Stripe;
use App\Services\Twilio\Messaging\Whatsapp;
use App\Services\Twilio\Verify;
use App\Services\Yousign\Signature;
use App\Services\YousignApi;
use Authy\AuthyApi;
use IbanGenerator\Generator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RTippin\Messenger\Facades\Messenger;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('suivi');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function firstStep()
    {
        return view('auths.register.firstStep');
    }

    public function package(Request $request)
    {
        session()->put('customer_type', $request->get('customer_type'));

        return view('auths.register.package');
    }

    public function card(Request $request)
    {
        session()->put('package', Package::find($request->get('package')));

        return view('auths.register.card');
    }

    public function cart(Request $request)
    {
        session()->put('card', ['type' => $request->get('support'), 'debit' => $request->get('debit')]);

        if (session()->get('customer_type') == 'part') {
            return view('auths.register.perso_home');
        } else {
            return view('auths.register.pro_home');
        }
    }

    public function pro(Request $request)
    {
        session()->put('personnel', $request->except('_token'));

        return view('auths.register.perso_pro');
    }

    public function recap(Request $request)
    {
        //dd(session()->all());
        session()->put('pro', $request->except('_token'));

        return view('auths.register.perso_recap');
    }

    public function signate(Request $request)
    {
        if(session()->has('error')) {
            $user = User::find(session('user')['id']);
        } else {
            $user = $this->createUser($request->session()->get('personnel'));
            session()->put('user', $user);
            Messenger::getProviderMessenger($user);
        }

        $documents = $user->customers->documents()->where('document_category_id', 3)->where('signable', 1)->where('signed_by_client', 0)->get();

        $signables = [];
        $d = new DocumentFile();

        foreach ($documents as $document) {
            $call = $d->processSignableDocument($user->customers->id, 'gdd/' . $user->customers->id . '/3/' . $document->name . '.pdf', '1', 10, 30);
            $signables[$document->id] = [
                "url" => $call->signers[0]->signature_link . '&disable_domain_validation=true',
                "id" => $call->id
            ];
        }

        //dd($user->customers, $documents, $signables);

        return view('auths.register.perso_signate', [
            'customer' => $user->customers,
            'documents' => $documents,
            'signables' => $signables
        ])->with(['info' => "N'oubliez pas de vérifier le numéro de téléphone <strong>".$user->customers->info->mobile."</strong>: <a href='".route('auth.verify.view')."' target='_blank'>Vérifier mon téléphone</a>"]);

    }

    public function document(Request $request)
    {
        $api_signate = new Signature();
        $signates = (object)$request->get('signates');
        $documents = $request->get('document_id');

        //dd($signates, $documents, $request->all());
        $doc = CustomerDocument::find($documents[0]);

        // Vérification de la signature
        foreach ($signates as $signate) {
            if ($api_signate->fetch($signate)->status != 'done') {
                return redirect()->back()->with('errors', "Au moins un des documents n'à pas été signé !");
            }
        }

        // Update des documents
        foreach ($documents as $document) {
            CustomerDocument::find($document)->update([
                'signed_by_client' => 1,
                'signed_at' => now()
            ]);
        }

        return view('auths.register.perso_document', [
            'customer' => $doc->customer
        ]);

    }

    public function identity(Request $request)
    {
            $customer = Customer::find($request->get('customer_id'));

        if($request->has('action') && $request->get('action') == 'verifyIdentity') {
            if($request->get('amp;status') == 'success') {
                $customer = Customer::find($request->get('amp;customer_id'));
                $customer->info->verified();
                return view('auths.register.perso_identity', [
                    'customer' => $customer,
                    'verifyIdentity' => 'success'
                ]);
            } else {
                return view('auths.register.perso_identity', [
                    'customer' => $customer,
                    'verifyIdentity' => 'success'
                ]);
            }
        }

        return view('auths.register.perso_identity', [
            'customer' => $customer
        ]);
    }

    public function terminate(Request $request)
    {
        LogHelper::insertLogSystem('success', "Un nouveau client à terminé sont inscription", session('user'));
        return view('auths.register.perso_terminate', [
            'customer' => Customer::find($request->get('customer_id'))
        ]);
    }

    public function suivi(Request $request, Stripe $stripe)
    {
        if(auth()->check() == false) {
            return redirect()->route('login');
        } else {
            if($request->has('payment') && $request->get('payment') == 'success') {
                auth()->user()->customers->update([
                    'status_open_account' => 'completed'
                ]);

                $wallet = auth()->user()->customers->wallets()->first();
                if($wallet == null) {
                    $wallet = CustomerWalletHelper::createWallet(
                        auth()->user()->customers,
                        'compte',
                        20.00
                    );
                }

                $transaction = CustomerTransactionHelper::create('credit', 'depot', 'Dépot initial', 20, $wallet->id,
                    true, "Dépot initial à l'ouverture de votre compte", now(), null, null);
                LogHelper::notify('info', "
                    Un dépot d'ouverture de compte à été effectuer:<br>
                    Nom: auth()->user()->name<br>
                    Montant: 20,00 €<br>
                    Identifiant Customer: auth()->user()->customers->id
                ");

                auth()->user()->notify(new UpdateStatusAccountNotification(auth()->user()->customers, auth()->user()->customers->status_open_account));
                LogHelper::insertLogSystem('success', "Le status du compte d'un client est passé à ".auth()->user()->customers->status_open_account, auth()->user());
                return view('auths.register.suivi', [
                    'user' => \request()->user()
                ]);
            } else {
                try {
                    $intent = $stripe->client->paymentIntents->create([
                        'amount' => 2000,
                        'currency' => 'eur',
                        'payment_method_types' => [
                            'card',
                            'sepa_debit',
                        ],
                    ]);

                    return view('auths.register.suivi', [
                        'user' => \request()->user(),
                        'client_secret' => $intent->client_secret
                    ]);
                }catch (\Exception $exception) {
                    LogHelper::notify('critical', $exception->getMessage());
                    return $exception;
                }
            }
        }
    }

    private function createUser($request)
    {
        $password = \Str::random(10);
        $pushbullet = new PushbulletApi();
        $twilio = new Verify();

        $user = User::create([
            'name' => $request['firstname'] . ' ' . $request['lastname'],
            'email' => $request['email'],
            'password' => \Hash::make($password),
            'identifiant' => UserHelper::generateID(),
            'agency_id' => 1,
        ]);

        $iden = $pushbullet->createDevice($request['firstname'], $request['lastname']);


        $user->update([
            'pushbullet_device_id' => $iden->iden
        ]);
        session()->put('phone', $request['mobile']);
        $twilio->create($request['mobile']);

        $this->createCustomer(session(), $user, $password);



        return $user;
    }

    private function createCustomer($request, $user, $password)
    {
        $package = (object)$request->get('package');
        $card = (object)$request->get('card');
        $pro = (object)$request->get('pro');
        $personal = (object)$request->get('personnel');
        $code_auth = rand(1000, 9999);
        $bank = new BankFintech();
        $ficp = $bank->callInter();


        $customer = Customer::create([
            'status_open_account' => 'open',
            'auth_code' => base64_encode($code_auth),
            'user_id' => $user->id,
            'package_id' => $package->id,
            'agency_id' => $user->agency_id,
            'ficp' => $ficp->ficp ? 1 : 0,
            'fcc' => $ficp->fcc ? 1 : 0,
        ]);

        $info = CustomerInfo::create([
            'type' => 'part',
            'civility' => $personal->civility,
            'lastname' => $personal->lastname,
            'middlename' => $personal->middlename,
            'firstname' => $personal->firstname,
            'datebirth' => Carbon::createFromTimestamp(strtotime($personal->datebirth)),
            'citybirth' => $personal->citybirth,
            'countrybirth' => $personal->countrybirth,
            'address' => $personal->address,
            'addressbis' => $personal->addressbis,
            'postal' => $personal->postal,
            'city' => $personal->city,
            'country' => $personal->country,
            'phone' => $personal->phone,
            'mobile' => $personal->mobile,
            'country_code' => '+33',
            'customer_id' => $customer->id,
        ]);


        $setting = CustomerSetting::create([
            'customer_id' => $customer->id,
        ]);

        $situation = CustomerSituation::create([
            'legal_capacity' => $pro->legal_capacity,
            'family_situation' => $pro->family_situation,
            'logement' => $pro->logement,
            'logement_at' => $pro->logement_at,
            'child' => $pro->child,
            'person_charged' => $pro->person_charged,
            'pro_category' => $pro->pro_category,
            'pro_profession' => $pro->pro_profession,
            'customer_id' => $customer->id,
        ]);

        $income = CustomerSituationIncome::create([
            'pro_incoming' => $pro->pro_incoming,
            'patrimoine' => $pro->patrimoine,
            'customer_id' => $customer->id,
        ]);

        $charge = CustomerSituationCharge::create([
            'rent' => $pro->rent,
            'nb_credit' => $pro->nb_credit,
            'credit' => $pro->credit,
            'divers' => $pro->divers,
            'customer_id' => $customer->id,
        ]);

        $wallet = $this->createWallet($customer);
        $card = $this->createCreditCard($card, $wallet);

        switch ($package->name) {
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

                if ($request->has('decouvert')) {
                    $this->calcultateFacility($pro->pro_incoming, $customer, $wallet);
                }
                $this->defineDifferedAmount($pro->pro_incoming, $customer, $card);

        }

        // Envoie du mot de passe provisoire par SMS avec identifiant
        try {
            config('app.env') != 'local' ?
                $user->notify(new SendPasswordNotification($customer, $password)) :
                $user->notify(new \App\Notifications\Testing\Customer\SendPasswordNotification($customer, $password));

            config('app.env') == 'local' ? Whatsapp::sendNotification($customer->info->mobile, "Votre mot de passe provisoire est: $password") : null;
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
        }

        \Storage::disk('public')->makeDirectory('gdd/' . $customer->id);
        \Storage::disk('public')->makeDirectory('gdd/' . $customer->id . '/account');
        foreach (DocumentCategory::all() as $doc) {
            \Storage::disk('public')->makeDirectory('gdd/' . $customer->id . '/' . $doc->id);
        }

        /*
         * Création des documents usuel du comptes
         * - Convention de preuve
         * - Certification Fiscal
         * - Synthese echange
         * - Contrat Banque à distance
         * - Contrat Banque Souscription
         * - RIB
         */

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

        \Storage::disk('public')->copy('gdd/shared/info_tarif.pdf', 'gdd/' . $customer->id . '/5/info_tarif.pdf');

        $documents = [];

        $docs = $customer->documents()->where('document_category_id', 3)->get();
        foreach ($docs as $document) {
            $documents[] = [
                'url' => 'gdd/' . $customer->id . '/3/' . $document->name . '.pdf'
            ];
        }

        //dd($documents);

        // Notification mail de Bienvenue
        $user->notify(new WelcomeNotification($customer, $documents));

        return $customer;
    }

    private function createWallet($customer)
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

    private function createCreditCard($request, CustomerWallet $wallet)
    {
        $creditcard = new \Plansky\CreditCard\Generator();
        $card_number = $creditcard->single();
        $card_code = rand(1000, 9999);

        $card = \App\Models\Customer\CustomerCreditCard::create([
            'exp_month' => \Str::length(now()->month) <= 1 ? '0' . now()->month : now()->month,
            'number' => $card_number,
            'support' => $request->type,
            'debit' => $request->debit ? $request->debit : 'immediate',
            'cvc' => rand(100, 999),
            'code' => base64_encode($card_code),
            'limit_payment' => \App\Helper\CustomerCreditCard::calcLimitPayment(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
            'limit_retrait' => \App\Helper\CustomerCreditCard::calcLimitRetrait(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
            'customer_wallet_id' => $wallet->id,
        ]);

        // Envoie du code de la carte bleu par sms
        config('app.env') != 'local' ?
            $wallet->customer->user->notify(new \App\Notifications\Customer\SendCreditCardCodeNotification($card_code, $card)) :
            $wallet->customer->user->notify(new SendCreditCardCodeNotification($card_code, $card));

        config('app.env') == 'local' ? Whatsapp::sendNotification($card->wallet->customer->info->mobile, "Le code de votre carte bleu N°$card->number est le $card_code") : null;

        return $card;
    }

    private function calcultateFacility($incoming, Customer $customer, CustomerWallet $wallet)
    {
        $calc = $incoming / 3;
        if ($customer->ficp == 0) {
            if ($calc >= 300) {
                $result = $calc > 1000 ? 1000 : ceil($calc / 100) * 100;
                $wallet->update([
                    'decouvert' => 1,
                    'balance_decouvert' => $result,
                ]);
            }
        }
    }

    private function defineDifferedAmount($incoming, Customer $customer, \App\Models\Customer\CustomerCreditCard $card)
    {
        $calc = $incoming / 1.8;
        if ($customer->ficp == 0) {
            if ($calc >= 300) {
                $result = $calc > 10000 ? 10000 : ceil($calc / 100) * 100;
                $card->update([
                    'differed_limit' => $result,
                ]);
            }
        }
    }

}

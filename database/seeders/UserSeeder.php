<?php

namespace Database\Seeders;

use App\Helper\CustomerHelper;
use App\Helper\UserHelper;
use App\Models\Core\DocumentCategory;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
use App\Services\Stripe;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stripe = new Stripe();
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@fintech.io',
            'password' => \Hash::make('password'),
            'admin' => true,
            'agent' => false,
            'customer' => false,
            'identifiant' => UserHelper::generateID(),
        ]);

        User::create([
            'name' => 'Agent',
            'email' => 'agent@fintech.io',
            'password' => \Hash::make('password'),
            'admin' => false,
            'agent' => true,
            'customer' => false,
            'identifiant' => UserHelper::generateID(),
            'agency_id' => 2,
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@fintech.io',
            'password' => \Hash::make('password'),
            'admin' => false,
            'agent' => false,
            'customer' => true,
            'identifiant' => UserHelper::generateID(),
            'type_customer' => 'part'
        ]);

        User::create([
            'name' => "FINTECH DAB",
            'email' => 'dab@fintech.ovh',
            'password' => \Hash::make('password'),
            'customer' => false,
            'reseller' => true,
            'identifiant' => UserHelper::generateID()
        ]);

        $user->subscriptions()->create([
            'subscribe_type' => Package::class,
            'subscribe_id' => 3,
            'user_id' => $user->id
        ]);

        $customer = Customer::factory()->create([
            'status_open_account' => 'terminated',
            'package_id' => 3,
            'user_id' => $user->id
        ]);


        $info = CustomerInfo::factory()->create([
            'type' => 'part',
            'civility' => 'M',
            'firstname' => 'User',
            'lastname' => 'Demo',
            'isVerified' => true,
            'customer_id' => $customer->id,
            'email' => $user->email,
            'datebirth' => Carbon::create(rand(1980,2004), rand(1,12), rand(1,31)),
        ]);

        $info->setPhoneVerified($info->phone, 'phone');
        $info->setPhoneVerified($info->mobile, 'mobile');

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

        CustomerSetting::factory()->create([
            'notif_sms' => false,
            'notif_app' => true,
            'notif_mail' => true,
            'nb_physical_card' => 5,
            'nb_virtual_card' => 5,
            'check' => true,
            'customer_id' => $customer->id
        ]);

        User\UserNotificationSetting::create([
            'user_id' => $user->id
        ]);

        CustomerSituation::factory()->create([
            'customer_id' => $customer->id
        ]);
        CustomerSituationCharge::factory()->create([
            'customer_id' => $customer->id
        ]);
        CustomerSituationIncome::factory()->create([
            'customer_id' => $customer->id
        ]);

        $wallet = CustomerWallet::factory()->create([
            'customer_id' => $customer->id
        ]);
        $s_intent = $stripe->client->setupIntents->create([
            'customer' => $customer->stripe_customer_id,
            'payment_method_types' => ['card', 'sepa_debit'],
            'payment_method_data' => [
                'type' => 'sepa_debit',
                'sepa_debit' => [
                    'iban' => $wallet->iban
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

        $pm_stripe = $stripe->client->paymentMethods->create([
            'type' => "sepa_debit",
            'sepa_debit' => [
                'iban' => $wallet->iban
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
            'customer_wallet_id' => $wallet->id,
            'status' => 'active',
            'debit' => 'differed',
            'facelia' => false,
            'credit_card_support_id' => 1
        ]);


        $pm_stripe = $stripe->client->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'exp_year' => $card->exp_year,
                'exp_month' => $card->exp_month,
                'number' => $card->number,
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


        \Storage::disk('gdd')->makeDirectory($user->id . '/documents');
        \Storage::disk('gdd')->makeDirectory($user->id . '/account');
        foreach (DocumentCategory::all() as $doc) {
            \Storage::disk('gdd')->makeDirectory($user->id . '/documents/' . $doc->slug);
        }


    }
}

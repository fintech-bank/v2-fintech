<?php

namespace Database\Seeders;

use App\Helper\CustomerHelper;
use App\Helper\UserHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
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
        ]);

        $customer = Customer::factory()->create([
            'status_open_account' => 'terminated',
            'package_id' => 3,
            'user_id' => $user->id
        ]);

        CustomerInfo::factory()->create([
            'type' => 'part',
            'civility' => 'M',
            'firstname' => 'User',
            'lastname' => 'Demo',
            'isVerified' => true,
            'customer_id' => $customer->id
        ]);

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

        CustomerCreditCard::factory()->create([
            'customer_wallet_id' => $wallet->id,
            'status' => 'active',
            'support' => 'infinite',
            'debit' => 'differed',
            'facelia' => false
        ]);


    }
}

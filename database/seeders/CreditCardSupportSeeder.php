<?php

namespace Database\Seeders;

use App\Models\Core\CreditCardInsurance;
use App\Models\Core\CreditCardSupport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditCardSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CreditCardSupport::query()->create([
            'name' => "Visa Classic",
            'slug' => 'visa-classic',
            'type_customer' => 'part',
            'limit_retrait' => 450,
            'limit_payment' => 2500,
            'visa_spec' => true
        ])->insurance()->create([
            'insurance_sante' => true,
            'insurance_accident_travel' => true
        ]);

        CreditCardSupport::query()->create([
            'name' => "Visa Premium",
            'slug' => 'visa-premium',
            'type_customer' => 'part',
            'limit_retrait' => 1200,
            'limit_payment' => 4500,
            'visa_spec' => true
        ])->insurance()->create([
            'insurance_sante' => true,
            'insurance_accident_travel' => true,
            'trip_cancellation' => true,
            'civil_liability_abroad' => true,
            'cash_breakdown_abroad' => true,
            'guarantee_snow' => true,
            'guarantee_loan' => true,
            'guarantee_purchase' => true,
            'advantage' => true,
        ]);

        CreditCardSupport::query()->create([
            'name' => "Visa Infinite",
            'slug' => 'visa-infinite',
            'type_customer' => 'part',
            'limit_retrait' => 5000,
            'limit_payment' => 10000,
            'visa_spec' => true,
            'choice_code' => true
        ])->insurance()->create([
            'insurance_sante' => true,
            'insurance_accident_travel' => true,
            'trip_cancellation' => true,
            'civil_liability_abroad' => true,
            'cash_breakdown_abroad' => true,
            'guarantee_snow' => true,
            'guarantee_loan' => true,
            'guarantee_purchase' => true,
            'advantage' => true,
        ]);

        CreditCardSupport::query()->create([
            'name' => "Visa Business",
            'slug' => 'visa-business',
            'type_customer' => 'pro',
            'limit_retrait' => 1500,
            'limit_payment' => 10000,
            'visa_spec' => true,
            'choice_code' => false
        ])->insurance()->create([
            'insurance_sante' => true,
            'insurance_accident_travel' => true,
            'trip_cancellation' => true,
            'civil_liability_abroad' => true,
            'cash_breakdown_abroad' => true,
            'guarantee_snow' => true,
            'guarantee_loan' => true,
            'guarantee_purchase' => true,
            'advantage' => true,
            'business_travel' => true
        ]);

        CreditCardSupport::query()->create([
            'name' => "Visa Business Gold",
            'slug' => 'visa-business-gold',
            'type_customer' => 'pro',
            'limit_retrait' => 3000,
            'limit_payment' => 15000,
            'visa_spec' => true,
            'choice_code' => true
        ])->insurance()->create([
            'insurance_sante' => true,
            'insurance_accident_travel' => true,
            'trip_cancellation' => true,
            'civil_liability_abroad' => true,
            'cash_breakdown_abroad' => true,
            'guarantee_snow' => true,
            'guarantee_loan' => true,
            'guarantee_purchase' => true,
            'advantage' => true,
            'business_travel' => true
        ]);
    }
}

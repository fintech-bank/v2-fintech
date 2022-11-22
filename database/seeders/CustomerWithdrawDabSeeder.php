<?php

namespace Database\Seeders;

use App\Models\Core\Agency;
use App\Models\Customer\CustomerWithdrawDab;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerWithdrawDabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agency = Agency::first();
        $faker = Factory::create('fr_FR');
        CustomerWithdrawDab::create([
            'type' => 'dab',
            'name' => "FINTECH DAB",
            'address' => $agency->address,
            'postal' => $agency->postal,
            'city' => $agency->city,
            'latitude' => $faker->latitude,
            'longitude' => $faker->longitude,
            'phone' => $faker->e164PhoneNumber,
            'img' => $faker->imageUrl,
            'open' => true,
        ]);
    }
}

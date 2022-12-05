<?php

namespace Database\Seeders;

use App\Helper\UserHelper;
use App\Models\Core\Agency;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('fr_FR');
        Agency::create([
            'name' => 'FINTECH Bank',
            'bic' => 'FINFRPPXXX',
            'code_banque' => rand(10000, 99999),
            'code_agence' => rand(10000, 99999),
            'address' => '4 Rue du Coudray',
            'postal' => '44000',
            'city' => 'Nantes Cedex 4',
            'country' => 'FR',
            'online' => true,
            'phone' => '08 99 49 32 01',
        ]);

        Agency::create([
            'name' => 'FINTECH Bank Pays de la Loire',
            'bic' => 'FINFRPPNAN',
            'code_banque' => rand(10000, 99999),
            'code_agence' => rand(10000, 99999),
            'address' => '4 Rue du Coudray',
            'postal' => '44000',
            'city' => 'Nantes Cedex 4',
            'country' => 'FR',
            'online' => false,
            'phone' => '08 99 49 32 01',
        ]);

        foreach (Agency::all() as $agency) {
            $civility = ['M', "Mme", "Mlle"];
            $choice_civility = $civility[rand(0,2)];
            $firstname = $choice_civility == 'M' ? $faker->firstNameMale : $faker->firstNameFemale;
            $lastname = $faker->lastName;

            $user = User::create([
                'name' => $firstname." ".$lastname,
                'email' => $firstname.'.'.$lastname.'@fintech.ovh',
                'password' => \Hash::make('password'),
                'customer' => 0,
                'agent' => 1,
                'identifiant' => UserHelper::generateID(),
                'agency_id' => $agency->id
            ]);

            $agent = $agency->agents()->create([
                'civility' => $choice_civility,
                'firstname' => $choice_civility == 'M' ? $faker->firstNameMale : $faker->firstNameFemale,
                'lastname' => $faker->lastName,
                'agency_id' => $agency->id,
                'poste' => "Conseiller clientèle",
                'phone' => $faker->phoneNumber,
                'user_id' => $user->id
            ]);
        }
    }
}

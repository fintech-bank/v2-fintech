<?php

namespace Database\Seeders;

use App\Models\Insurance\InsuranceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsuranceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InsuranceType::create([
            'name' => 'Vehicules',
            'icon' => 'car-burst'
        ])->create([
            'name' => 'Habitation',
            'icon' => 'house-crack'
        ])->create([
            'name' => 'Risques & Aléas de la vie',
            'icon' => 'umbrella'
        ])->create([
            'name' => 'Décès & Dépendance',
            'icon' => 'wheelchair'
        ])->create([
            'name' => 'Santé',
            'icon' => 'heart-pulse'
        ]);
    }
}

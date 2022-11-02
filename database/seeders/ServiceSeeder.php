<?php

namespace Database\Seeders;

use App\Models\Core\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::query()->create([
            'name' => 'Abonnement Alerte PLUS',
            'price' => 2.90,
            'type_prlv' => 'mensual',
        ])->create([
            'name' => 'Tenue de Compte',
            'price' => 0,
            'type_prlv' => 'trim',
        ])->create([
            'name' => "Commission d'intervention",
            'price' => 2.50,
            'type_prlv' => 'ponctual',
        ])->create([
            'name' => 'Ouverture Livret A Supplémentaire',
            'price' => 15.00,
            'type_prlv' => 'ponctual',
        ])->create([
            'name' => 'Ouverture Livret LLDS Supplémentaire',
            'price' => 15.00,
            'type_prlv' => 'ponctual',
        ])->create([
            'name' => 'Carte Physique supplémentaire',
            'price' => 25.00,
            'type_prlv' => 'ponctual',
        ])->create([
            'name' => 'Carte Virtuel supplémentaire',
            'price' => 10.00,
            'type_prlv' => 'ponctual',
        ])->create([
            'name' => 'TPE Distributeur',
            'price' => 0.00,
            'type_prlv' => 'mensual',
        ])->create([
            'name' => 'Changement Code Carte Bancaire',
            'price' => 0.30,
            'type_prlv' => 'ponctual',
        ])->create([
            'name' => 'Choisir Code Secret',
            'price' => 0.00,
            'type_prlv' => 'mensual',
        ])->create([
            'name' => 'Assurance Au Quotidien',
            'price' => 24.00,
            'type_prlv' => 'annual',
        ])->create([
            'name' => 'Retraits DAB illimités',
            'price' => 2,
            'type_prlv' => 'mensual',
        ])->create([
            'name' => 'Service E-carte Bleu',
            'price' => 12,
            'type_prlv' => 'annual',
        ]);
    }
}

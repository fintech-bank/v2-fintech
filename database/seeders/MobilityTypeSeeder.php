<?php

namespace Database\Seeders;

use App\Models\Core\MobilityType;
use Illuminate\Database\Seeder;

class MobilityTypeSeeder extends Seeder
{
    public function run()
    {
        MobilityType::create([
            'name' => "Transfert Global",
            'description' => "Transférez toutes vos opérations vers votre compte principal",
            "contact_banque" => true,
            "liste_mvm" => true,
            "select_mvm" => false,
            "transmission_rib_orga" => true,
            "cloture" => true
        ]);

        MobilityType::create([
            'name' => "Transfert Sur-Mesure",
            'description' => "Choisissez les opérations à transférer vers votre compte Société Générale",
            "contact_banque" => true,
            "liste_mvm" => true,
            "select_mvm" => true,
            "transmission_rib_orga" => true,
            "cloture" => false
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Insurance\InsurancePackageWarranty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsurancePackageWarrantySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 1,
            'designation' => 'Responsabilité Civile, Défense Pénale et Recours suite à accident',
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => 'Protection du conducteur jusqu’à 400 000 €',
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => 'Protection du conducteur renforcée : jusqu’à 1 million d’euros',
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => 'Bris de glaces et catastrophes naturelles et technologies',
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => 'Vol, incendies et événements naturels',
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => 'Dommages tous accidents dont vandalisme',
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => "Indemnisation renforcée : valeur à neuf jusqu'à 36 mois",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => "Contenu du véhicule",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => "Assistance aux véhicules (accident 0 km et panne 25 km)",
            'check' => true,
            'price' => 3.33
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => "Assistance Renforcée : 0 km panne ou accident et véhicule de remplacement",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => "Remise à la route rapide (- de 2hrs) et service « voiture à domicile »",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => "Minimum d’indemnisation de 1 200 €",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 1,
            'designation' => "Plus tranquillité bancaire (nombre de mensualités)",
            'check' => true,
            'price' => 0,
            'count' => 1
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 2,
            'designation' => 'Responsabilité Civile, Défense Pénale et Recours suite à accident',
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => 'Protection du conducteur jusqu’à 400 000 €',
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => 'Protection du conducteur renforcée : jusqu’à 1 million d’euros',
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => 'Bris de glaces et catastrophes naturelles et technologies',
            'check' => true,
            'price' => 4.36
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => 'Vol, incendies et événements naturels',
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => 'Dommages tous accidents dont vandalisme',
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => "Indemnisation renforcée : valeur à neuf jusqu'à 36 mois",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => "Contenu du véhicule",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => "Assistance aux véhicules (accident 0 km et panne 25 km)",
            'check' => true,
            'price' => 3.33
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => "Assistance Renforcée : 0 km panne ou accident et véhicule de remplacement",
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => "Remise à la route rapide (- de 2hrs) et service « voiture à domicile »",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => "Minimum d’indemnisation de 1 200 €",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 2,
            'designation' => "Plus tranquillité bancaire (nombre de mensualités)",
            'check' => true,
            'price' => 0,
            'count' => 2
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 3,
            'designation' => 'Responsabilité Civile, Défense Pénale et Recours suite à accident',
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => 'Protection du conducteur jusqu’à 400 000 €',
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => 'Protection du conducteur renforcée : jusqu’à 1 million d’euros',
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => 'Bris de glaces et catastrophes naturelles et technologies',
            'check' => true,
            'price' => 4.30
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => 'Vol, incendies et événements naturels',
            'check' => true,
            'price' => 3.96
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => 'Dommages tous accidents dont vandalisme',
            'check' => true,
            'price' => 1.20
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => "Indemnisation renforcée : valeur à neuf jusqu'à 36 mois",
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => "Contenu du véhicule",
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => "Assistance aux véhicules (accident 0 km et panne 25 km)",
            'check' => true,
            'price' => 3.33
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => "Assistance Renforcée : 0 km panne ou accident et véhicule de remplacement",
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => "Remise à la route rapide (- de 2hrs) et service « voiture à domicile »",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => "Minimum d’indemnisation de 1 200 €",
            'check' => true,
            'price' => 4.20
        ])->create([
            'insurance_package_form_id' => 3,
            'designation' => "Plus tranquillité bancaire (nombre de mensualités)",
            'check' => true,
            'price' => 0,
            'count' => 6
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 4,
            'designation' => 'Responsabilité Civile, Défense Pénale et Recours suite à accident',
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => 'Protection du conducteur jusqu’à 400 000 €',
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => 'Protection du conducteur renforcée : jusqu’à 1 million d’euros',
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => 'Bris de glaces et catastrophes naturelles et technologies',
            'check' => true,
            'price' => 4.30
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => 'Vol, incendies et événements naturels',
            'check' => true,
            'price' => 3.96
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => 'Dommages tous accidents dont vandalisme',
            'check' => true,
            'price' => 1.20
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => "Indemnisation renforcée : valeur à neuf jusqu'à 36 mois",
            'check' => true,
            'price' => 3.20
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => "Contenu du véhicule",
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => "Assistance aux véhicules (accident 0 km et panne 25 km)",
            'check' => true,
            'price' => 3.33
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => "Assistance Renforcée : 0 km panne ou accident et véhicule de remplacement",
            'check' => true,
            'price' => 2.63
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => "Remise à la route rapide (- de 2hrs) et service « voiture à domicile »",
            'check' => true,
            'price' => 1.63
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => "Minimum d’indemnisation de 1 200 €",
            'check' => true,
            'price' => 4.20
        ])->create([
            'insurance_package_form_id' => 4,
            'designation' => "Plus tranquillité bancaire (nombre de mensualités)",
            'check' => true,
            'price' => 0,
            'count' => 6
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 5,
            'designation' => 'Responsabilité Civile, Défense Pénale et Recours suite à accident',
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => 'Protection du conducteur jusqu’à 400 000 €',
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => 'Protection du conducteur renforcée : jusqu’à 1 million d’euros',
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => 'Bris de glaces et catastrophes naturelles et technologies',
            'check' => true,
            'price' => 4.30
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => 'Vol, incendies et événements naturels',
            'check' => true,
            'price' => 3.96
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => 'Dommages tous accidents dont vandalisme',
            'check' => true,
            'price' => 1.20
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => "Indemnisation renforcée : valeur à neuf jusqu'à 36 mois",
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => "Contenu du véhicule",
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => "Assistance aux véhicules (accident 0 km et panne 25 km)",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => "Assistance Renforcée : 0 km panne ou accident et véhicule de remplacement",
            'check' => true,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => "Remise à la route rapide (- de 2hrs) et service « voiture à domicile »",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => "Minimum d’indemnisation de 1 200 €",
            'check' => true,
            'price' => 4.20
        ])->create([
            'insurance_package_form_id' => 5,
            'designation' => "Plus tranquillité bancaire (nombre de mensualités)",
            'check' => false,
            'price' => 0,
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 6,
            'designation' => "Une couverture au tiers qui répond à vos obligations d'assurance en cas de dommages causés aux autres",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 6,
            'designation' => "l'assistance 0 km même en cas de panne ou de vol",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 6,
            'designation' => "protection du conducteur et le remboursement de votre cotisation en cas d’accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 6,
            'designation' => "Assurance du véhicule contre certains dommages (incendie, vol, accident de la circulation)",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 6,
            'designation' => "Indemnisation du vehicule si volé dans les 6 mois",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 6,
            'designation' => "Assurée contre le vandalisme",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 6,
            'designation' => "Vehicule de remplacement en cas de sinistre",
            'check' => false,
            'price' => 0
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 7,
            'designation' => "Une couverture au tiers qui répond à vos obligations d'assurance en cas de dommages causés aux autres",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 7,
            'designation' => "l'assistance 0 km même en cas de panne ou de vol",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 7,
            'designation' => "protection du conducteur et le remboursement de votre cotisation en cas d’accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 7,
            'designation' => "Assurance du véhicule contre certains dommages (incendie, vol, accident de la circulation)",
            'check' => true,
            'price' => 3.52
        ])->create([
            'insurance_package_form_id' => 7,
            'designation' => "Indemnisation du vehicule si volé dans les 6 mois",
            'check' => true,
            'price' => 3.96
        ])->create([
            'insurance_package_form_id' => 7,
            'designation' => "Assurée contre le vandalisme",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 7,
            'designation' => "Vehicule de remplacement en cas de sinistre",
            'check' => false,
            'price' => 0
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 8,
            'designation' => "Une couverture au tiers qui répond à vos obligations d'assurance en cas de dommages causés aux autres",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 8,
            'designation' => "l'assistance 0 km même en cas de panne ou de vol",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 8,
            'designation' => "protection du conducteur et le remboursement de votre cotisation en cas d’accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 8,
            'designation' => "Assurance du véhicule contre certains dommages (incendie, vol, accident de la circulation)",
            'check' => true,
            'price' => 3.52
        ])->create([
            'insurance_package_form_id' => 8,
            'designation' => "Indemnisation du vehicule si volé dans les 6 mois",
            'check' => true,
            'price' => 3.96
        ])->create([
            'insurance_package_form_id' => 8,
            'designation' => "Assurée contre le vandalisme",
            'check' => true,
            'price' => 4.52
        ])->create([
            'insurance_package_form_id' => 8,
            'designation' => "Vehicule de remplacement en cas de sinistre",
            'check' => true,
            'price' => 6.36
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 9,
            'designation' => "Vol, incendies et événements naturels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Incendie & dégât des eaux et gel",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Tempête, grêle et neige",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Catastrophes naturelles et actes de terrorisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Défense Pénale et Recours suite à Accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Objets usuels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Vol et détériorations suite à vol et vandalisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Bris de glaces",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Objets de valeur",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Dommages électriques et valeur à neuf jusqu’à 2 ans",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Assistance au quotidien",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Assistance électro-ménager, HI-FI, TV et informatique",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Dommages corporels",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Protection des panneaux solaires, photovoltaïques, installations de géothermie, éoliennes, récupérateurs d'eau de pluie.",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Garantie réparation des appareils électroménagers, hi-fi et informatiques",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 9,
            'designation' => "Garantie Services Experts",
            'check' => false,
            'price' => 0
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 10,
            'designation' => "Vol, incendies et événements naturels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Incendie & dégât des eaux et gel",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Tempête, grêle et neige",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Catastrophes naturelles et actes de terrorisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Défense Pénale et Recours suite à Accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Objets usuels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Vol et détériorations suite à vol et vandalisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Bris de glaces",
            'check' => true,
            'price' => 3.32
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Objets de valeur",
            'check' => true,
            'price' => 4.52
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Dommages électriques et valeur à neuf jusqu’à 2 ans",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Assistance au quotidien",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Assistance électro-ménager, HI-FI, TV et informatique",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Dommages corporels",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Protection des panneaux solaires, photovoltaïques, installations de géothermie, éoliennes, récupérateurs d'eau de pluie.",
            'check' => true,
            'price' => 6.32
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Garantie réparation des appareils électroménagers, hi-fi et informatiques",
            'check' => false,
            'price' => 0
        ])->create([
            'insurance_package_form_id' => 10,
            'designation' => "Garantie Services Experts",
            'check' => false,
            'price' => 0
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 11,
            'designation' => "Vol, incendies et événements naturels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Incendie & dégât des eaux et gel",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Tempête, grêle et neige",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Catastrophes naturelles et actes de terrorisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Défense Pénale et Recours suite à Accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Objets usuels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Vol et détériorations suite à vol et vandalisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Bris de glaces",
            'check' => true,
            'price' => 3.32
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Objets de valeur",
            'check' => true,
            'price' => 4.52
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Dommages électriques et valeur à neuf jusqu’à 2 ans",
            'check' => true,
            'price' => 6.36
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Assistance au quotidien",
            'check' => true,
            'price' => 5.96
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Assistance électro-ménager, HI-FI, TV et informatique",
            'check' => true,
            'price' => 3.20
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Dommages corporels",
            'check' => true,
            'price' => 1.25
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Protection des panneaux solaires, photovoltaïques, installations de géothermie, éoliennes, récupérateurs d'eau de pluie.",
            'check' => true,
            'price' => 6.32
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Garantie réparation des appareils électroménagers, hi-fi et informatiques",
            'check' => true,
            'price' => 4.32
        ])->create([
            'insurance_package_form_id' => 11,
            'designation' => "Garantie Services Experts",
            'check' => true,
            'price' => 9.30
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 12,
            'designation' => "Vol, incendies et événements naturels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Incendie & dégât des eaux et gel",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Tempête, grêle et neige",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Catastrophes naturelles et actes de terrorisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Défense Pénale et Recours suite à Accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Objets usuels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Vol et détériorations suite à vol et vandalisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Bris de glaces",
            'check' => true,
            'price' => 3.32
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Objets de valeur",
            'check' => true,
            'price' => 4.52
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Dommages électriques et valeur à neuf jusqu’à 2 ans",
            'check' => true,
            'price' => 6.36
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Assistance au quotidien",
            'check' => false,
            'price' => 5.96
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Assistance électro-ménager, HI-FI, TV et informatique",
            'check' => false,
            'price' => 3.20
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Dommages corporels",
            'check' => false,
            'price' => 1.25
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Protection des panneaux solaires, photovoltaïques, installations de géothermie, éoliennes, récupérateurs d'eau de pluie.",
            'check' => false,
            'price' => 6.32
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Garantie réparation des appareils électroménagers, hi-fi et informatiques",
            'check' => false,
            'price' => 4.32
        ])->create([
            'insurance_package_form_id' => 12,
            'designation' => "Garantie Services Experts",
            'check' => false,
            'price' => 9.30
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 13,
            'designation' => "Vol, incendies et événements naturels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Incendie & dégât des eaux et gel",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Tempête, grêle et neige",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Catastrophes naturelles et actes de terrorisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Défense Pénale et Recours suite à Accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Objets usuels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Vol et détériorations suite à vol et vandalisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Bris de glaces",
            'check' => true,
            'price' => 3.32
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Objets de valeur",
            'check' => true,
            'price' => 4.52
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Dommages électriques et valeur à neuf jusqu’à 2 ans",
            'check' => true,
            'price' => 6.36
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Assistance au quotidien",
            'check' => false,
            'price' => 5.96
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Assistance électro-ménager, HI-FI, TV et informatique",
            'check' => false,
            'price' => 3.20
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Dommages corporels",
            'check' => false,
            'price' => 1.25
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Protection des panneaux solaires, photovoltaïques, installations de géothermie, éoliennes, récupérateurs d'eau de pluie.",
            'check' => false,
            'price' => 6.32
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Garantie réparation des appareils électroménagers, hi-fi et informatiques",
            'check' => false,
            'price' => 4.32
        ])->create([
            'insurance_package_form_id' => 13,
            'designation' => "Garantie Services Experts",
            'check' => false,
            'price' => 9.30
        ]);
        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 14,
            'designation' => "Vol, incendies et événements naturels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Incendie & dégât des eaux et gel",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Tempête, grêle et neige",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Catastrophes naturelles et actes de terrorisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Défense Pénale et Recours suite à Accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Objets usuels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Vol et détériorations suite à vol et vandalisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Bris de glaces",
            'check' => true,
            'price' => 3.32
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Objets de valeur",
            'check' => true,
            'price' => 4.52
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Dommages électriques et valeur à neuf jusqu’à 2 ans",
            'check' => true,
            'price' => 6.36
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Assistance au quotidien",
            'check' => false,
            'price' => 5.96
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Assistance électro-ménager, HI-FI, TV et informatique",
            'check' => false,
            'price' => 3.20
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Dommages corporels",
            'check' => false,
            'price' => 1.25
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Protection des panneaux solaires, photovoltaïques, installations de géothermie, éoliennes, récupérateurs d'eau de pluie.",
            'check' => false,
            'price' => 6.32
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Garantie réparation des appareils électroménagers, hi-fi et informatiques",
            'check' => false,
            'price' => 4.32
        ])->create([
            'insurance_package_form_id' => 14,
            'designation' => "Garantie Services Experts",
            'check' => false,
            'price' => 9.30
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 15,
            'designation' => "Vol, incendies et événements naturels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Incendie & dégât des eaux et gel",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Tempête, grêle et neige",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Catastrophes naturelles et actes de terrorisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Défense Pénale et Recours suite à Accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Objets usuels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Vol et détériorations suite à vol et vandalisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Bris de glaces",
            'check' => true,
            'price' => 3.32
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Objets de valeur",
            'check' => true,
            'price' => 4.52
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Dommages électriques et valeur à neuf jusqu’à 2 ans",
            'check' => true,
            'price' => 6.36
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Assistance au quotidien",
            'check' => false,
            'price' => 5.96
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Assistance électro-ménager, HI-FI, TV et informatique",
            'check' => false,
            'price' => 3.20
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Dommages corporels",
            'check' => false,
            'price' => 1.25
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Protection des panneaux solaires, photovoltaïques, installations de géothermie, éoliennes, récupérateurs d'eau de pluie.",
            'check' => false,
            'price' => 6.32
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Garantie réparation des appareils électroménagers, hi-fi et informatiques",
            'check' => false,
            'price' => 4.32
        ])->create([
            'insurance_package_form_id' => 15,
            'designation' => "Garantie Services Experts",
            'check' => false,
            'price' => 9.30
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 16,
            'designation' => "Vol, incendies et événements naturels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Incendie & dégât des eaux et gel",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Tempête, grêle et neige",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Catastrophes naturelles et actes de terrorisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Défense Pénale et Recours suite à Accident",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Objets usuels",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Vol et détériorations suite à vol et vandalisme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Bris de glaces",
            'check' => false,
            'price' => 3.32
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Objets de valeur",
            'check' => false,
            'price' => 4.52
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Dommages électriques et valeur à neuf jusqu’à 2 ans",
            'check' => false,
            'price' => 6.36
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Assistance au quotidien",
            'check' => false,
            'price' => 5.96
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Assistance électro-ménager, HI-FI, TV et informatique",
            'check' => false,
            'price' => 3.20
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Dommages corporels",
            'check' => false,
            'price' => 1.25
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Protection des panneaux solaires, photovoltaïques, installations de géothermie, éoliennes, récupérateurs d'eau de pluie.",
            'check' => false,
            'price' => 6.32
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Garantie réparation des appareils électroménagers, hi-fi et informatiques",
            'check' => false,
            'price' => 4.32
        ])->create([
            'insurance_package_form_id' => 16,
            'designation' => "Garantie Services Experts",
            'check' => false,
            'price' => 9.30
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 17,
            'designation' => "Mise à disposition d’un système d’alarme connecté, maintenance incluse",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 17,
            'designation' => "Télésurveillance 24h/24 et 7j/7",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 17,
            'designation' => "Pilotage à distance via l’application mobile ou l’espace abonné Homiris",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 17,
            'designation' => "Information de l’abonné en cas d’alarme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 17,
            'designation' => "Intervention d’un agent de sécurité et appel des forces de l’ordre si nécessaire",
            'check' => false,
            'price' => 4.69
        ])->create([
            'insurance_package_form_id' => 17,
            'designation' => "Organisation des mesures de sauvegarde du domicile si nécessaire",
            'check' => false,
            'price' => 3.33
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 18,
            'designation' => "Mise à disposition d’un système d’alarme connecté, maintenance incluse",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 18,
            'designation' => "Télésurveillance 24h/24 et 7j/7",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 18,
            'designation' => "Pilotage à distance via l’application mobile ou l’espace abonné Homiris",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 18,
            'designation' => "Information de l’abonné en cas d’alarme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 18,
            'designation' => "Intervention d’un agent de sécurité et appel des forces de l’ordre si nécessaire",
            'check' => true,
            'price' => 4.69
        ])->create([
            'insurance_package_form_id' => 18,
            'designation' => "Organisation des mesures de sauvegarde du domicile si nécessaire",
            'check' => true,
            'price' => 3.33
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 19,
            'designation' => "Mise à disposition d’un système d’alarme connecté, maintenance incluse",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 19,
            'designation' => "Télésurveillance 24h/24 et 7j/7",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 19,
            'designation' => "Pilotage à distance via l’application mobile ou l’espace abonné Homiris",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 19,
            'designation' => "Information de l’abonné en cas d’alarme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 19,
            'designation' => "Intervention d’un agent de sécurité et appel des forces de l’ordre si nécessaire",
            'check' => false,
            'price' => 4.69
        ])->create([
            'insurance_package_form_id' => 19,
            'designation' => "Organisation des mesures de sauvegarde du domicile si nécessaire",
            'check' => false,
            'price' => 3.33
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 20,
            'designation' => "Mise à disposition d’un système d’alarme connecté, maintenance incluse",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 20,
            'designation' => "Télésurveillance 24h/24 et 7j/7",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 20,
            'designation' => "Pilotage à distance via l’application mobile ou l’espace abonné Homiris",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 20,
            'designation' => "Information de l’abonné en cas d’alarme",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 20,
            'designation' => "Intervention d’un agent de sécurité et appel des forces de l’ordre si nécessaire",
            'check' => true,
            'price' => 4.69
        ])->create([
            'insurance_package_form_id' => 20,
            'designation' => "Organisation des mesures de sauvegarde du domicile si nécessaire",
            'check' => true,
            'price' => 3.33
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 21,
            'designation' => "Assurance des Loyers Impayés",
            'check' => true,
            'price' => 0,
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 22,
            'designation' => "Accidents de la vie privée",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 22,
            'designation' => "Accidents médicaux",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 22,
            'designation' => "Accidents dus à des attentats ou à des infractions",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 22,
            'designation' => "Accidents de circulation survenus dans le cadre de votre vie privée, en qualité de piéton et de cycliste",
            'check' => false,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 22,
            'designation' => "Forfait Hospitalisation 30 €/nuit d'hospitalisation limité à 30 nuits",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 22,
            'designation' => "Forfait arrêt de travail 30 €/jour Limité à 60 jours",
            'check' => true,
            'price' => 2.69
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 23,
            'designation' => "Accidents de la vie privée",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 23,
            'designation' => "Accidents médicaux",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 23,
            'designation' => "Accidents dus à des attentats ou à des infractions",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 23,
            'designation' => "Accidents de circulation survenus dans le cadre de votre vie privée, en qualité de piéton et de cycliste",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 23,
            'designation' => "Forfait Hospitalisation 60 €/nuit d'hospitalisation limité à 30 nuits",
            'check' => true,
            'price' => 2.69
        ])->create([
            'insurance_package_form_id' => 23,
            'designation' => "Forfait arrêt de travail 60 €/jour Limité à 60 jours",
            'check' => true,
            'price' => 2.69
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 24,
            'designation' => "vol, bris toutes causes et oxydation",
            'check' => true,
            'price' => 6.52,
            'condition' => 'Un maximum de 400 € par sinistre et de 2 sinistres par an et par foyer.<br>Bénéficiez d’un appareil de remplacement (30 jours maximum) durant la période du sinistre.'
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 25,
            'designation' => "Indemnisation personnalisée",
            'check' => true,
            'price' => 0,
            'condition' => 'La cotisation est calculée à partir du montant de l’indemnité choisi. De 150€ à 1500€ Maximum'
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 32,
            'designation' => "Palier de 3 000 à 10 000 € (paliers de 500 €)",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 32,
            'designation' => "Le capital est acquis définitivement dès l'adhésion et garanti à vie",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 32,
            'designation' => "Assistance téléphonique",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 32,
            'designation' => "Assistance psychologique",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 32,
            'designation' => "Rapatriement du corps",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 32,
            'designation' => "Possibilité de modifier(1) le capital, la formule, le bénéficiaire, la fréquence de paiement des cotisations",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 32,
            'designation' => "Recueil des volontés essentielles",
            'check' => false,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 32,
            'designation' => "Choix des prestations obsèques",
            'check' => false,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 32,
            'designation' => "Choix des prestataires obsèques",
            'check' => false,
            'price' => 3.36,
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 33,
            'designation' => "Palier de 3 000 à 10 000 € (paliers de 500 €)",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 33,
            'designation' => "Le capital est acquis définitivement dès l'adhésion et garanti à vie",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 33,
            'designation' => "Assistance téléphonique",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 33,
            'designation' => "Assistance psychologique",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 33,
            'designation' => "Rapatriement du corps",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 33,
            'designation' => "Possibilité de modifier(1) le capital, la formule, le bénéficiaire, la fréquence de paiement des cotisations",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 33,
            'designation' => "Recueil des volontés essentielles",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 33,
            'designation' => "Choix des prestations obsèques",
            'check' => false,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 33,
            'designation' => "Choix des prestataires obsèques",
            'check' => false,
            'price' => 3.36,
        ]);

        InsurancePackageWarranty::query()->create([
            'insurance_package_form_id' => 34,
            'designation' => "Palier de 3 000 à 10 000 € (paliers de 500 €)",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 34,
            'designation' => "Le capital est acquis définitivement dès l'adhésion et garanti à vie",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 34,
            'designation' => "Assistance téléphonique",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 34,
            'designation' => "Assistance psychologique",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 34,
            'designation' => "Rapatriement du corps",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 34,
            'designation' => "Possibilité de modifier(1) le capital, la formule, le bénéficiaire, la fréquence de paiement des cotisations",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 34,
            'designation' => "Recueil des volontés essentielles",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 34,
            'designation' => "Choix des prestations obsèques",
            'check' => true,
            'price' => 3.36,
        ])->create([
            'insurance_package_form_id' => 34,
            'designation' => "Choix des prestataires obsèques",
            'check' => true,
            'price' => 3.36,
        ]);
    }
}

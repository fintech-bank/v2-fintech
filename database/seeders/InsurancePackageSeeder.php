<?php

namespace Database\Seeders;

use App\Models\Insurance\InsurancePackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsurancePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InsurancePackage::query()->create([
            'insurance_type_id' => 1,
            'name' => 'Assurance Auto',
            'slug' => "auto-insurance",
            'synopsis' => "La nouvelle assurance auto vous propose 5 formules avec des options à la carte pour un tarif qui s'adapte à vos besoins. A partir de 14,50 €/mois.",
        ])->create([
            'insurance_type_id' => 1,
            'name' => 'Assurance Moto & Scooter',
            'slug' => "moto-insurance",
            'synopsis' => "Assurez votre 2 roues et bénéficiez d’une assistance 0 km même en cas de panne ou de vol.",
        ]);

        InsurancePackage::query()->create([
            'insurance_type_id' => 2,
            'name' => 'Assurance Habitation',
            'slug' => "hab-insurance",
            'synopsis' => "A partir de 7€/mois. Bénéficiez de garanties complètes, étendues et modulables et des avantages exclusifs pour nos clients. Réalisez votre devis et souscrivez directement en ligne, sans justificatif.",
        ])->create([
            'insurance_type_id' => 2,
            'name' => 'Assurance Habitation Etudiant',
            'slug' => "hab-etudiant-insurance",
            'synopsis' => "Seulement 3,73€/mois pour une chambre, 5,55€/mois pour un studio et 7,83€/mois pour un 2 pièces. Des garanties essentielles pour assurer le quotidien des étudiants. Souscrivez directement en ligne, sans justificatif.",
        ])->create([
            'insurance_type_id' => 2,
            'name' => 'Propriétaire non occupants & Bailleurs',
            'slug' => "hab-prop-insurance",
            'synopsis' => "Un contrat d’assurance habitation spécifiquement conçu pour les propriétaires non occupants.",
        ])->create([
            'insurance_type_id' => 2,
            'name' => 'Télésurveillance du domicile',
            'slug' => "telesurveillance",
            'synopsis' => "Les formules de télésurveillance Détection et Détection + comprennent un système d’alarme et une surveillance à distance pour protéger votre logement.",
        ])->create([
            'insurance_type_id' => 2,
            'name' => 'Assurance des Loyers Impayés',
            'slug' => "paid-insurance",
            'synopsis' => "Vous protéger des risques de non-paiement de vos locataires. Déduire vos cotisations de vos revenus fonciers.",
        ]);

        InsurancePackage::query()->create([
            'insurance_type_id' => 3,
            'name' => 'Assurance Accident de la vie',
            'slug' => "life-accident-insurance",
            'synopsis' => "Garanties financières et assistance : l'Assurance Accidents de la Vie couvre spécifiquement les accidents du quotidien.",
        ])->create([
            'insurance_type_id' => 3,
            'name' => 'Mon Assurance Mobile',
            'slug' => "mobile-insurance",
            'synopsis' => "Bris, vol, oxydation : protégez les téléphones mobiles et les tablettes de toute la famille, et assurez-vous d’être toujours équipé.",
        ])->create([
            'insurance_type_id' => 3,
            'name' => 'Garantie de salaire',
            'slug' => "salary-insurance",
            'synopsis' => "Recevez 150 à 1 500 € par mois pour faire face à une perte de revenus.",
        ])->create([
            'insurance_type_id' => 3,
            'name' => 'Mon assurance au quotidien',
            'slug' => "today-insurance",
            'synopsis' => "Protégez vos moyens de paiements et vos objets du quotidien.",
        ])->create([
            'insurance_type_id' => 3,
            'name' => 'Protection Juridique',
            'slug' => "juris-insurance",
            'synopsis' => "Vous faire accompagner par des juristes en cas de litige.",
        ]);

        InsurancePackage::query()->create([
            'insurance_type_id' => 4,
            'name' => 'Assurance décès Généa',
            'slug' => "genea-dead-insurance",
            'synopsis' => "Verser un capital à ses proches en cas de décès ou à l’assuré en cas de perte totale et irréversible d’autonomie.",
        ])->create([
            'insurance_type_id' => 4,
            'name' => 'Garantie Autonomie Sénior',
            'slug' => "senior-warranty-insurance",
            'synopsis' => "Anticipez la perte d’autonomie et bénéficiez d’une rente viagère et de prestations d’assistance.",
        ])->create([
            'insurance_type_id' => 4,
            'name' => 'Garantie Autonomie Aidant',
            'slug' => "aidant-warranty-insurance",
            'synopsis' => "Bénéficiez d’un accompagnement dans votre rôle d’aidant.",
        ])->create([
            'insurance_type_id' => 4,
            'name' => 'Assurance Garantie Obsèque',
            'slug' => "funeral-warranty-insurance",
            'synopsis' => "Préparez le financement de vos obsèques en constituant dès aujourd'hui un capital garanti et prévoyez une assistance pour vos proches.",
        ]);

        InsurancePackage::query()->create([
            'insurance_type_id' => 5,
            'name' => 'Complémentaire santé',
            'slug' => "complementary-health-insurance",
            'synopsis' => "Couverture adaptée à vos besoins et à votre budget. 4 formules au choix et 5 renforts en option. À partir de 15,12 euros par mois.",
        ]);
    }
}

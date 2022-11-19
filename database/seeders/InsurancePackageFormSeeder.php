<?php

namespace Database\Seeders;

use App\Models\Insurance\InsurancePackageForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsurancePackageFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InsurancePackageForm::query()->create([
            'insurance_package_id' => 1,
            'name' => 'Tiers',
            'typed_price' => 5
        ])->create([
            'insurance_package_id' => 1,
            'name' => 'Tiers +',
            'typed_price' => 7.50
        ])->create([
            'insurance_package_id' => 1,
            'name' => 'Tous risques',
            'typed_price' => 9.90
        ])->create([
            'insurance_package_id' => 1,
            'name' => 'Tous risques +',
            'typed_price' => 14.90
        ])->create([
            'insurance_package_id' => 1,
            'name' => 'Leasing',
            'typed_price' => 10.90
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 2,
            'name' => 'Indispensable',
            'typed_price' => 4.90
        ])->create([
            'insurance_package_id' => 2,
            'name' => 'Renforcée',
            'typed_price' => 9.90
        ])->create([
            'insurance_package_id' => 2,
            'name' => 'Tous risques',
            'typed_price' => 14.90
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 3,
            'name' => 'Initial',
            'typed_price' => 7.50
        ])->create([
            'insurance_package_id' => 3,
            'name' => 'Confort',
            'typed_price' => 13.30
        ])->create([
            'insurance_package_id' => 3,
            'name' => 'Optimale',
            'typed_price' => 25.90
        ])->create([
            'insurance_package_id' => 3,
            'name' => 'Initial',
            'typed_price' => 7.50
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 4,
            'name' => 'Chambre d’étudiant',
            'typed_price' => 3.73
        ])->create([
            'insurance_package_id' => 4,
            'name' => 'Studio d’une pièce',
            'typed_price' => 5.55
        ])->create([
            'insurance_package_id' => 4,
            'name' => 'Appartement 2 pièces',
            'typed_price' => 7.83
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 5,
            'name' => 'Propriétaire non occupant',
            'typed_price' => 7.70
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 6,
            'name' => 'Homiris Detection Appartement',
            'typed_price' => 19.50
        ])->create([
            'insurance_package_id' => 6,
            'name' => 'Homiris Detection + Appartement',
            'typed_price' => 29.50
        ])->create([
            'insurance_package_id' => 6,
            'name' => 'Homiris Detection Maison',
            'typed_price' => 24.50
        ])->create([
            'insurance_package_id' => 6,
            'name' => 'Homiris Detection + Maison',
            'typed_price' => 37.00
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 7,
            'name' => 'Assurance des Loyers Impayés',
            'typed_price' => 0,
            'percent' => 2.905
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 8,
            'name' => 'Essentielle',
            'typed_price' => 9
        ])->create([
            'insurance_package_id' => 8,
            'name' => 'Sérénité',
            'typed_price' => 16.30
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 9,
            'name' => 'Standard',
            'typed_price' => 11
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 10,
            'name' => 'Standard',
            'typed_price' => 0,
            'percent' => 3.33
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 11,
            'name' => 'First',
            'typed_price' => 24
        ])->create([
            'insurance_package_id' => 11,
            'name' => 'second',
            'typed_price' => 18
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 12,
            'name' => 'Standard',
            'typed_price' => 80.90
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 13,
            'name' => 'Standard',
            'typed_price' => 0
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 14,
            'name' => 'Standard',
            'typed_price' => 0
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 15,
            'name' => 'Standard',
            'typed_price' => 36
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 16,
            'name' => 'Budget',
            'typed_price' => 13.16
        ])->create([
            'insurance_package_id' => 16,
            'name' => 'Assistance',
            'typed_price' => 14.81
        ])->create([
            'insurance_package_id' => 16,
            'name' => 'Realize',
            'typed_price' => 17.01
        ]);

        InsurancePackageForm::query()->create([
            'insurance_package_id' => 17,
            'name' => 'Initial',
            'typed_price' => 15.12
        ])->create([
            'insurance_package_id' => 17,
            'name' => 'Essentielle',
            'typed_price' => 27.25
        ])->create([
            'insurance_package_id' => 17,
            'name' => 'Confort',
            'typed_price' => 43.75
        ])->create([
            'insurance_package_id' => 17,
            'name' => 'Optimale',
            'typed_price' => 64.25
        ])->create([
            'insurance_package_id' => 18,
            'name' => 'D',
            'synopsis' => 'Garantie Décès',
            'typed_price' => 0
        ])->create([
            'insurance_package_id' => 18,
            'name' => 'DIM',
            'synopsis' => 'Garantie Décès, Invalidité, Maladie',
            'typed_price' => 0
        ])->create([
            'insurance_package_id' => 18,
            'name' => 'DIMC',
            'synopsis' => 'Garantie Décès, Invalidité, Maladie, Perte d\'emploi',
            'typed_price' => 0
        ]);
    }
}

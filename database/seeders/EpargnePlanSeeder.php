<?php

namespace Database\Seeders;

use App\Models\Core\EpargnePlan;
use Illuminate\Database\Seeder;

class EpargnePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EpargnePlan::query()->create([
            'type_customer' => 'part',
            'type_epargne' => 'simple',
            'name' => 'Livret A',
            'profit_percent' => 2,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 10,
            'limit_amount' => 22950,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 15,
                'depot_type' => ['money' => true, 'check' => true, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => true,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Idéal pour commencer à épargner, le livret A est un produit d’épargne réglementée et net d’impôts. Votre argent est épargné en toute sécurité et vous pouvez l’utiliser à tout moment pour réaliser vos projets ou faire face aux imprévus."
        ])->create([
            'type_customer' => 'part',
            'type_epargne' => 'simple',
            'name' => 'Livret de Développement Durable et Solidaire (LDDS)',
            'profit_percent' => 2,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 10,
            'limit_amount' => 12000,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 45,
                'depot_type' => ['money' => true, 'check' => true, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 0,
                'retrait_type' => [
                    'money' => false,
                    'card' => false,
                    'transfer' => true,
                    'sepa_orga' => false,
                    'sepa_assoc' => true,
                ]
            ]),
            'description' => "Épargne sûre et défiscalisée, le Livret de Développement Durable et Solidaire (LDDS) est le complément du livret A. Le LDDS permet de vous constituer une épargne de précaution pour préparer en tout sérénité vos projets."
        ])->create([
            'type_customer' => 'part',
            'type_epargne' => 'simple',
            'name' => 'Livret d’épargne populaire (LEP)',
            'profit_percent' => 4.60,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 30,
            'limit_amount' => 7700,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 45,
                'depot_type' => ['money' => false, 'check' => false, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => false,
                    'card' => false,
                    'transfer' => true,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Vous avez un faible montant de revenus et vous souhaitez épargner ? Le livret d’épargne populaire (LEP) est un des meilleurs moyens de constituer une épargne. Votre épargne reste disponible à tout moment et vos intérêts sont totalement exonérés d’impôt sur le revenu et de prélèvements sociaux."
        ])->create([
            'type_customer' => 'part',
            'type_epargne' => 'simple',
            'name' => 'Compte sur livret (CSL)',
            'profit_percent' => 0.05,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 10,
            'limit_amount' => 9999999,
            'unique' => false,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 45,
                'depot_type' => ['money' => true, 'check' => false, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Complément de votre livret A et de votre Livret de Développement Durable et Solidaire (LDDS), le compte sur livret (CSL), vous permet d’épargner en toute sécurité et sans limite de plafond."
        ])->create([
            'type_customer' => 'part',
            'type_epargne' => 'jeune',
            'name' => "Le Livret Jeune, l'épargne dédiée aux 12-25 ans",
            'profit_percent' => 2,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 10,
            'limit_amount' => 1600,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 0,
                'depot_type' => ['money' => true, 'check' => false, 'transfer' => true, 'card' => true]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Le Livret Jeune est un contrat d'épargne souple et disponible réservé aux jeunes entre 12 et 25 ans."
        ])->create([
            'type_customer' => 'part',
            'type_epargne' => 'logement',
            'name' => "Compte Épargne Logement (CEL)",
            'profit_percent' => 1.25,
            'lock_days' => 90,
            'profit_days' => 15,
            'init' => 300,
            'limit_amount' => 15300,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 75,
                'amount_regular_depot' => 75,
                'depot_type' => ['money' => false, 'check' => false, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 0,
                'retrait_type' => [
                    'money' => false,
                    'card' => false,
                    'transfer' => false,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Vous avez un projet immobilier ? Le Compte Épargne Logement (CEL) permet de constituer une épargne à votre rythme et d’obtenir un prêt épargne logement à des conditions spécifiques. Le CEL est le complément naturel du PEL (Plan Épargne Logement) !",
            'droit_credit' => true,
            'info_credit' => json_encode([
                'name' => 'Le Prêt épargne logement',
                'limit' => 23000,
                'unlock_days' => 547,
                'percent_interest' => 2.75
            ])
        ])->create([
            'type_customer' => 'part',
            'type_epargne' => 'logement',
            'name' => "Plan Épargne Logement (PEL)",
            'profit_percent' => 1,
            'lock_days' => 1095,
            'profit_days' => 15,
            'init' => 225,
            'limit_amount' => 61200,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 45,
                'amount_regular_depot' => 45,
                'depot_type' => ['money' => false, 'check' => false, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 0,
                'retrait_type' => [
                    'money' => false,
                    'card' => false,
                    'transfer' => false,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Vous avez un projet immobilier en tête ? Avec le Plan Épargne Logement (PEL), vous constituez progressivement votre apport en bénéficiant d’une rémunération garantie. De plus, vous cumulez des droits à prêt pour financer votre projet à un taux connu dès le départ.",
            'droit_credit' => true,
            'info_credit' => json_encode([
                'name' => 'Le Prêt épargne logement',
                'limit' => 23000,
                'unlock_days' => 1095,
                'percent_interest' => 2.75
            ])
        ])->create([
            'type_customer' => 'part',
            'type_epargne' => 'retraite',
            'name' => "PER Acacia",
            'profit_percent' => 0,
            'lock_days' => 999999,
            'profit_days' => 0,
            'init' => 0,
            'limit_amount' => 0,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 150,
                'amount_regular_depot' => 50,
                'depot_type' => ['money' => false, 'check' => false, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 0,
                'retrait_type' => [
                    'money' => false,
                    'card' => false,
                    'transfer' => false,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Avec le Plan d’Épargne Retraite (PER) Acacia(1), vous épargnez à votre rythme et pouvez bénéficier d’avantages fiscaux sur vos versements. Et au moment de la retraite, l’épargne constituée devient un complément de revenus que vous percevez sous forme d’une rente garantie à vie(2) ou d’un capital délivré en une ou plusieurs fois.",
            'garantie_deces' => true,
            'partial_liberation' => true,
            'info_deces' => json_encode([
                'beneficiaire' => "libre" // Libre ou familliale,
            ]),
            'info_liberation' => json_encode([
                'before_unlock' => [
                    'percent_amount' => 25
                ],
                'after_unlock' => [
                    'percent_amount' => 100
                ]
            ]),
            'info_frais' => [
                'percent' => 0.07,
                'type_prlv' => 'month' // month/sem/year
            ]
        ])->create([
            'type_customer' => 'pro',
            'type_epargne' => 'simple',
            'name' => 'Livret A Pro',
            'profit_percent' => 2,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 10,
            'limit_amount' => 22950,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 15,
                'depot_type' => ['money' => true, 'check' => true, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => true,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Idéal pour commencer à épargner, le livret A est un produit d’épargne réglementée et net d’impôts. Votre argent est épargné en toute sécurité et vous pouvez l’utiliser à tout moment pour réaliser vos projets ou faire face aux imprévus."
        ])->create([
            'type_customer' => 'pro',
            'type_epargne' => 'simple',
            'name' => 'Compte sur livret (CSL) Pro',
            'profit_percent' => 0.05,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 10,
            'limit_amount' => 9999999,
            'unique' => false,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 45,
                'depot_type' => ['money' => true, 'check' => false, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Complément de votre livret A et de votre Livret de Développement Durable et Solidaire (LDDS), le compte sur livret (CSL), vous permet d’épargner en toute sécurité et sans limite de plafond."
        ])->create([
            'type_customer' => 'pro',
            'type_epargne' => 'tresorerie',
            'name' => 'Compte à Terme Tréso +',
            'profit_percent' => 1.25,
            'lock_days' => 0,
            'profit_days' => 30,
            'init' => 10,
            'limit_amount' => 5000000,
            'unique' => false,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 45,
                'depot_type' => ['money' => false, 'check' => false, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Complément de votre livret A et de votre Livret de Développement Durable et Solidaire (LDDS), le compte sur livret (CSL), vous permet d’épargner en toute sécurité et sans limite de plafond."
        ])->create([
            'type_customer' => 'assoc',
            'type_epargne' => 'simple',
            'name' => 'Livret A Association',
            'profit_percent' => 2,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 10,
            'limit_amount' => 76500,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 10,
                'depot_type' => ['money' => true, 'check' => true, 'transfer' => true, 'card' => true]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => true,
                    'sepa_assoc' => true,
                ]
            ]),
            'description' => "Idéal pour commencer à épargner, le livret A est un produit d’épargne réglementée et net d’impôts. Votre argent est épargné en toute sécurité et vous pouvez l’utiliser à tout moment pour réaliser vos projets ou faire face aux imprévus."
        ])->create([
            'type_customer' => 'assoc',
            'type_epargne' => 'simple',
            'name' => 'Compte sur livret (CSL) Association',
            'profit_percent' => 1,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 10,
            'limit_amount' => 9999999,
            'unique' => false,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 10,
                'depot_type' => ['money' => true, 'check' => false, 'transfer' => true, 'card' => true]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Complément de votre livret A et de votre Livret de Développement Durable et Solidaire (LDDS), le compte sur livret (CSL), vous permet d’épargner en toute sécurité et sans limite de plafond."
        ])->create([
            'type_customer' => 'orga',
            'type_epargne' => 'simple',
            'name' => 'Livret A Organisme',
            'profit_percent' => 2,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 10,
            'limit_amount' => 76500,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 10,
                'depot_type' => ['money' => true, 'check' => true, 'transfer' => true, 'card' => true]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => true,
                    'sepa_assoc' => true,
                ]
            ]),
            'description' => "Idéal pour commencer à épargner, le livret A est un produit d’épargne réglementée et net d’impôts. Votre argent est épargné en toute sécurité et vous pouvez l’utiliser à tout moment pour réaliser vos projets ou faire face aux imprévus."
        ])->create([
            'type_customer' => 'orga',
            'type_epargne' => 'simple',
            'name' => 'Compte sur livret (CSL) Organisme',
            'profit_percent' => 1,
            'lock_days' => 0,
            'profit_days' => 15,
            'init' => 10,
            'limit_amount' => 9999999,
            'unique' => false,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 10,
                'depot_type' => ['money' => true, 'check' => false, 'transfer' => true, 'card' => true]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Complément de votre livret A et de votre Livret de Développement Durable et Solidaire (LDDS), le compte sur livret (CSL), vous permet d’épargner en toute sécurité et sans limite de plafond."
        ])->create([
            'type_customer' => 'orga',
            'type_epargne' => 'tresorerie',
            'name' => 'Compte à Terme Tréso +',
            'profit_percent' => 1.25,
            'lock_days' => 0,
            'profit_days' => 30,
            'init' => 8000,
            'limit_amount' => 10000000,
            'unique' => true,
            'info_versement' => json_encode([
                'amount_free_depot' => 10,
                'amount_regular_depot' => 10,
                'depot_type' => ['money' => false, 'check' => false, 'transfer' => true, 'card' => false]
            ]),
            'info_retrait' => json_encode([
                'amount' => 10,
                'retrait_type' => [
                    'money' => true,
                    'card' => true,
                    'transfer' => true,
                    'sepa_orga' => false,
                    'sepa_assoc' => false,
                ]
            ]),
            'description' => "Complément de votre livret A et de votre Livret de Développement Durable et Solidaire (LDDS), le compte sur livret (CSL), vous permet d’épargner en toute sécurité et sans limite de plafond."
        ]);
    }
}

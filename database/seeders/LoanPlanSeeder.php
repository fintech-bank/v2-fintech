<?php

namespace Database\Seeders;

use App\Models\Core\LoanPlan;
use App\Services\Stripe;
use Illuminate\Database\Seeder;

class LoanPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanPlan::query()->create([
            'name' => 'Crédit à la consommation Expresso',
            'minimum' => 1000,
            'maximum' => 35000,
            'duration' => 84,
            'type_pret' => 'part',
            'instruction' => 'Le crédit à la consommation Expresso vous permet d’emprunter à partir de 1 000 €, sur une durée d’un à sept ans. Nouvelle voiture, travaux, vacances… Ce crédit amortissable vous aide à financer le projet de votre choix.',
            'avantage' => '{"report_echeance": true, "adapt_mensuality": true, "online_subscription": true}',
            'condition' => '{"report_echeance_max": "3", "adapt_mensuality_month": "7"}',
            'tarif' => '{"interest": "4.12", "type_taux": "fixe", "max_interest": null, "min_interest": null}'
        ])->create([
            'name' => 'Prêt Jeune actif (18-29 ans)',
            'minimum' => 1500,
            'maximum' => 7000,
            'duration' => 60,
            'type_pret' => 'part',
            'instruction' => 'Vous avez entre 18 et 29 ans, vous entrez dans la vie active ? Vous souhaitez financer votre installation ou vous envisagez l’achat d’un véhicule ? Le Prêt Jeune Actif vous aide à concrétiser tous vos projets. Simulez votre crédit et souscrivez en ligne.',
            'avantage' => '{"report_echeance": true, "adapt_mensuality": true, "online_subscription": true}',
            'condition' => '{"report_echeance_max": "3", "adapt_mensuality_month": "3"}',
            'tarif' => '{"interest": "2.4", "type_taux": "fixe", "max_interest": null, "min_interest": null}'
        ])->create([
            'name' => 'Crédit Auto Expresso',
            'minimum' => 1000,
            'maximum' => 35000,
            'duration' => 84,
            'type_pret' => 'part',
            'instruction' => "Le crédit Expresso vous permet de financer l’achat d’une nouvelle voiture ou d'un deux-roues. Ce crédit amortissable est accessible sans apport et ses mensualités sont modulables.",
            'avantage' => '{"report_echeance": true, "adapt_mensuality": true, "online_subscription": true}',
            'condition' => '{"report_echeance_max": "3", "adapt_mensuality_month": "7"}',
            'tarif' => '{"interest": "4.12", "type_taux": "fixe", "max_interest": null, "min_interest": null}'
        ])->create([
            'name' => 'Convention de trésorerie Courante',
            'minimum' => 1000,
            'maximum' => 25000,
            'duration' => 60,
            'type_pret' => 'pro',
            'instruction' => "Votre activité professionnelle peut être sujette à des décalages de trésorerie dus à une activité saisonnière ou à des délais de paiement client, voire même demander un financement ponctuel. Découvrez nos solutions de crédit à court terme pour ajuster votre trésorerie courante à vos besoins.",
            'avantage' => '{"report_echeance": false, "adapt_mensuality": false, "online_subscription": false}',
            'condition' => '{"report_echeance_max": null, "adapt_mensuality_month": null}',
            'tarif' => '{"interest": null, "type_taux": "variable", "max_interest": "6.35", "min_interest": "0.90"}'
        ])->create([
            'name' => 'Convention de trésorerie Courante',
            'minimum' => 1000,
            'maximum' => 250000,
            'duration' => 180,
            'type_pret' => 'orga',
            'instruction' => "Votre activité professionnelle peut être sujette à des décalages de trésorerie dus à une activité saisonnière ou à des délais de paiement client, voire même demander un financement ponctuel. Découvrez nos solutions de crédit à court terme pour ajuster votre trésorerie courante à vos besoins.",
            'avantage' => '{"report_echeance": false, "adapt_mensuality": false, "online_subscription": false}',
            'condition' => '{"report_echeance_max": null, "adapt_mensuality_month": null}',
            'tarif' => '{"interest": null, "type_taux": "variable", "max_interest": "6.35", "min_interest": "0.90"}'
        ])->create([
            'name' => 'Convention de trésorerie Courante',
            'minimum' => 1000,
            'maximum' => 25000,
            'duration' => 74,
            'type_pret' => 'assoc',
            'instruction' => "Votre activité professionnelle peut être sujette à des décalages de trésorerie dus à une activité saisonnière ou à des délais de paiement client, voire même demander un financement ponctuel. Découvrez nos solutions de crédit à court terme pour ajuster votre trésorerie courante à vos besoins.",
            'avantage' => '{"report_echeance": false, "adapt_mensuality": false, "online_subscription": false}',
            'condition' => '{"report_echeance_max": null, "adapt_mensuality_month": null}',
            'tarif' => '{"interest": null, "type_taux": "variable", "max_interest": "6.35", "min_interest": "0.90"}'
        ])->create([
            'name' => 'Pret CREATOR',
            'minimum' => 1000,
            'maximum' => 30000,
            'duration' => 84,
            'type_pret' => 'pro',
            'instruction' => null,
            'avantage' => '{"report_echeance": false, "adapt_mensuality": true, "online_subscription": false}',
            'condition' => '{"report_echeance_max": "0", "adapt_mensuality_month": "2"}',
            'tarif' => '{"interest": "1.20", "type_taux": "fixe", "max_interest": null, "min_interest": null}'
        ])->create([
            'name' => 'Crédit Renouvelable Alterna',
            'minimum' => 1,
            'maximum' => 21500,
            'duration' => 580,
            'type_pret' => 'part',
            'instruction' => "L’option Crédit associée au crédit renouvelable Alterna(1), vous offre la possibilité de payer au comptant ou à crédit(2) lors de vos achats ou retraits. Vous pouvez l’ajouter gratuitement(3) à votre carte bancaire actuelle : cartes CB Visa, CB Visa Premier, CB Mastercard, CB Gold Mastercard(3) .",
            'avantage' => '{"report_echeance": false, "adapt_mensuality": false, "online_subscription": true}',
            'condition' => '{"report_echeance_max": "0", "adapt_mensuality_month": "0"}',
            'tarif' => '{"interest": null, "type_taux": "variable", "max_interest": "4.39", "min_interest": "16.90"}'
        ]);
    }
}

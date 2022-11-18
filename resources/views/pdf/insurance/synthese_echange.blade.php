@extends('pdf.layouts.app')

@section("content")
    {{ $customer->info->full_name }},
    <p>
        Conformément aux besoins et souhaits exprimés lors de notre échange, vous avez accepté de signer électroniquement la souscription
        en ligne de votre Assurance {{ Str::upper($data->insurance->package->name) }}.
    </p>
    <p>Pour mémoire, voici les principales caractéristiques de votre demande :</p>
    <ul>
        <li>Offre: {{ Str::upper($data->insurance->package->name) }} - {{ Str::upper($data->insurance->form->name) }}</li>
        <li>Assuré(e): {{ $customer->info->full_name }}</li>
        <li>Bénéficiaire: {{ $data->insurance->beneficiaire ?? "LUI MÊME" }}</li>
    </ul>
    <p>Aussi, vous trouverez, ci-joint, les documents contractuels relatifs à cette demande (dénommés, ensemble, le « contrat »), c'est-à-dire :</p>
    <ul>
        <li>Condition particulière {{ $data->insurance->package->name }}</li>
        <li>Bordereau de rétractation</li>
    </ul>
    <p>
        Nous vous informons que vous disposez d'un délai de 30 jours à compter de la date de conclusion de votre contrat électronique pour
        renoncer (si ce délai expire un samedi, un dimanche ou un jour férié ou chômé, il ne sera pas prorogé). Ce droit de renonciation peut être
        exercé par lettre recommandée avec accusé de réception à {{ config('app.name') }} - Service Relations Clients - 4 rue du Coudraix -
        44000 Nantes Cedex 4.
    </p>
    <p>Pour commencer à signer électroniquement votre demande, veuillez accepter les termes de ce document de synthèse.</p>
    <p>
        IMPORTANT : Vous avez jusqu'au {{ $data->insurance->date_member->addMonth()->format("d/m/Y") }} pour finaliser l'acceptation de votre contrat. Pendant ce délai, vous pouvez revenir à tout
        moment dans la rubrique « Mes demandes » de votre Espace Client ou de votre application mobile. Au-delà, votre accord ne pourra
        plus être pris en compte et vous devrez à nouveau nous contacter pour souscrire un contrat en ligne
    </p>
    <p>
        Si vous considérez que ce récapitulatif ne reflète pas les termes de notre échange, vous pouvez quitter le parcours de signature en
        cliquant sur la croix en haut à droite et annuler la proposition soumise depuis la rubrique « Mes demandes » (attention cette action est
        définitive).
    </p>
    <p>Nous demeurons naturellement à votre disposition pour toute question ou demande complémentaire.</p>
    <p>Bien cordialement, </p>
    <p>{{ $customer->agent->name }}</p>
    <p class="fs-2">
        Signé électroniquement<br>
        par {{ $customer->info->lastname }} {{ $customer->info->firstname }},<br>
        le {{ isset($document) ? $document->signed_at->format("d/m/Y") : now()->format('d/m/Y') }}<br>
        CN du certificat: {{ $customer->info->lastname }} {{ $customer->info->firstname }}<br>
        CN AC: {{ $customer->persona_reference_id }}
    </p>
@endsection

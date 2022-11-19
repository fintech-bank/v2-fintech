@extends('pdf.layouts.app')

@section("content")
    <div class="text-center fw-bolder fs-3 mb-5">
        <div class="">OFFRE DE CONTRAT DE CREDIT</div>
        <div class="">{{ $data->pret->plan->name }}</div>
    </div>
    <p>
        La présente offre de crédit est faite en application de l’article L.312-1 et suivants du code de la consommation.
        Offre de contrat de crédit émise par {{ config('app.name') }}, à Nantes, le {{ isset($document) ? $document->created_at->format('d/m/Y') : now()->format('d/m/Y') }}
        Durée de validité de l’offre : 15 jours à compter du {{ isset($document) ? $document->created_at->format('d/m/Y') : now()->format('d/m/Y') }}.
    </p>
    <div class="uppercase underline bg-secondary fw-bolder fs-4 p-2 text-white my-2">Préteur</div>
    <p>
        {{ config('app.name') }}, SAS à capital variable régie par les
        articles L512-2 et suivants du code monétaire et financier et l’ensemble des textes relatifs aux établissements de crédit, immatriculée au registre du commerce et des sociétés de Nantes sous le n°521 809 061, dont
        le siège social est situé 4 Rue du Coudray - 44000 Nantes Cedex, intermédiaire en
        assurance immatriculé à l’ORIAS sous le n° 07 004 504.
    </p>
    <p class="fw-bolder fs-italic">Ci-après dénommée le « Prêteur » ou la « Banque »</p>
    <div class="uppercase underline bg-secondary fs-4 p-2 text-white my-2">Emprunteur(s)</div>
    <p>
        <span class="fw-bolder underline">Titulaire du compte:</span><br>
        Nom, Prénom: {{ $customer->info->full_name }}<br>
        Date de naissance: {{ $customer->info->datebirth->format("d/m/Y") }} -- Lieu: {{ $customer->info->citybirth }}<br>
        Adresse: {{ $customer->info->line_address }}<br>
        <strong>Matricule:</strong> {{ $customer->user->identifiant }}
    </p>
    <p class="fw-bolder fs-italic mb-10">Ci-après dénommé(e)(s) l’"Emprunteur" ou le « Client » même en cas de pluralité d’emprunteurs,</p>
    <div class="rounded py-1 px-1 border">
        <div class="fw-bolder bg-gray-300 uppercase">CARACTERISTIQUES ESSENTIELLES DU CREDIT</div>
        <p><strong>Type de crédit:</strong> {{ $data->pret->plan->name }}</p>
        <p>
            <span class="fw-bolder">Conditions de mise à disposition des fonds :</span><br>
            Le Prêteur met à disposition un encours égale à la demande utilisable par l'emprunteur par l'intermédiaire de virement bancaire, ou autre
            dans la limite du montant de l'encours autorisée par le Prêteur.
        </p>
        <p>
            <span class="fw-bolder">Désignation du compte : {{ $data->pret->wallet->number_account }}</span><br>
            Le contrat de crédit ne pourra pas commencer à être exécuté et les fonds ne pourront être utilisés qu’à l’expiration du
            délai de rétractation de 14 jours, ou dès le 8ᵉ jour sur demande expresse de l’Emprunteur.
        </p>
        <p><strong>Durée du contrat de crédit:</strong> le présent contrat est conclu pour une durée de {{ $data->pret->duration }} mois.</p>
        <p>
            <span class="fw-bolder mb-1">Remboursement par l’Emprunteur :</span>
            L'emprunteur peut rembourser par mensualité définie lors de son contrat ou modulable par l'intermédiaire de son espace client, de son conseiller ou par
            demande expresse au centre de relation client.<br>
            Il peut également rembourser par anticipation tout ou en partie le montant utilisé par son contrat.
        </p>
    </div>
    <div class="page-break"></div>
    <div class="rounded py-1 px-1 border">
        <span class="fw-bolder">Taux débiteur :</span> Le taux débiteur est fixe.<br>
        <strong>Taux Fixe : de {{ $data->pret->plan->tarif->interest }}% au
            {{ now()->format("d/m/Y") }}.</strong>
        <p>
            En cas de perturbations affectant les marchés, entraînant la disparition du taux de référence, le Prêteur procèdera
            immédiatement au remplacement de ce taux par un taux de marché équivalent qui sera porté à la connaissance de
            l’Emprunteur par tout moyen et notamment par une mention portée sur le relevé de compte. Le nouveau taux sera
            appliqué de façon rétroactive au jour de la modification, disparition ou cessation de publication du taux de référence
            d’origine.
        </p>
        <p>
            <span class="fw-bolder"><span class="underline">Montant total du crédit dû par l’Emprunteur : </span>{{ eur($data->pret->amount_loan) }}</span>
        </p>
        <p>
            <span class="fw-bolder">Sûretés et assurances exigées :</span><br>
        </p>
        <ul>
            <li class="fw-bolder">Assurance exigée : {{ $data->pret->insurance_text }}</li>
            <li class="fw-bolder">Caution personne physique : {{ $data->pret->caution_text }}</li>
        </ul>
    </div>
    <div class="fs-4 fw-bolder">ACCEPTATION DE L’OFFRE DE CONTRAT DE CREDIT PAR L’EMPRUNTEUR</div>
    <p>
        Après avoir reçu et pris connaissance de la Fiche d’Information Précontractuelle annexée aux présentes et l’ensemble
        des conditions de l’offre de contrat de crédit, je déclare accepter la présente offre de contrat de crédit.
    </p>
    <p>
        Je reconnais avoir reçu toutes les explications de la part du Prêteur me permettant de déterminer si le présent crédit est
        adapté à mes besoins et ma situation financière et me permettant d’appréhender clairement l’étendue de mon
        engagement. Mon attention a été attirée sur les caractéristiques essentielles du crédit et sur les conséquences que ce
        crédit peut avoir sur ma situation financière.
        Je reconnais rester en possession d’un exemplaire de cette offre, dotée d’un formulaire détachable de « bordereau de
        rétractation ».
    </p>
    <table class="table table-sm table-border w-100">
        <tbody>
        <tr>
            <td class="fw-bold">Signature de l'emprunteur</td>
            <td class="fw-bold">Signature de la banque</td>
        </tr>
        <tr class="h-50px">
            <td>
                Signé électroniquement<br>
                par {{ $customer->info->lastname }} {{ $customer->info->firstname }},<br>
                le {{ isset($document) ? $document->signed_at->format("d/m/Y") : now()->format('d/m/Y') }}<br>
                CN du certificat: {{ $customer->info->lastname }} {{ $customer->info->firstname }}<br>
                CN AC: {{ $customer->persona_reference_id }}
            </td>
            <td>
                Signé électroniquement<br>
                par La Banque,<br>
                le {{ isset($document) ? $document->signed_at->format("d/m/Y") : now()->format('d/m/Y') }}<br>
            </td>
        </tr>
        </tbody>
    </table>
@endsection

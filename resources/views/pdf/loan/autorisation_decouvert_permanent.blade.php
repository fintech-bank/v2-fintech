@extends('pdf.layouts.app')

@section("content")
    <div class="text-center fw-bolder fs-3 mb-5">
        <div class="">OFFRE DE CONTRAT DE CREDIT</div>
        <div class="">AUTORISATION DE DÉCOUVERT</div>
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
        <p><strong>Type de crédit:</strong> Autorisation de découvert</p>
        <p>
            <span class="fw-bolder">Conditions de mise à disposition des fonds :</span><br>
            Le Prêteur autorise l’Emprunteur à faire fonctionner le compte désigné ci-dessous en position débitrice dans la limite du
            montant précité et pour une durée indéterminée. Il est ici précisé, en tant que de besoin, que la présente autorisation de
            découvert se substitue à toute autre autorisation antérieure.
        </p>
        <p>
            <span class="fw-bolder">Désignation du compte : {{ $data->wallet->number_account }}</span><br>
            Le contrat de crédit ne pourra pas commencer à être exécuté et les fonds ne pourront être utilisés qu’à l’expiration du
            délai de rétractation de 14 jours, ou dès le 8ᵉ jour sur demande expresse de l’Emprunteur.
        </p>
        <p><strong>Durée du contrat de crédit:</strong> le présent contrat est conclu pour une durée indéterminée.</p>
        <p>
            <span class="fw-bolder mb-1">Remboursement par l’Emprunteur :</span>
            Le compte peut être débiteur à concurrence du montant précisé ci-dessus en dehors de toute prise d’effet d’une
            dénonciation de l’autorisation de découvert par l’Emprunteur ou par le Prêteur. Le compte devra redevenir en position
            créditrice lors de la prise d’effet de la dénonciation de l’autorisation, objet du présent contrat, par l’Emprunteur ou le
            Prêteur, notamment à l’expiration du délai de préavis éventuel.
        </p>
    </div>
    <div class="page-break"></div>
    <div class="rounded py-1 px-1 border">
        <span class="fw-bolder">Taux débiteur :</span> Le taux débiteur est révisable. Toute position débitrice résultant de l’utilisation du découvert donne lieu
        à la perception d’intérêts débiteurs <strong>Taux variable : COT + 11,100, SOIT A CE JOUR {{ round(($customer->cotation / 2.3) + 11.10, 2) }}% au
        {{ now()->format("d/m/Y") }}.</strong>
        <p>
            Le taux indiqué est ainsi constitué d’un taux de référence majoré d’un certain nombre de points. Ce taux de référence est
            contractuellement sujet à variation et entraîne la variation du taux débiteur. Le Prêteur informera préalablement l’Emprunteur
            de chaque variation du taux de référence par une mention portée sur son relevé de compte. Le relevé de compte
            mentionnera par ailleurs, le taux annuel effectif global des intérêts portés au débit du compte.
            Le relevé de compte mentionnera par ailleurs, le taux annuel effectif global des intérêts portés au débit du compte.
            A réception de cette information, l’emprunteur pourra sur demande écrite adressée à la banque, refuser cette révision.
            Dans ce cas, l'autorisation de découvert prendra fin et le remboursement du crédit déjà utilisé devra intervenir dans les
            30 jours suivant le refus de la révision.
        </p>
        <p>
            En cas de perturbations affectant les marchés, entraînant la disparition du taux de référence, le Prêteur procèdera
            immédiatement au remplacement de ce taux par un taux de marché équivalent qui sera porté à la connaissance de
            l’Emprunteur par tout moyen et notamment par une mention portée sur le relevé de compte. Le nouveau taux sera
            appliqué de façon rétroactive au jour de la modification, disparition ou cessation de publication du taux de référence
            d’origine.
        </p>
        <p>
            <span class="fw-bolder"><span class="underline">Montant total du crédit dû par l’Emprunteur : </span>{{ eur($data->wallet->balance_decouvert) }}</span>
        </p>
        <p>
            <span class="fw-bolder">Sûretés et assurances exigées :</span><br>
        </p>
        <ul>
            <li class="fw-bolder">Assurance exigée : Non</li>
            <li class="fw-bolder">Caution personne physique : Non</li>
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
    <table class="table table-sm table-border w-auto">
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

@extends('pdf.layouts.app')

@section("content")
    <div class="d-flex flex-center fw-bolder">
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
        <span class="fw-bolder">Titulaire du compte:</span><br>
        Nom, Prénom: {{ $customer->info->full_name }}<br>
        Date de naissance: {{ $customer->info->datebirth->format("d/m/Y") }} -- Lieu: {{ $customer->info->citybirth }}<br>
        Adresse: {{ $customer->info->line_address }}
    </p>
@endsection

@extends('pdf.layouts.app')

@section("content")
    <div class="fs-3 fw-bolder">{{ $customer->info->full_name }},</div>
    <p class="mb-5">Vous trouverez ci-après les principales caractéristiques de votre demande d'ouverture de compte de {{ $customer->info->type_text }}</p>

    @if($customer->info->type == 'part')
    <div class="border border-2 p-5 mb-10">
        <div class="fs-5 mb-3">Vos Informations personnelles</div>
        <ul class="list-unstyled">
            <li>
                <strong>{{ $customer->info->full_name }}</strong> née le <strong>{{ $customer->info->datebirth->format('d/m/Y') }}</strong> à <strong>{{ $customer->info->citybirth }}</strong>,
                {{ \App\Helper\CountryHelper::getCountryName($customer->info->countrybirth) }}
            </li>
            <li>Adresse mail: <strong>{{ $customer->info->email }}</strong></li>
            <li>Téléphone portable: <strong>{{ $customer->info->mobile }}</strong></li>
            <li class="mb-3">Domicile: <strong>{{ $customer->info->line_address }}</strong></li>
            <li class="mb-3">Pays de résidence fiscal: <strong>{{ \App\Helper\CountryHelper::getCountryName($customer->info->country) }}</strong></li>
            <li>Vous êtes: <strong>{{ $customer->situation->pro_category }}</strong></li>
            <li class="mb-3">Vous êtes: <strong>{{ $customer->situation->logement }}</strong></li>
            <li>Vous êtes: <strong>{{ $customer->situation->family_situation }}</strong></li>
            <li class="mb-3">Vous êtes: <strong>{{ $customer->situation->pro_category }},{{ $customer->situation->pro_profession }}</strong></li>
            <li>Mon patrimoine est de: <strong>{{ eur($customer->income->patrimoine) }}</strong></li>
            <li>Mon revenue mensuelle est de: <strong>{{ eur($customer->income->pro_income) }}</strong></li>
        </ul>
    </div>
    @endif

    <div class="border border-2 p-5 mb-10">
        <div class="fs-5 mb-3">Votre agence de référence</div>
        <p>
            {{ $agence->name }}<br>
            {{ $agence->address }}<br>
            {{ $agence->postal }} {{ $agence->city }}
        </p>
    </div>

    <div class="border border-2 p-5 mb-10">
        <div class="fs-5 mb-3">Votre offre</div>
        <p class="mb-3">Vous avez choisi l'offre : Forfait <strong>{{ $customer->package->name }}</strong></p>
        <p>Tarif: <strong>{{ $customer->package->price_format }} / par mois</strong></p>
    </div>

    <p class="fs-1">
        Signé électroniquement<br>
        par {{ $customer->info->lastname }} {{ $customer->info->firstname }},<br>
        le {{ isset($document) ? $document->signed_at->format("d/m/Y") : now()->format('d/m/Y') }}<br>
        CN du certificat: {{ $customer->info->lastname }} {{ $customer->info->firstname }}<br>
        CN AC: {{ $customer->persona_reference_id }}
    </p>
@endsection

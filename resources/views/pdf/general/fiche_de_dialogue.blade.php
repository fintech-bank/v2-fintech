@extends('pdf.layouts.app')

@section("content")
    <div class="fs-3 fw-bolder">{{ $customer->info->full_name }},</div>
    <p class="mb-5">Vous trouverez ci-après les principales caractéristiques de votre demande d'ouverture de compte de {{ $customer->info->type_text }}</p>

    @if($customer->info->type == 'part')
    <div class="border border-2 p-5">
        <div class="fs-5">Vos Informations personnelles</div>
        <ul class="list-unstyled">
            <li>
                <strong>{{ $customer->info->full_name }}</strong> née le <strong>{{ $customer->info->birthday->format('d/m/Y') }}</strong> à <strong>{{ $customer->info->citybirth }}</strong>,
                {{ \App\Helper\CountryHelper::getCountryName($customer->info->countrybirth) }}
            </li>
        </ul>
    </div>
@endsection

@extends('pdf.layouts.app')

@section("content")
    <div class="fs-3 fw-bolder">{{ $customer->info->full_name }},</div>
    <p class="mb-5">Vous trouverez ci-après les principales caractéristiques de votre demande d'ouverture de compte de {{ $customer->info->type_text }}</p>

    <div class="border border-2 p-5">
        <div class="fs-5">Vos Informations personnelles</div>

    </div>
@endsection

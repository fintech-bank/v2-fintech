@extends('pdf.layouts.app')

@section("content")
    <div class="text-center fs-4 fw-bold fs-underline">SOUSCRIPTION DU SERVICE E.CARTE BLEUE PARTICULIER</div>
    <div class="fw-bolder">TITULAIRE DU COMPTE ET DE LA CARTE : {{ $customer->info->full_name }}</div>
    @if($customer->info->type == 'part')
        <div class="">Date de naissance : {{ $customer->info->datebirth->format('d/m/Y') }}</div>
    @endif
    <div class="">Adresse : {{ $customer->info->line_address }}</div>
    <div class="separator separator-4 border-2 my-3"></div>
    <div class="fw-bolder fs-3 text-center">CONDITIONS PARTICULIERES</div>
    <p>Je suis titulaire d'un contrat Carte CB-{{ Str::upper($data->card->support->name) }} à autorisation quasi-systématique n°
        {{ $document ? $document->reference : generateReference() }} domiciliée sur le
        compte {{ $data->card->wallet->name_account }}.</p>
@endsection

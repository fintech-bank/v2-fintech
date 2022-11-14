@extends('pdf.layouts.app')

@section("content")
    <div class="text-center fs-4 fw-bold fs-underline">CONTRAT CARTE BANCAIRE {{ Str::upper($data->card->support->name) }} À AUTORISATION QUASISYSTÉMATIQUE</div>
    <div class="text-center fs-2 fs-underline mb-2">Fourniture d’une carte de débit (carte de paiement internationale à débit {{ $data->card->debit_format }})</div>

    <div class="fw-bolder">TITULAIRE DU COMPTE ET DE LA CARTE : {{ $customer->info->full_name }}</div>
    @if($customer->info->type == 'part')
    <div class="">Date de naissance : {{ $customer->info->datebirth->format('d/m/Y') }}</div>
    @endif
    <div class="">Adresse : {{ $customer->info->line_address }}</div>
    <div class="separator my-3"></div>
@endsection

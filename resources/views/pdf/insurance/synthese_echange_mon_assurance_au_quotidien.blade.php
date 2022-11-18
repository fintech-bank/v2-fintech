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
    </ul>
@endsection

@extends('pdf.layouts.app')

@section("content")
    <div class="text-center fs-4 fw-bold fs-underline">CONTRAT CARTE BANCAIRE {{ Str::upper($data->card->support->name) }} À AUTORISATION QUASISYSTÉMATIQUE</div>
    <div class="text-center fs-2 fs-underline mb-2">Fourniture d’une carte de débit (carte de paiement internationale à débit {{ $data->card->debit_format }})</div>

    <div class="fw-bolder">TITULAIRE DU COMPTE ET DE LA CARTE : {{ $customer->info->full_name }}</div>
    @if($customer->info->type == 'part')
    <div class="">Date de naissance : {{ $customer->info->datebirth->format('d/m/Y') }}</div>
    @endif
    <div class="">Adresse : {{ $customer->info->line_address }}</div>
    <div class="separator separator-4 border-2 my-3"></div>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th colspan="2" class="text-center fw-bolder">CONDITIONS PARTICULIERES</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Référence du contrat : {{ $document ? $document->reference : generateReference() }}</td>
                <td>N°de compte support de la carte : {{ $data->card->wallet->number_account }}</td>
            </tr>
            <tr>
                <td>Type de carte : {{ $customer->info->type_text }}</td>
                <td>Type de débit : {{ $data->card->debit_format }}</td>
            </tr>
            <tr>
                <td rowspan="2">Service VISU souscrit : NON</td>
                <td>Catégorie de carte selon le règlement (UE) 2015/751 du 29/04/2015 : Débit</td>
            </tr>
            <tr>
                <td>Carte dotée de la fonctionnalité sans contact : {{ $data->card->isContact() ? 'OUI' : 'NON' }}</td>
            </tr>
        </tbody>
    </table>
    <p>Le titulaire de la carte et/ou du compte doit déclarer par téléphone dans les meilleurs délais, la perte, le vol de la carte ou
        l’utilisation frauduleuse des données de la carte au centre d'opposition de la Banque : 01.77.86.24.24 (prix d'un appel local)</p>
    <div class="fw-bolder fs-3 text-center">MODALITES D'UTILISATION</div>
    <p>Les plafonds d'autorisation de votre carte sont :</p>
    <table class="table table-bordered table-sm">
        <tbody>
            <td>
                <strong>RETRAITS:</strong>
                <ul class="list-unstyled">
                    <li>{{ eur($data->card->limit_retrait) }} / 7 jour(s) glissant(s) dans les GAB en France et dépositaire.</li>
                </ul>
            </td>
            <td>
                <strong>Paiements et transfert de fonds ::</strong>
                <ul class="list-unstyled">
                    <li>{{ eur($data->card->limit_paiement) }} / 30 jour(s) glissant(s) en france.</li>
                </ul>
            </td>
        </tbody>
    </table>
@endsection

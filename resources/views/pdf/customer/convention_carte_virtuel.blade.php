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

    <p>Le titulaire de la carte et/ou du compte (ci-après « le titulaire ») doit déclarer par téléphone dans les meilleurs délais, la perte, le
        vol de la carte, ou l'utilisation frauduleuse des données de la carte au centre d'opposition de la Banque : 01.77.86.24.24 (prix
        d'un appel local).</p>

    <p>
        Il reconnait avoir reçu et pris connaissance des conditions particulières et générales d'utilisation du Service e-Carte Bleue et
        des conditions générales du fonctionnement des cartes {{ config('app.name') }}, (réf. CONTRAT PORTEUR VERSION 18-C)
        ainsi que la notice d'information du contrat de "Livraison non conforme et non livraison d'un bien" et en accepte les termes sans
        réserve.
    </p>

    <div class="fs-4 fw-bolder">Adhésion et déclarations du ou des titulaires</div>
    <p>
        Le(s) titulaire(s) déclare(nt) avoir pris connaissance, lu et compris la notice d’information sur le traitement des données à
        caractère personnel.
    </p>
    <p>
        Le titulaire autorise la {{ config('app.name') }} à prélever automatiquement le montant de la cotisation annuelle
        relative au Service e-Carte Bleue, selon les conditions tarifaires en vigueur, sur le compte désigné ci-dessus.
    </p>
    <div class="m-5 p-5" style="border: solid 1px #000000">
        <table style="width: 100%;">
            <tbody>
            <tr>
                <td style="width: 60%;">
                    Nom et Prénom du signataire: {{ \App\Helper\CustomerHelper::getName($customer) }}<br>
                    Fait à: {{ $customer->agency->city }}<br>
                    Le: {{ now()->format('d/m/Y') }}
                </td>
                <td style="width: 20%; text-align: center">
                    @if(isset($document) && $document->signed_by_client == true)
                        Signé éléctroniquement le {{ now()->format('d/m/Y') }}.<br>@if($customer->info->type == 'part') {{ $customer->info->civility.'. '. $customer->info->lastname.' '.$customer->info->firstname }} @else {{ $customer->info->company }} @endif
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

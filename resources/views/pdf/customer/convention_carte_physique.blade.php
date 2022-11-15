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
    <table class="table table-bordered table-sm mb-5">
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
                    <li>{{ eur($data->card->limit_payment) }} / 30 jour(s) glissant(s) en france.</li>
                    @if($data->card->is_differed)
                        <li>{{ eur($data->card->differed_limit) }} / de débit différé sur 30 jours calendaire</li>
                    @endif
                </ul>
            </td>
        </tbody>
    </table>
    <p>Les comptes accessibles aux GAB sont, à la date de signature :</p>
    <div class="border p-2">
        {{ $data->card->wallet->name_account }}
    </div>
    <p>Pour votre sécurité, votre nouvelle carte est fabriquée et transportée inactive. Pour l'activer, vous devez effectuer un retrait sur
        un distributeur automatique de billets ou un paiement chez un commerçant, validé par votre code confidentiel*.</p>
    <div class="page-break"></div>
    <p class="fs-underline">En signant les présentes Conditions Particulières,</p>
    <ul>
        <li>
            Je déclare avoir pris connaissance des Conditions Générales de fonctionnement de la banque à distance - Conditions
            appliquées aux opérations bancaires des particuliers (1) qui m’ont été adressées en complément de ces Conditions
            Particulières, et en accepte tous les termes sans réserve ;
        </li>
        <li>
            Je déclare être majeur capable et m'engager en nom propre (à l'exception d'une représentation légale d'un majeur protégé)
        </li>
        <li>
            Je demande la souscription de la banque à distance telle qu’exposée ci-dessus en ayant connaissance du fait que cette
            souscription est soumise à l’agrément de {{ config('app.name') }} ;
        </li>
        <li>
            Je suis informé(e):
            <ul>
                <li>
                    que la signature de la convention de compte doit être réalisée dans les 60 jours suivant la validation du
                    formulaire d’ouverture de compte en ligne, avec l’ensemble des pièces justificatives, au plus tard 60 jours
                    calendaires suivant la validation de mon formulaire de demande d’ouverture de compte en ligne. Au-delà, ma
                    demande ne pourra plus être prise en compte et je devrais faire une nouvelle demande
                </li>
                <li>
                    qu’en cas d’agrément par {{ config('app.name') }}, celui-ci me sera notifié par courrier (« Lettre d’agrément »). Je
                    disposerai de 14 jours calendaires (si ce délai expire un samedi, un dimanche ou un jour férié ou chômé, il sera
                    prorogé jusqu’au premier jour ouvrable suivant) à compter de l’agrément de la banque (cachet de la Poste
                    faisant foi) pour me rétracter au moyen du formulaire de rétractation envoyé par lettre recommandée avec
                    accusé de réception. Passé ce délai de rétractation, la Convention pourra être résiliée dans les conditions
                    prévues aux conditions générales de la convention de compte.
                </li>
            </ul>
        </li>
    </ul>
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

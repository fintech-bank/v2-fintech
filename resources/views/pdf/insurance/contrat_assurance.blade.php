@extends('pdf.layouts.app')

@section("content")
    <div class="text-center fs-3 fs-underline">SOUSCRIPTION DE PRODUITS ET SERVICES</div>
    <div class="text-center fs-3">CONDITIONS PARTICULIERES</div>
    <div class="mt-10 mb-10 text-center" style="border: solid 2px #000000; background-color: #a4a4a4">IDENTIFICATION DU
        TITULAIRE
    </div>

    <table style="width: 100%;">
        <tbody>
        <tr>
            <td style="width: 50%;">
                <table style="width: 100%;">
                    <tbody>
                    <tr>
                        <td style="width: 50%;">{{ \App\Helper\CustomerInfoHelper::getCivility($customer->info->civility) }}</td>
                        <td style="width: 50%;">{{ $customer->info->middlename ?  : $customer->info->lastname }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Nom de naissance</td>
                        <td style="width: 50%;">{{ $customer->info->lastname }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Prénom</td>
                        <td style="width: 50%;">{{ $customer->info->firstname }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Situation familliale</td>
                        <td style="width: 50%;">{{ $customer->situation->family_situation }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Téléphone Fixe</td>
                        <td style="width: 50%;">{{ $customer->info->phone }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Téléphone Portable</td>
                        <td style="width: 50%;">{{ $customer->info->mobile }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Adresse Mail</td>
                        <td style="width: 50%;">{{ $customer->user->email }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 50%;">
                <table style="width: 100%;">
                    <tbody>
                    <tr>
                        <td style="width: 50%;">Date de Naissance</td>
                        <td style="width: 50%;">{{ $customer->info->datebirth }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Commune de Naissance</td>
                        <td style="width: 50%;">{{ $customer->info->citybirth }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Pays de Naissance</td>
                        <td style="width: 50%;">{{ $customer->info->countrybirth }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="mt-10 mb-10 text-center" style="border: solid 2px #000000; background-color: #a4a4a4">ADRESSE</div>
    <ol>
        <li class="fs-underline">Adresse Principal</li>
        <p>
            {{ $customer->info->address }}<br>
            {{ $customer->info->addressbis ? $customer->info->addressbis.'<br>':'' }}
            {{ $customer->info->postal }} {{ $customer->info->city }}<br>
            {{ $customer->info->country }}
        </p>
    </ol>
    <div class="fs-2 fw-bold">Protection des données personnelles</div>
    <p>
        {{ config('app.name') }}, établissement bancaire et courtier en assurances, est amenée à traiter en qualité de responsable de
        traitement, vos données personnelles notamment pour les besoins de la gestion des contrats et services, de la relation
        commerciale, et afin de répondre à ses obligations légales et réglementaires. Vous pouvez retrouver le détail des
        traitements réalisés, en ce compris les données traitées, les finalités, les bases légales applicables, les destinataires, les
        durées de conservation, et les informations relatives aux transferts hors Espace économique européen, sur l’espace
        internet particuliers dans la rubrique – nos engagements/informations réglementaires, ou sur demande de votre part
        dans votre agence. Cette information vous est également communiquée à l’ouverture de votre compte, et à l’occasion
        des modifications dont elle peut faire l’objet. Vous disposez d’un droit d’accès et de rectification, d’effacement, de
        limitation du traitement, ainsi que d’un droit à la portabilité de vos données. Vous pouvez également vous opposer pour
        des raisons tenant à votre situation particulière, à ce que vos données à caractère personnel fassent l’objet d’un
        traitement, ou encore définir des directives générales ou spécifiques sur le sort de vos données personnelles en cas de
        décès. Vous pouvez aussi, à tout moment et sans frais, sans avoir à motiver votre demande, vous opposer à ce que vos
        données soient utilisées à des fins de prospection commerciale. Vous pouvez exercer vos droits, ainsi que contacter le
        délégué à la protection des données personnelles en vous adressant:
    </p>
    <ul>
        <li>Par courrier électronique à l’adresse suivante : {{ config('mail.from.address') }};</li>
        <li>Sur votre Espace client;</li>
        <li>
            À l’adresse postale suivante :<br>
            {{ config('app.name') }} - Service Protection des données personnelles<br>
            {{ $customer->agency->address }}<br>
            {{ $customer->agency->postal }} {{ $customer->agency->city }}
        </li>
        <li>Auprès de l’agence où est ouvert votre compte.</li>
    </ul>
    <p>
        Enfin, vous avez le droit d’introduire une réclamation auprès de la Commission Nationale de l’Informatique et des Libertés (CNIL),
        autorité de contrôle en France en charge du respect des obligations en matière de données à caractère personnel.
    </p>
    <div class="page-break"></div>
@endsection

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&amp;subset=all' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ public_path() }}/css/pdf.css">

</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ public_path() }}/storage/logo/logo_long_color_540.png" alt="{{ $agence->name }}">
        </div>
        <div style="margin: 20px; text-align: left" class="fs-2 text-start">
            <strong>Agence:</strong><br>
            {{ $agence->name }}<br>
            {{ $agence->address }}<br>
            {{ $agence->postal }} {{ $agence->city }}<br><br>
            <strong>Téléphone: </strong>{{ $agence->phone }}
        </div>
        <div class="date">Le {{ isset($document) ? $document->created_at->format('d/m/Y') : now()->format('d/m/Y') }}</div>
        <div class="address_customer">
            {{ $reseller->dab->name }}<br>
            {{ $reseller->dab->address }}<br>
            {{ $reseller->dab->postal }} {{ $reseller->dab->city }}<br>
        </div>
    </header>
    <footer>
        <table style="width: 100%">
            <tbody>
            <tr>
                <td style="width: 33%;">
                    {{ config('app.name') }} - Agence {{ $agence->name }} - {{ $agence->address }}, {{ $agence->postal }} {{ $agence->city }}
                </td>
                <td style="width: 33%; text-align: center">
                    {{ $title }}
                </td>
                <td style="width: 33%; text-align: right">
                    Page <span class="pagenum"></span>
                </td>
            </tr>
            </tbody>
        </table>
    </footer>
    <div class="separator separator-dotted border-2 border-bank mb-10"></div>
    <div class="text-center fs-3 fs-underline">CONTRAT DISTRIBUTEUR</div>
    <div class="text-center fs-3">CONDITIONS PARTICULIERES</div>
    <div class="mt-10 mb-10 text-center" style="border: solid 2px #000000; background-color: #a4a4a4">IDENTIFICATION DU TITULAIRE</div>
    <table style="width: 100%;">
        <tbody>
        <tr>
            <td style="width: 100%;">
                <table style="width: 100%;" class="table table-rounded border">
                    <tbody>
                    <tr class="border-bottom border-gray-200">
                        <td style="width: 50%; font-weight:bold;">Raison Social</td>
                        <td style="width: 50%;">{{ $reseller->dab->name }}</td>
                    </tr>
                    <tr class="border-bottom border-gray-200">
                        <td style="width: 50%; font-weight:bold;">Type</td>
                        <td style="width: 50%;">{{ $reseller->dab->type_string }}</td>
                    </tr>
                    <tr class="border-bottom border-gray-200">
                        <td style="width: 50%; font-weight:bold;">Adresse Postal</td>
                        <td style="width: 50%;">
                            {{ $reseller->dab->address }}<br>
                            {{ $reseller->dab->postal }} {{ $reseller->dab->ville }}
                        </td>
                    </tr>
                    <tr class="border-bottom border-gray-200">
                        <td style="width: 50%; font-weight:bold;">Coordonnée</td>
                        <td style="width: 50%;">
                            <strong>Téléphone:</strong> {{ $reseller->dab->phone }}<br>
                            <strong>Adresse Mail:</strong> {{ $reseller->user->email }}<br>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="mt-10 mb-10 text-center" style="border: solid 2px #000000; background-color: #a4a4a4">INFORMATION CONTRACTUEL</div>
    <table style="width: 100%;">
        <tbody>
        <tr>
            <td style="width: 100%;">
                <table style="width: 100%;" class="table table-rounded border">
                    <tbody>
                    <tr class="border-bottom border-gray-200">
                        <td style="width: 50%; font-weight:bold;">Date d'ouverture du contrat</td>
                        <td style="width: 50%;">{{ now()->format('d/m/Y') }}</td>
                    </tr>
                    <tr class="border-bottom border-gray-200">
                        <td style="width: 50%; font-weight:bold;">Limite de retrait</td>
                        <td style="width: 50%;">{{ eur($reseller->limit_outgoing) }} / par jours</td>
                    </tr>
                    <tr class="border-bottom border-gray-200">
                        <td style="width: 50%; font-weight:bold;">Limite de Dépot</td>
                        <td style="width: 50%;">{{ eur($reseller->limit_incoming) }} / par jours</td>
                    </tr>
                    <tr class="border-bottom border-gray-200">
                        <td style="width: 50%; font-weight:bold;">Commission</td>
                        <td style="width: 50%;">3,75 % par transaction (retrait/dépot)</td>
                    </tr>
                    <tr class="border-bottom border-gray-200">
                        <td style="width: 50%; font-weight:bold;">Matériel à disposition</td>
                        <td style="width: 50%;">TPE Distributeur</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="table table-rounded border gy-7 gs-7 m-10 w-100">
        <thead>
        <tr class="fw-bolder fs-3 text-gray-800 border-bottom border-gray-200 text-center">
            <th>Le titulaire</th>
            <th>La banque {{ $agence->name }}</th>
        </tr>
        </thead>
        <tbody>
        <tr class="h-50px">
            <td class="text-center fs-2">
                Signé éléctroniquement le {{ now()->format('d/m/Y') }}.<br>{{ $reseller->dab->name }}
            </td>
            <td class="text-center fs-2">
                Signé éléctroniquement le {{ now()->format('d/m/Y') }} par la banque
            </td>
        </tr>
        </tbody>
    </table>
</body>
</html>

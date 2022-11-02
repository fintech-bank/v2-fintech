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
    <table class="table w-10" style="margin-bottom: 20px;">
        <tbody>
            <tr class="mb-10">
                <td class="w-10"><div class="fw-bolder fs-4">Facture #{{ $invoice->reference }}</div></td>
            </tr>
            <tr class="mb-10">
                <td class="w-5">
                    <div class="text-muted">Date de la facture</div>
                    <div class="fw-bold fs-3">{{ $invoice->created_at->format('d/m/Y') }}</div>
                </td>
                <td class="w-5">
                    <div class="text-muted">Echéance</div>
                    <div class="fw-bold fs-3">
                        {{ $invoice->due_at->format('d/m/Y') }}
                        @if($invoice->due_at->startOfDay() == now()->startOfDay())
                        <span class="fs-2 text-danger d-flex align-items-center">
                            <span class="bullet bullet-dot bg-danger me-2"></span>
                            Echue {{ $invoice->due_at->shortAbsoluteDiffForHumans() }}
                        </span>
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td class="w-5">
                    <div class="text-muted">Facturé à</div>
                    <div class="fw-bold fs-3">
                        {{ $reseller->dab->name }}<br>
                        {{ $reseller->dab->address }}<br>
                        {{ $reseller->dab->postal }} {{ $reseller->dab->city }}<br>
                    </div>
                </td>
                <td class="w-5">
                    <div class="text-muted">De:</div>
                    <div class="fw-bold fs-3">
                        {{ $agence->name }}<br>
                        {{ $agence->address }}<br>
                        {{ $agence->postal }} {{ $agence->city }}<br>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>Désignation</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->products as $product)
                <tr>
                    <td>{{ $product->label }}</td>
                    <td class="text-end">{{ $product->amount_format }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="align-items-center">
                <td class="text-end">Total</td>
                <td class="text-end fs-4 fw-bolder text-info">{{ $invoice->amount_format }}</td>
            </tr>
        </tfoot>
    </table>
    <p style="margin-top: 15px;">
        Le Montant de <span class="fw-bolder text-info">{{ $invoice->amount_format }}</span> vous sera crédité sur votre compte bancaire dans le 48H.<br>
        Vous serez alerté lors de son envoie.
    </p>
</body>
</html>

@extends('pdf.layouts.app')

@section("content")
    <div class="fs-4 fw-bolder uppercase text-center">FORMULAIRE DE RETRACTATION</div>
    <p class="text-center">Formulaire relatif au délai de renonciation prévu par les articles L112-2-1 et L132-5-1 du code des assurances</p>
    <p>
        A renvoyer au plus tard trente jours calendaires révolus après la dernière des dates d'acceptation du contrat.<br>
        Si ce délai expire un samedi, un dimanche ou un jour férié ou chômé, il ne sera pas prorogé.
    </p>
    <p>
        La présente renonciation n'est valable que si elle est adressée, lisiblement et dûment remplie, avant l'expiration des délais
        rappelés ci-dessus à {{ config('app.name') }} - Service Relations Clients - 4 Rue du Coudraix - 44000 Nantes Cedex 4.
    </p>
    <p>
        Je soussigné(e)(s) {{ $customer->info->full_name }}<br>
        déclare renoncer à l'adhésion de mon contrat d'assurance {{ $data->insurance->package->name }} - {{ $data->insurance->form->name }} N°{{ $data->insurance->reference }}<br>
        que j'avais acceptée le {{ $data->insurance->date_member->format("d/m/Y") }}.
    </p>
    <p>
        Je vous prie de bien vouloir me rembourser l'intégralité de mon ou mes versements, et ce, dans un délai maximum de trente jours à compter de la réception de la présente.<br>
        J'ai bien noté que dès réception de la présente par {{ config('app.name') }}, la garantie de mon adhésion prend fin.
    </p>
    <p>Date:</p>
    <p>Signature:</p>
@endsection

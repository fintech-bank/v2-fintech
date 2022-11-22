@extends('pdf.layouts.app')

@section("content")
    <div class="m-5 fs-1">
        <div class="fw-bolder">Numéro de pret personnel</div>
        {{ $data->loan->reference }}
    </div>
    <table style="width: 90%; margin-right: auto; margin-left: auto;">
        <tbody>
            <tr>
                <td style="width: 43%; margin-right: 10px">
                    <table class="table gy-5 gs-5" style="border: solid 2px #000000; height: auto">
                        <tbody>
                        <tr style="border: none">
                            <td class="fw-bolder">Capital prété:</td>
                            <td class="text-right">{{ eur($data->loan->amount_loan) }}</td>
                        </tr>
                        <tr style="border: none">
                            <td class="fw-bolder">Taux:</td>
                            <td class="text-right">
                                @if($data->loan->plan->tarif->type_taux == 'fixe')
                                    {{ $data->loan->plan->tarif->interest }} %
                                @else
                                    {{ \App\Helper\CustomerLoanHelper::calcLoanIntestVariableTaxe($data->loan) }} %
                                @endif
                            </td>
                        </tr>
                        <tr style="border: none">
                            <td class="fw-bolder">Durée:</td>
                            <td class="text-right">{{ $data->loan->duration }} mois</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td>&nbsp;</td>
                <td style="width: 43%;">
                    <table class="table gy-5 gs-5" style="border: solid 2px #000000; height: auto">
                        <tbody>
                        <tr>
                            <td class="fw-bolder">Frais de dossier:</td>
                            <td class="text-right">{{ eur(0) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="fs-1">
                                <p class="fw-bolder">Rappel:</p>
                                <ul>
                                    <li>Les intérés sont calculé dès la mise à disposition des fonds</li>
                                    <li>Ce tableau d'amortissement ne donne en aucun
                                        cas le solde restant dù de votre prét, cette
                                        information est disponible sur votre espace de
                                        banque à distance dans la rubrique > mes crédits
                                        ou auprès de votre conseiller</li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 90%; margin-right: auto; margin-left: auto; border: solid 1px; margin-bottom: 10px">
        <tbody>
            <tr>
                <td class="text-center fw-bolder">TABLEAU D'AMORTISSEMENT THEORIQUE</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-striped table-bordered fs-1 gy-5 gs-5">
        <thead>
            <tr>
                <th class="text-center">N° Echéance</th>
                <th class="text-center">Date d'échéance</th>
                <th class="text-center">Montant Mensualité</th>
                <th class="text-center">Capital Restant dù</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data->credit->amortissements as $amortissement)
                <tr>
                    <td>{{ $amortissement->id }}</td>
                    <td>{{ $amortissement->date_prlv->format("d/m/Y") }}</td>
                    <td>{{ $data->loan->mensuality }}</td>
                    <td>{{ eur(($data->loan->amount_du-$data->loan->mensuality) / $i ) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

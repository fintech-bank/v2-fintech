@extends('pdf.layouts.app')

@section("content")
    <table class="w-100">
        <tbody>
            <tr>
                <td>
                    <div class="fw-bolder fs-4 uppercase">RELEVÉ DES OPÉRATIONS</div>
                </td>
                <td class="text-end">
                    N° {{ $data->wallet->number_account }}<br>
                    <div class="fw-bolder">du {{ now()->startOfMonth()->format('d/m/Y') }} au {{ now()->endOfMonth()->format('d/m/Y') }}</div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="separator mt-2 mb-5"></div>
    <table class="table table-borderless border border-2 table-sm table-striped gx-4">
        <thead>
            <tr>
                <th>Date</th>
                <th>Valeur</th>
                <th>Nature de l'opération</th>
                <th>Débit</th>
                <th>Crédit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data->wallet->transactions()->where('confirmed', true)->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])->get() as $transaction)
                <tr>
                    <td>{{ $transaction->confirmed_at->format("d/m/Y") }}</td>
                    <td>{{ $transaction->updated_at->format("d/m/Y") }}</td>
                    <td class="w-50">
                        {{ $transaction->designation }}<br>
                        <i>{{ $transaction->description }}</i>
                    </td>
                    <td class="text-end">
                        @if($transaction->amount <= 0)
                            {{ $transaction->amount_format }}
                        @endif
                    </td>
                    <td class="text-end">
                        @if($transaction->amount > 0)
                            {{ $transaction->amount_format }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="fw-bolder border">
                <td colspan="3" class="text-end w-230px">TOTAUX DES MOUVEMENTS</td>
                <td class="text-end">
                    {{ \Illuminate\Support\Str::replace('-', '', $data->wallet->getSumDebitForRelever()) }}
                </td>
                <td class="text-end">
                    {{ \Illuminate\Support\Str::replace('-', '', $data->wallet->getSumCreditForRelever()) }}
                </td>
            </tr>
            <tr class="fw-bolder border">
                <td colspan="3" class="text-end w-230px">Nouveau solde au {{ now()->format('d/m/Y') }}</td>
                <td class="text-end">
                    @if($data->wallet->getSumAllMvmForRelever() < 0)
                        - {{ eur($data->wallet->getSumAllMvmForRelever()) }}
                    @endif
                </td>
                <td class="text-end">
                    @if($data->wallet->getSumAllMvmForRelever() >= 0)
                        + {{ eur($data->wallet->getSumAllMvmForRelever()) }}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
@endsection

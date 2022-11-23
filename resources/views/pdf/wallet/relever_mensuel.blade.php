@extends('pdf.layouts.app')

@section("content")
    <div class="fw-bolder fs-4 uppercase">RELEVÉ DES OPÉRATIONS</div>
    <div class="separator my-2"></div>
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
                    <td>
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
    </table>
@endsection

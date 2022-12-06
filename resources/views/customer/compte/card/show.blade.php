@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="d-flex flex-wrap align-items-center w-75 rounded rounded-2 bg-white p-5 mb-10">
            <div class="d-flex flex-row align-items-center">
                <div class="w-50 me-5">
                    <img src="/storage/card/{{ $card->support->slug }}.png" alt="" class="img-fluid m-0 p-0">
                </div>
                <div class="w-50 align-items-center">
                    <div class="d-flex flex-center align-items-center">
                        <div class="d-flex flex-column align-items-center">
                            <div class="fw-bolder fs-2">CB VISA</div>
                            {{ $card->debit_format }}
                            <a href="{{ route('customer.compte.wallet', $card->wallet->uuid) }}" class="btn btn-link">{{ $card->wallet->name_account_generic }}</a>
                            @if($card->status == 'active')
                                <button class="btn btn-circle btn-outline btn-outline-dark mb-5">Verrouiller ma carte</button>
                            @else
                                <button class="btn btn-circle btn-outline btn-outline-dark mb-5">Deverrouiller ma carte</button>
                            @endif
                            @if($card->status != 'opposit')
                                <button class="btn btn-circle btn-outline btn-outline-danger mb-5">Faire opposition</button>
                            @else
                                <a href="" class="btn btn-link mb-5">Dossier {{ $card->opposition->reference }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Gérer mes plafonds</h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <div class="d-flex align-items-center flex-column mt-3 w-75">
                        <div class="d-flex justify-content-between fw-bold fs-6 opacity-75 w-100 mt-auto mb-2">
                            <span>Plafond de paiement mensuel <span class="text-muted fs-8">(jusqu'au {{ now()->endOfMonth()->format("d/m/Y") }})</span></span>
                            <span>{{ eur($card->limit_payment) }}</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-black bg-opacity-75 rounded">
                            <div class="bg-success rounded h-8px" role="progressbar" style="width: {{ $card->getTransactionsMonthPayment(true) }}%;" aria-valuenow="{{ $card->getTransactionsMonthPayment(true) }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-6 opacity-75 w-100 mt-auto mb-2">
                            <span class="text-success fw-bolder">Utilisé: {{ eur($card->getTransactionsMonthPayment()) }}</span>
                            <span>Restant: {{ eur($card->limit_payment - $card->getTransactionsMonthPayment()) }}</span>
                        </div>
                    </div>
                    <a href="" class="btn btn-link"><i class="fa-solid fa-edit text-dark me-2"></i> Modifier</a>
                </div>
                <div class="separator separator-dashed my-5"></div>
                <div class="d-flex flex-row justify-content-between">
                    <div class="fw-bolder">Capacité de retrait (France et étranger) <span class="text-muted fs-9">sur 7 jours glissants</span></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.index")
@endsection

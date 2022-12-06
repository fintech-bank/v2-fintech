@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="row">
            <div class="col-md-9 col-sm-12 mb-10">
                @if($wallets->where('type', 'compte')->count() != 0)
                    <div class="fs-1 fw-bold text-primary uppercase mb-3"><i class="fa-solid fa-wallet fs-1 me-2 text-primary"></i> Comptes bancaires</div>
                    @foreach($wallets->where('type', 'compte') as $wallet)
                        <a href="{{ route('customer.compte.wallet', $wallet->uuid) }}" class="d-flex flex-row justify-content-between align-items-center p-5 rounded border border-2 bg-gray-300 text-black hover-zoom">
                        <span class="d-flex flex-row fs-2">
                            <span class="fw-bolder">Compte bancaire</span>
                            <span class="text-muted">{{ Str::mask($wallet->number_account, '.', 0, 5) }}</span>
                        </span>
                            <span class="d-flex flex-row align-items-center">
                            <span class="me-10">{!! $wallet->status_label !!}</span>
                            <span class="fs-2 fw-bolder">{{ eur($wallet->solde_remaining) }}</span>
                        </span>
                        </a>
                        <div class="ms-8">
                            @foreach($wallet->cards as $card)
                                <a href="{{ route('customer.compte.card.show', $card->id) }}" class="d-flex flex-row justify-content-between align-items-center p-5 rounded border border-2 bg-gray-300 text-black hover-zoom">
                                <span class="d-flex flex-row fs-2 align-items-center">
                                    <span class="symbol symbol-30px symbol-2by3">
                                        <img src="/storage/card/{{ $card->support->slug }}.png" alt="">
                                    </span>
                                    <span class="fw-bolder">CB Visa </span>
                                    <span class="text-muted">{{ $card->number_card_oscure }}</span>
                                </span>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                @endif
                @if($wallets->where('type', 'epargne')->count() != 0)
                    <div class="separator separator-dashed border-gray-600 my-10"></div>
                    <div class="fs-1 fw-bold text-warning uppercase mb-3"><i class="fa-solid fa-coins fs-1 me-2 text-warning"></i> Comptes Epargne</div>
                    @foreach($wallets->where('type', 'epargne') as $wallet)
                        <a href="{{ route('customer.compte.wallet', $wallet->uuid) }}" class="d-flex flex-row justify-content-between align-items-center p-5 rounded border border-2 bg-gray-300 text-black hover-zoom">
                            <span class="d-flex flex-row fs-2">
                                <span class="fw-bolder">Compte épargne</span>
                                <span class="text-muted">{{ Str::mask($wallet->number_account, '.', 0, 5) }}</span>
                            </span>
                            <span class="d-flex flex-row">
                                <span class="me-10">{!! $wallet->status_label !!}</span>
                                <span class="fs-2 fw-bolder">{{ eur($wallet->solde_remaining) }}</span>
                            </span>
                        </a>
                    @endforeach
                @endif
                @if($wallet->where('type', 'pret')->count() != 0)
                    <div class="separator separator-dashed border-gray-600 my-10"></div>
                    <div class="fs-1 fw-bold text-warning uppercase mb-3"><i class="fa-solid fa-hand-holding-dollar fs-1 me-2 text-warning"></i> Crédit</div>
                    @foreach($wallets->where('type', 'pret') as $wallet)
                        <a href="{{ route('customer.compte.wallet', $wallet->uuid) }}" class="d-flex flex-row justify-content-between align-items-center p-5 rounded border border-2 bg-gray-300 text-black hover-zoom">
                            <span class="d-flex flex-row fs-2">
                                <span class="fw-bolder">Crédit</span>
                                <span class="text-muted">{{ Str::mask($wallet->number_account, '.', 0, 5) }}</span>
                            </span>
                            <span class="d-flex flex-row">
                                <span class="me-10">{!! $wallet->status_label !!}</span>
                            </span>
                        </a>
                    @endforeach
                @endif
                    <div class="separator separator-dashed border-gray-600 my-15"></div>
                @if($customer->setting->cashback)
                        <a href="{{ route('customer.compte.wallet', $wallet->uuid) }}" class="d-flex flex-column justify-content-between align-items-center p-5 rounded border border-2 bg-gray-300 text-black hover-zoom">
                            <span class="d-flex flex-row justify-content-between align-items-center">
                                <span class="d-flex flex-row fs-2">
                                    <span class="fw-bolder">Ma Cagnotte</span>
                                </span>
                                <span class="d-flex flex-row">
                                    <span class="fs-2 fw-bolder">{{ eur($cashback->balance) }}</span>
                                </span>
                            </span>
                            <span class="d-flex flex-column">
                                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
									<div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
                            </span>
                        </a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.index")
@endsection

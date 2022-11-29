@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="d-flex flex-row justify-content-between align-items-center bg-light-primary rounded m-0 p-5">
            <div class="d-flex flex-column text-white">
                <strong>Les offres du moment</strong>
                <div class="">Découvez vos avantages</div>
            </div>
            <button class="btn btn-circle btn-lg btn-primary">J'en profite</button>
        </div>
        <div class="mt-10">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 rounded shadow-lg">
                                @foreach($customer->wallets()->where('status', 'active')->get() as $wallet)
                                    @if($wallet->type == 'compte')
                                        <a href="{{ route('customer.compte.wallet', $wallet->uuid) }}" class="d-flex flex-row align-items-center text-black">
                                            <div class="d-flex flex-row">
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label fs-2 fw-semibold bg-light-success text-inverse-success"><i class="fa-solid fa-wallet text-success"></i> </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <strong>{{ $wallet->name_account_generic }}</strong>
                                                    {{ $wallet->type_text }}
                                                </div>
                                            </div>
                                            <span class="text-{{ $wallet->solde_remaining >= 0 ? 'success' : 'danger' }} d-flex flex-end">{{ $wallet->solde_remaining >= 0 ? "+ ".eur($wallet->solde_remaining) : -eur($wallet->solde_remaining) }}</span>
                                        </a>
                                    @elseif($wallet->type == 'epargne')
                                        <a href="{{ route('customer.compte.wallet', $wallet->uuid) }}" class="d-flex flex-row align-items-center text-black">
                                            <div class="d-flex flex-row">
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label fs-2 fw-semibold bg-light-info text-inverse-success"><i class="fa-solid fa-coins text-info"></i> </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <strong>{{ $wallet->name_account_generic }}</strong>
                                                    {{ $wallet->type_text }}
                                                </div>
                                            </div>
                                            <span class="text-{{ $wallet->solde_remaining >= 0 ? 'success' : 'danger' }} d-flex flex-end">{{ $wallet->solde_remaining >= 0 ? "+ ".eur($wallet->solde_remaining) : -eur($wallet->solde_remaining) }}</span>
                                        </a>
                                    @else
                                        <a href="{{ route('customer.compte.wallet', $wallet->uuid) }}" class="d-flex flex-row align-items-center text-black">
                                            <div class="d-flex flex-row">
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label fs-2 fw-semibold bg-light-primary text-inverse-success"><i class="fa-solid fa-file-contract text-primary"></i> </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <strong>{{ $wallet->name_account_generic }}</strong>
                                                    {{ $wallet->type_text }}
                                                </div>
                                            </div>
                                            <span class="text-{{ $wallet->solde_remaining >= 0 ? 'success' : 'danger' }} d-flex flex-end">{{ $wallet->solde_remaining >= 0 ? "+ ".eur($wallet->solde_remaining) : -eur($wallet->solde_remaining) }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="#" class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3">
                                        <i class="fa-solid fa-cogs fs-2"></i>
                                        <span class="fw-semibold">Paramétrer mes comptes</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.dashboard")
@endsection

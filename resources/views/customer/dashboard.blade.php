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
                                        <div class="d-flex flex-row">
                                            <div class="symbol symbol-50px me-3">
                                                <div class="symbol-label fs-2 fw-semibold bg-success text-inverse-success"><i class="fa-solid fa-wallet"></i> </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <strong>{{ $wallet->name_account_generic }}</strong>
                                                {{ $wallet->type_text }}
                                            </div>
                                        </div>
                                        {{ eur($wallet->solde_remaining >= 0 ? $wallet->solde_remaining : -$wallet->solde_remaining) }}
                                    @elseif($wallet->type == 'epargne')

                                    @else

                                    @endif
                                @endforeach
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

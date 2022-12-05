@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="row">
            <div class="col-md-9 col-sm-12 mb-10">
                <div class="fs-1 fw-bold text-primary uppercase">Comptes bancaires</div>
                @foreach($wallets->where('type', 'compte')->get() as $wallet)
                    <a href="" class="btn btn-flex  btn-secondary px-5 w-100">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="d-flex flex-row">
                                <span class="fw-bolder">Compte Bancaire <span class="text-muted">{{ Str::mask($wallet->number_account, 0, 5) }}</span></span>
                            </span>
                            <span class="d-flex flex-row">
                                {{ eur($wallet->solde_remaining) }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.index")
@endsection

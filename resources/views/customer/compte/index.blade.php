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
                    <a href="" class="d-flex flex-row justify-content-between align-items-center p-5 rounded border border-2 bg-gray-300">
                        <span class="d-flex flex-row fs-2">
                            <span class="fw-bolder">Compte bancaire</span>
                            <span class="text-muted">{{ Str::mask($wallet->number_account, '.', 0, 5) }}</span>
                        </span>
                        <span class="d-flex flex-row">
                            <span class="fs-2 fw-bolder">{{ eur($wallet->solde_remaining) }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.index")
@endsection

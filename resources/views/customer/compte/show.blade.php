@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="d-flex flex-center flex-column">
                    <div class="uppercase fs-1">Solde au {{ $wallet->transactions()->orderBy('updated_at', 'desc')->first() ? $wallet->transactions()->orderBy('updated_at', 'desc')->first()->updated_at->format('d/m/Y') : now() }}</div>
                    <div class="fw-bolder fs-2hx">{{ $wallet->solde_remaining >= 0 ? "+ ".eur($wallet->solde_remaining) : "- ".eur($wallet->solde_remaining)}}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.index")
@endsection

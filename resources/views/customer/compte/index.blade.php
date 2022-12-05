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
                    <a href="" class="d-flex flex-row justify-content-between align-items-center py-5 rounded border border-2 bg-gray-300">
                        <span class="d-flex flex-row">
                            <span class="fw-bolder">Compte bancaire</span>
                            <span class="text-muted">{{ Str::mask($wallet->number_account, '.', 0, 5) }}</span>
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

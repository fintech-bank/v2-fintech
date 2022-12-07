@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Carte Bancaire {{ $card->full_info }} - Opposition sur la carte</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex flex-column">
                                <div class="fs-2 fw-bolder uppercase">Référence</div>
                                <div class="">{{ $card->opposition->reference }}</div>
                            </div>
                        </div>
                        <div class="separator separator-dotted border-gray-600 my-5"></div>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex flex-column">
                                <div class="fs-2 fw-bolder uppercase">Type d'opposition</div>
                                <div class="">{{ Str::ucfirst($card->opposition->type) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="vr w-1px"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.card.opposit")
@endsection

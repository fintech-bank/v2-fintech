@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Pack {{ $customer->package->name }}</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid {{ $customer->package->icon }} text-{{ $customer->package->color }} me-3"></i> {{ $customer->package->name }}</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-light">
                                Mettre à jour
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-between border-bottom-2 border-gray-400">
                            <strong>Tarif</strong>
                            {{ $customer->package->price_format }} / par mois
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.paystar")
@endsection

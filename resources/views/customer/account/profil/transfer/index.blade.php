@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Transfert Agence simple</h1>
        <!--end::Title-->
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--begin::Secondary button-->
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#addTransferAgency">Nouvelle demande de transfert</a>
        <!--end::Secondary button-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        @if($customer->transfer)
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-spinner fa-spin-pulse fs-2 text-warning me-2"></i> Transfert d'agence en cours...</h3>
                    <div class="card-toolbar">

                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        @endif
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.transfer.index")
@endsection

@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Service Transbank</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <p class="fw-bolder fs-2">Transférez les virements et prélévements récurrents de votre ancien compte sur votre compte Société Générale</p>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.mobility.index")
@endsection

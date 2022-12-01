@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Sécurité</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="text-center">
            <div class="fs-2tx uppercase">Profil de {{ auth()->user()->customers->info->full_name }}</div>
            <div class="fs-1">Gérez ici vos moyens de sécurité : code secret, numéro de téléphone sécurité et Pass Sécurité.</div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Cashback {{ config('app.name') }}</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <p>Vous allez être rediriger vers le service Cashback By {{ config('app.name') }}, ce site regroupe tous avantages que {{ config('app.name') }} vous offre sur plusieurs magasins et marques en france.</p>
        <p>En accédant à ce service, vous autorisez {{ config('app.name') }} à transmettre certaine donnée personnelle au service Cashback By {{ config('app.name') }}.</p>
        <div class="d-flex flex-center flex-row justify-content-center">
            <button class="btn btn-circle btn-outline btn-outline-primary">J'accepte</button>
            <a href="{{ route('customer.account.profil.index') }}" class="btn btn-circle btn-outline btn-outline-dark">Annuler</a>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

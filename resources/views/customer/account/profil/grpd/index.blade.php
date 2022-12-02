@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Gestion des données personnelles</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="text-center mb-10">
            <div class="fs-2tx">Maîtrisez le traitement de vos données personnelles et exercez vos droits</div>
            <div class="fs-1">{{ config('app.name') }} met cet espace à votre disposition pour vous permettre de garder la maîtrise de vos données personnelles et d’exercer vos droits concernant leur traitement.</div>
        </div>
        <div class="d-flex flex-center rounded border border-gray-300 justify-content-center">
            <div class="fs-1">0</div>
            <div class="fs-3">Demande</div>
            <button class="btn btn-circle btn-lg btn-bank" disabled>Voir mes demandes</button>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

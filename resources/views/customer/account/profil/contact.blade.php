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
        <x-base.underline
            title="Profil de {{ $customer->info->full_name }}"
            size="4"
            size-text="fs-2hx"
            color="bank"
            class="w-100 my-5 uppercase" />


        <x-base.underline
            title="Adresse e-mail"
            size="4"
            size-text="fs-1"
            color="secondary"
            class="w-100 my-5" />

        <p class="fw-bolder">Pour mieux vous accompagner au quotidien comme dans vos projets d’avenir, nous souhaitons recueillir votre adresse e-mail. Vous serez ainsi informé de nos actualités et de nos offres promotionnelles susceptibles de vous intéresser.</p>
        <div class="d-flex flex-row justify-content-around">
            <div class="">Adresse e-mail personnel</div>
            <div class="">{{ $customer->user->email }}</div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

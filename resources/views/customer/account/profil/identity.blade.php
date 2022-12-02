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
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

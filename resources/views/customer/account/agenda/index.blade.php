@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Mes rendez-vous</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="d-flex flex-center w-100">
            <x-base.underline
                title="<i class='fa-solid fa-calendar fs-2'></i>" />
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.agenda.index")
@endsection

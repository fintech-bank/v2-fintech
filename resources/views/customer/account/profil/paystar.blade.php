@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Paystar</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        @if($customer->setting->paystar == 1)
            <div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
                <i class="fa-solid fa-exclamation-circle text-danger fs-5tx mb-5"></i>
                <div class="text-center text-dark">
                    <h1 class="fw-bold mb-5">Accès Refuser</h1>
                    <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                    <div class="mb-9">
                        Votre compte ne permet pas l'établissement du système Paystar.<br>
                        Veuillez mettre à jour votre souscription ou contacter votre conseiller afin d'activer la fonctionnalité.
                    </div>
                    <!--begin::Buttons-->
                    <div class="d-flex flex-center flex-wrap">
                        <a href="#" class="btn btn-danger m-2">Mettre à jour ma souscription</a>
                    </div>
                    <!--end::Buttons-->
                </div>
                <!--end::Content-->
            </div>
        @else

        @endif
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

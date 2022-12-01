@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Mon profil & Sécurité</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="text-center fw-bolder fs-2hx mb-5">Mes Données Personnelles</div>
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <a href="" class="bg-white shadow-lg p-10 rounded text-black">
                    <div class="d-flex flex-row justify-content-between mb-5 align-items-center">
                        <div class="fs-1 fw-bold">Sécurité</div>
                        <div>
                            <i class="fa-solid fa-desktop text-black fs-2x me-2"></i>
                            <i class="fa-solid fa-mobile text-muted fs-2x me-2"></i>
                        </div>
                    </div>
                    <p>Gérez vos moyens de sécurité : code secret, numéro de téléphone sécurité et Pass Sécurité</p>
                    <div class="text-end">
                        <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

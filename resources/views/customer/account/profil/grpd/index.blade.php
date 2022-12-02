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
        <div class="d-flex flex-center rounded border border-gray-300 py-10">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="fs-2hx fw-light">0</div>
                <div class="fs-5">Demande</div>
                <button class="btn btn-circle btn-lg btn-bank" disabled>Voir mes demandes</button>
            </div>
        </div>

        <div class="separator separator-dotted separator-content border-dark my-15"><span class="h1">Vos préférences</span></div>

        <div class="row">
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <a href="" class="text-black fs-2 w-50">Exprimer votre consentement à l’utilisation de certaines de vos données personnelles</a>
                        <a href=""><i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <a href="" class="text-black fs-2 w-50">Personnaliser vos préférences de contact pour la réception d’offres commerciales</a>
                        <a href=""><i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

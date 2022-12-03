@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Mon service personnage</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="d-flex flex-row shadow-lg rounded-lg h-250px align-items-center">
            <img src="https://particuliers.societegenerale.fr/icd/static/pad-front/1.4.6/dist/56460d72d382792f547ce6d80bef19aa.png" alt="">
            <div class="d-flex flex-column p-5">
                <div class="fw-bolder fs-2 mb-5">Offre parrainage</div>
                <div class="fs-1 mb-5">Parrainez un proche et recevez tous les deux 80 €*</div>
                <button class="btn btn-circle btn-primary">Parrainer un proche</button>
            </div>
        </div>
    </div>

@endsection

@section("script")
    @include("customer.scripts.account.profil.sponsorship")
@endsection

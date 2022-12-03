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
        <div class="d-flex flex-row shadow-lg rounded-lg h-250px">
            <img src="https://particuliers.societegenerale.fr/icd/static/pad-front/1.4.6/dist/56460d72d382792f547ce6d80bef19aa.png" alt="">
            <div class="d-flex flex-column p-5">
                <div class="fw-bolder fs-2 mb-5">Offre parrainage</div>
                <div class="fs-1 mb-5">Parrainez un proche et recevez tous les deux 80 €*</div>
                <button class="btn btn-circle btn-primary" data-bs-toggle="modal" data-bs-target="#Sponsorship">Parrainer un proche</button>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="Sponsorship">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Votre filleul</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formSponsorship" action="" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <p>Pour bénéficier de l’offre de parrainage, votre filleul doit être majeur et non-client Société Générale.</p>
                        <div class="d-flex flex-row flex-center mb-10">
                            <x-form.radio
                                name="civility"
                                value="M"
                                for="Monsieur"
                                label="Monsieur" />

                            <x-form.radio
                                name="civility"
                                value="Mme"
                                for="Madame"
                                label="Madame" />

                            <x-form.radio
                                name="civility"
                                value="Mlle"
                                for="Mademoiselle"
                                label="Mademoiselle" />
                        </div>
                        <x-form.input
                            name="lastname"
                            label="Nom" />

                        <x-form.input
                            name="firstname"
                            label="Prénom" />

                        <x-form.input
                            type="email"
                            name="email"
                            label="Adresse Mail" />

                    </div>
                    <div class="modal-footer text-end">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.sponsorship")
@endsection

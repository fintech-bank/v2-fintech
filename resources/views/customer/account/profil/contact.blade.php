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
        <div class="d-flex flex-row justify-content-around mb-10">
            <div class="">Adresse e-mail personnel {!! $customer->user->email_verified !!}</div>
            <div class="">{{ $customer->user->email }}</div>
        </div>
        <div class="d-flex flex-center justify-content-center w-50 mx-auto">
            <div class="alert bg-light-primary d-flex align-items-center p-5 mb-10">
                <i class="fa-solid fa-info-circle fs-2hx text-white me-4"></i>
                <div class="d-flex flex-column text-white">
                    <span>Une adresse e-mail à jour est nécessaire pour s’assurer de recevoir toutes nos communications. Nous vous invitons donc à la renseigner ou la modifier si nécessaire.</span>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap justify-content-end">
            <button class="btn btn-circle btn-lg btn-secondary">Modifier</button>
        </div>
        <div class="separator separator-dashed border-gray-300 my-5"></div>
        <x-base.underline
            title="Téléphones"
            size="4"
            size-text="fs-1"
            color="secondary"
            class="w-100 mb-5" />

        <div class="d-flex flex-row justify-content-around mb-10">
            <div class="">Téléphone Sécurisé <i class="fa-solid fa-lock ms-3"></i></div>
            <div class="">{{ $customer->info->mobile }}</div>
        </div>
        <div class="d-flex flex-wrap justify-content-end mb-5">
            <a href="{{ route('customer.account.profil.security.index') }}" class="btn btn-circle btn-lg btn-secondary">Modifier</a>
        </div>

        <div class="d-flex flex-row justify-content-around">
            <div class="">Mobile</div>
            <div class="">{{ $customer->info->mobile }}</div>
        </div>
        <div class="my-3"></div>
        <div class="d-flex flex-row justify-content-around">
            <div class="">Domicile</div>
            <div class="">{{ $customer->info->phone }}</div>
        </div>
        <div class="d-flex flex-wrap justify-content-end">
            <button class="btn btn-circle btn-lg btn-secondary">Modifier</button>
        </div>
        <div class="separator separator-dashed border-gray-300 my-5"></div>
        <x-base.underline
            title="Adresse"
            size="4"
            size-text="fs-1"
            color="secondary"
            class="w-100 mb-5" />

        <div class="d-flex flex-row ">
            <div class="w-50">N° et Voie</div>
            <div class="w-50">{{ $customer->info->address }}</div>
        </div>
        <div class="my-3"></div>
        <div class="d-flex flex-row">
            <div class="w-50">Complément</div>
            <div class="">{{ $customer->info->addressbis }}</div>
        </div>
        <div class="my-3"></div>
        <div class="d-flex flex-row">
            <div class="w-50">Code Postal</div>
            <div class="">{{ $customer->info->postal }}</div>
        </div>
        <div class="my-3"></div>
        <div class="d-flex flex-row">
            <div class="w-50">Ville</div>
            <div class="">{{ $customer->info->city }}</div>
        </div>
        <div class="my-3"></div>
        <div class="d-flex flex-row">
            <div class="w-50">Pays</div>
            <div class="">{{ $customer->info->country }}</div>
        </div>
        <div class="d-flex flex-wrap justify-content-end">
            <button class="btn btn-circle btn-lg btn-secondary">Modifier</button>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

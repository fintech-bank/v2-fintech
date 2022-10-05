<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Blazor, Django, Flask & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->
<head>
    <base href="../../../"/>
    <title>{{ config('app.name') }} - Création de compte</title>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="/css/app.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>body { background-image: url('/assets/media/auth/bg4.jpg'); } [data-theme="dark"] body { background-image: url('assets/media/auth/bg4-dark.jpg'); }</style>
    <!--end::Page bg image-->
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <!--begin::Body-->
        <div class="d-flex flex-center w-100 p-10">
            <!--begin::Card-->
            <div class="card rounded-3 w-100">
                <!--begin::Card body-->
                <div class="card-body p-10 p-lg-20">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="formLogin" action="{{ route('auth.register.package') }}" method="GET">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-dark fw-bolder mb-3">Choix de votre packs :</h1>
                            <!--end::Title-->

                        </div>

                        <!--begin::Heading-->
                        @if(session()->get('customer_type') == 'part')
                            <!--begin::Row-->
                                <div class="row g-10">
                                @foreach(\App\Models\Core\Package::where('type_cpt', 'part')->get() as $package)
                                    <!--begin::Col-->
                                        <div class="col">
                                            <div class="d-flex h-100 align-items-center">
                                                <!--begin::Option-->
                                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                                    <!--begin::Heading-->
                                                    <div class="mb-7 text-center">
                                                        <!--begin::Title-->
                                                        <h1 class="text-dark mb-5 fw-bolder">{{ $package->name }}</h1>
                                                        <!--end::Title-->
                                                        <!--begin::Price-->
                                                        <div class="text-center">
                                                            <span class="mb-2 text-primary"><i class="fa-solid fa-euro-sign text-primary"></i></span>
                                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">{{ $package->price }}</span>
                                                            <span class="fs-7 fw-semibold opacity-50">/<span data-kt-element="period">mois</span></span>
                                                        </div>
                                                        <!--end::Price-->
                                                    </div>
                                                    <!--end::Heading-->
                                                    <!--begin::Features-->
                                                    <div class="w-100 mb-10">
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Carte de Paiement VISA</span>
                                                            @if($package->visa_classic == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Dépot de chèque</span>
                                                            @if($package->check_deposit == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Paiement & Retrait</span>
                                                            @if($package->payment_withdraw == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Facilité de caisse</span>
                                                            @if($package->overdraft == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Dépot d'espèce</span>
                                                            @if($package->cash_deposit == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Retrait à l'internationnal</span>
                                                            @if($package->withdraw_international == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Paiement à l'internationnal</span>
                                                            @if($package->payment_international == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Assurance des paiement par carte bancaire</span>
                                                            @if($package->payment_insurance == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Chéquier</span>
                                                            @if($package->check == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Nombre de carte physique</span>
                                                            <span class="fs-6 text-gray-600">{{ $package->nb_carte_physique }}</span>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Nombre de carte Virtuel</span>
                                                            <span class="fs-6 text-gray-600">{{ $package->nb_carte_virtuel }}</span>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Sous comptes</span>
                                                            @if($package->subaccount == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!--end::Features-->
                                                    <!--begin::Select-->
                                                    <a href="{{ route('auth.register.card', ["package" => $package->id]) }}" class="btn btn-sm btn-bank">Choisir le compte {{ $package->name }}</a>
                                                    <!--end::Select-->
                                                </div>
                                                <!--end::Option-->
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    @endforeach
                                </div>
                                <!--end::Row-->
                        @else
                            <!--begin::Row-->
                                <div class="row g-10">
                                @foreach(\App\Models\Core\Package::where('type_cpt', 'pro')->get() as $package)
                                    <!--begin::Col-->
                                        <div class="col">
                                            <div class="d-flex h-100 align-items-center">
                                                <!--begin::Option-->
                                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                                    <!--begin::Heading-->
                                                    <div class="mb-7 text-center">
                                                        <!--begin::Title-->
                                                        <h1 class="text-dark mb-5 fw-bolder">{{ $package->name }}</h1>
                                                        <!--end::Title-->
                                                        <!--begin::Price-->
                                                        <div class="text-center">
                                                            <span class="mb-2 text-primary"><i class="fa-solid fa-euro-sign text-primary"></i></span>
                                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">{{ $package->price }}</span>
                                                            <span class="fs-7 fw-semibold opacity-50">/<span data-kt-element="period">mois</span></span>
                                                        </div>
                                                        <!--end::Price-->
                                                    </div>
                                                    <!--end::Heading-->
                                                    <!--begin::Features-->
                                                    <div class="w-100 mb-10">
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Carte de Paiement VISA</span>
                                                            @if($package->visa_classic == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Dépot de chèque</span>
                                                            @if($package->check_deposit == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Paiement & Retrait</span>
                                                            @if($package->payment_withdraw == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Facilité de caisse</span>
                                                            @if($package->overdraft == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Dépot d'espèce</span>
                                                            @if($package->cash_deposit == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Retrait à l'internationnal</span>
                                                            @if($package->withdraw_international == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Paiement à l'internationnal</span>
                                                            @if($package->payment_international == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Assurance des paiement par carte bancaire</span>
                                                            @if($package->payment_insurance == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Chéquier</span>
                                                            @if($package->check == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Nombre de carte physique</span>
                                                            <span class="fs-6 text-gray-600">{{ $package->nb_carte_physique }}</span>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Nombre de carte Virtuel</span>
                                                            <span class="fs-6 text-gray-600">{{ $package->nb_carte_virtuel }}</span>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-5">
                                                            <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Sous comptes</span>
                                                            @if($package->subaccount == 1)
                                                                <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!--end::Features-->
                                                    <!--begin::Select-->
                                                    <a href="{{ route('auth.register.card', ["package" => $package->id]) }}" class="btn btn-sm btn-bank">Choisir le compte {{ $package->name }}</a>
                                                    <!--end::Select-->
                                                </div>
                                                <!--end::Option-->
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    @endforeach
                                </div>
                                <!--end::Row-->
                        @endif
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "/assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used by this page)-->
<script src="assets/js/custom/authentication/sign-in/general.js"></script>
@include("auths.scripts.register.register")
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>

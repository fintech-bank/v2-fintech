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
                    <!--begin::Stepper-->
                    <div class="stepper stepper-pills" id="kt_stepper_example_basic">
                        <!--begin::Nav-->
                        <div class="stepper-nav flex-center flex-wrap mb-10">
                            <!--begin::Step 1-->
                            <div class="stepper-item mx-8 my-4 completed" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">1</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Choix de l'offre
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 1-->

                            <!--begin::Step 2-->
                            <div class="stepper-item mx-8 my-4 completed" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">2</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Information Personnel
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 2-->

                            <!--begin::Step 3-->
                            <div class="stepper-item mx-8 my-4 completed" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">3</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Signature du contrat
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 3-->

                            <!--begin::Step 4-->
                            <div class="stepper-item mx-8 my-4 completed" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">4</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Justificatif
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 4-->

                            <!--begin::Step 4-->
                            <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">5</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Vérification d'identité
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 4-->
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Stepper-->
                    <form action="{{ route('auth.register.personnal.terminate') }}" method="get" class="w-100 mx-auto" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        @if(isset($verifyIdentity))
                            @if($verifyIdentity == 'success')
                                <x-base.alert
                                    type="solid"
                                    icon="check"
                                    title="Vérification d'identité"
                                    color="success"
                                    content="Votre identité à été vérifié, veuillez continuer !" />
                            @else
                                <x-base.alert
                                    type="solid"
                                    icon="xmark"
                                    title="Vérification d'identité"
                                    color="danger"
                                    content="Une erreur à eu lieu lors de la vérification de votre identité !" />
                                <!--begin::Alert-->
                                <div class="alert alert-dismissible bg-light-warning d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
                                    <!--begin::Close-->
                                    <button type="button" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger" data-bs-dismiss="alert">
                                        <i class="fa-solid fa-xmark fa-lg"></i>
                                    </button>

                                    <!--end::Close-->

                                    <!--begin::Icon-->
                                    <span class="svg-icon svg-icon-5tx svg-icon-danger mb-5">...</span>
                                    <i class="fa-solid fa-fingerprint fa-5x text-warning mb-5"></i>
                                    <!--end::Icon-->

                                    <!--begin::Wrapper-->
                                    <div class="text-center">
                                        <!--begin::Title-->
                                        <h1 class="fw-bold mb-5">Vérification d'identité</h1>
                                        <!--end::Title-->

                                        <!--begin::Separator-->
                                        <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                                        <!--end::Separator-->

                                        <!--begin::Content-->
                                        <div class="mb-9 text-dark">
                                            Afin de confirmé votre identité et terminer votre souscription, nous allons vérifié votre
                                            identité.
                                        </div>
                                        <!--end::Content-->

                                        <!--begin::Buttons-->
                                        <div class="d-flex flex-center flex-wrap">
                                            <a href="#" class="btn btn-outline btn-outline-danger btn-active-danger m-2" data-bs-dismiss="alert">Non</a>
                                            <a href="#" class="btn btn-danger m-2 btnVerify">Ok</a>
                                        </div>
                                        <!--end::Buttons-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Alert-->
                            @endif
                        @else
                        <!--begin::Alert-->
                            <div class="alert alert-dismissible bg-light-warning d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
                                <!--begin::Close-->
                                <button type="button" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger" data-bs-dismiss="alert">
                                    <i class="fa-solid fa-xmark fa-lg"></i>
                                </button>

                                <!--end::Close-->

                                <!--begin::Icon-->
                                <span class="svg-icon svg-icon-5tx svg-icon-danger mb-5">...</span>
                                <i class="fa-solid fa-fingerprint fa-5x text-warning mb-5"></i>
                                <!--end::Icon-->

                                <!--begin::Wrapper-->
                                <div class="text-center">
                                    <!--begin::Title-->
                                    <h1 class="fw-bold mb-5">Vérification d'identité</h1>
                                    <!--end::Title-->

                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                                    <!--end::Separator-->

                                    <!--begin::Content-->
                                    <div class="mb-9 text-dark">
                                        Afin de confirmé votre identité et terminer votre souscription, nous allons vérifié votre
                                        identité.
                                    </div>
                                    <!--end::Content-->

                                    <!--begin::Buttons-->
                                    <div class="d-flex flex-center flex-wrap">
                                        <a href="#" class="btn btn-outline btn-outline-danger btn-active-danger m-2" data-bs-dismiss="alert">Non</a>
                                        <a href="#" class="btn btn-danger m-2 btnVerify">Ok</a>
                                    </div>
                                    <!--end::Buttons-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Alert-->
                        @endif


                        <div class="mt-10 mb-10">
                            <div class="d-flex flex-row justify-content-between">
                                <a href="{{ route('auth.register.personnal.signate') }}" class="btn btn-lg btn-outline btn-outline-bank btn-disabled" disabled="true">Précédent</a>
                                <button type="submit" class="btn btn-lg btn-bank ">Suivant</button>
                            </div>
                        </div>
                    </form>
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
<script src="https://cdn.withpersona.com/dist/persona-v4.2.0.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used by this page)-->
<script src="assets/js/custom/authentication/sign-in/general.js"></script>
@include("auths.scripts.register.register")
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>

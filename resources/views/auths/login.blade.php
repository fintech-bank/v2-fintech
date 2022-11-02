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
    <title>{{ config('app.name') }} - Connexion</title>
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
        <!--begin::Aside-->
        <div class="d-flex flex-column flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <!--begin::Aside-->
            <div class="d-flex flex-center flex-lg-start flex-column w-400px bg-white bg-opacity-50 p-5 rounded mb-10">
                <!--begin::Logo-->
                <a href="{{ request()->url() }}" class="mb-7">
                    <img alt="Logo" src="/storage/logo/logo_long_white.png" class="w-250px"/>
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                <h2 class="text-white fw-bolder fs-3 mb-3">Obtenir vos codes</h2>
                <p class="text-white">Le code client vous est attribué par un conseiller au moment de votre inscription au contrat Banque à distance en agence. Lors d'une ouverture de compte en ligne, le code client vous est envoyé par courrier. Il est également indiqué sur vos relevés de comptes.</p>
                <p class="text-white">Votre code confidentiel, vous est envoyer par l'intermédiaire de notre partenaire <strong>PUSHOVER</strong>.</p>
                <!--end::Title-->
            </div>
            <div class="d-flex flex-center flex-lg-start flex-column w-400px bg-white bg-opacity-50 p-5 rounded">
                <!--begin::Title-->
                <h2 class="text-white fw-bolder fs-3 mb-3">Notification push</h2>
                <p class="text-white">Afin de pouvoir recevoir votre code confidentiel et les notifications de la part de {{ config('app.name') }}, vous devez télécharger l'application PUSHOVER.</p>
                <div class="d-flex flex-row justify-content-between">
                    <a href="https://play.google.com/store/apps/details?id=net.superblock.pushover&hl=fr&gl=US">
                        <img src="https://impulseradargpr.com/wp-content/uploads/2021/07/google-play-badge.png" class="w-100px" />
                    </a>
                    <a href="https://apps.apple.com/fr/app/pushover-notifications/id506088175">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Available_on_the_App_Store_%28black%29_SVG.svg/1280px-Available_on_the_App_Store_%28black%29_SVG.svg.png" class="w-100px" />
                    </a>
                </div>
                <!--end::Title-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-center w-lg-50 p-10">
            <!--begin::Card-->
            <div class="card rounded-3 w-md-550px">
                <!--begin::Card body-->
                <div class="card-body p-10 p-lg-20">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="formLogin" action="{{ route('login') }}" method="POST">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-dark fw-bolder mb-3">Connexion à votre espace client</h1>
                            <!--end::Title-->

                        </div>
                            <div id="alert"></div>
                        <!--begin::Heading-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="text" placeholder="Adresse Mail ou Identifiant" name="email" autocomplete="off" class="form-control bg-transparent" />
                            <!--end::Email-->
                        </div>
                        <!--end::Input group=-->
                        <div class="fv-row mb-5">
                            <!--begin::Password-->
                            <input type="password" placeholder="Mot de Passe" name="password" autocomplete="off" class="form-control bg-transparent" />
                            <!--end::Password-->
                        </div>
                        <!--end::Input group=-->

                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div class="fv-row">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="remember" value="" id="flexSwitchDefault"/>
                                    <label class="form-check-label" for="flexSwitchDefault">
                                        Se souvenir de moi
                                    </label>
                                </div>
                            </div>
                            <!--begin::Link-->
                            <a href="../../demo1/dist/authentication/layouts/creative/reset-password.html" class="link-primary">Code oublié ?</a>
                            <!--end::Link-->
                        </div>


                        <!--end::Wrapper-->
                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <x-form.button text="<i class='fa-solid fa-lock me-3'></i> Connexion" />
                        </div>
                        <!--end::Submit button-->
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
@include("auths.scripts.login")
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>

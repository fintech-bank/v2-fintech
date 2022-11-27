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
                    <form class="form w-100" novalidate="novalidate" id="formLogin" action="{{ route('auth.register.cart') }}" method="GET">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-dark fw-bolder mb-3">Choix de votre carte bancaire :</h1>
                            <!--end::Title-->

                        </div>

                            <div class="row">
                                @foreach(\App\Models\Core\CreditCardSupport::where('type_customer', 'part')->get() as $type)
                                    @if(session('package.name') != 'Cristal')
                                        <div class="col">
                                            <input type="radio" class="btn-check" name="support" value="classic" checked="checked"  id="kt_radio_buttons_2_option_1" onchange="choiceCard()" />
                                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="kt_radio_buttons_2_option_1">
                                                <!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
                                                <div class="symbol symbol-50px symbol-2by3 me-5">
                                                    <img src="/storage/card/classic.png" alt=""/>
                                                </div>
                                                <!--end::Svg Icon-->

                                                <span class="d-block fw-semibold text-start">
                                        <span class="text-dark fw-bold d-block fs-3">Visa Classic</span>
                                    </span>
                                            </label>
                                            <!--end::Option-->
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="mb-10 d-none" id="typeDebit">
                                <label for="debit" class="form-label">Type de débit</label>
                                <select id="debit" class="form-select form-select-solid" data-control="select2" name="debit" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    <option value="immediate">Débit Immédiat</option>
                                    <option value="differed">Débit Différé</option>
                                </select>
                            </div>

                            <div class="d-flex flex-wrap">
                                <x-form.button
                                    text="Valider le choix de la carte bancaire" class="btn-bank w-100" />
                            </div>
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

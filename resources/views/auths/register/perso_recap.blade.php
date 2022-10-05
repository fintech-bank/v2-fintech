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
                            <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
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
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
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
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
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
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
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
                    <form action="{{ route('auth.register.personnal.signate') }}" method="get" class="w-50 p-10 mx-auto bg-gray-300 rounded">
                        @csrf
                        <div class="fs-1 fw-bolder mb-5">Récapitulatif</div>
                        <div class="d-flex flex-row justify-content-between mb-10">
                            <span class="d-inline-block position-relative ms-2">
                                <!--begin::Label-->
                                <span class="d-inline-block mb-2 fs-3 fw-bold">
                                    Vos informations personnel
                                </span>
                                <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-bank translate rounded"></span>
                            </span>
                            <a href="" class="btn btn-circle btn-outline btn-outline-primary"><i class="fa-solid fa-edit me-2"></i> Modifier</a>
                        </div>
                        <div class="row mb-5">
                            <div class="col-3">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Civilité</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">{{ \App\Helper\CustomerInfoHelper::getCivility(session()->get('personnel.civility')) }}</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Prénom</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">{{ session()->get('personnel.firstname') }}</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Nom marital ou d'usage</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">{{ session()->get('personnel.middlename') }}</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Nom de naissance</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">{{ session()->get('personnel.lastname') }}</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Email</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">{{ session()->get('personnel.email') }}</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Mobile</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">{{ session()->get('personnel.mobile') }}</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Adresse Postal</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">{{ session()->get('personnel.address') }}, {{ session()->get('personnel.postal') }} {{ session()->get('personnel.city') }}, {{ session()->get('personnel.country') }}</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-base.alert
                            type="light"
                            color="primary"
                            icon="message"
                            title="Information Importante"
                            content="
                            Un justificatif de domicile sera demandé pour l'adresse déclaré.<br>
                            Vous pouvez changer votre situation en cliquant sur modifier
                            "
                            class="mb-10" />

                        <div class="d-flex flex-row justify-content-between mb-10">
                            <span class="d-inline-block position-relative ms-2">
                                <!--begin::Label-->
                                <span class="d-inline-block mb-2 fs-3 fw-bold">
                                    Votre offre {{ session()->get('package.name') }}
                                </span>
                                <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-bank translate rounded"></span>
                            </span>
                            <a href="" class="btn btn-circle btn-outline btn-outline-primary"><i class="fa-solid fa-edit me-2"></i> Modifier</a>
                        </div>

                        <div class="row mb-5">
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Durée de votre contrat</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">Indéterminée</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Prise d'effet de votre contrat</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">Immédiate</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Délai de rétractation</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">14 jours calendaires à compter de la date du contrat</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Frais de changement d'offre</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">5,90 € TTC, le 1er changement est offert</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-row justify-content-between mb-10">
                            <span class="d-inline-block position-relative ms-2">
                                <!--begin::Label-->
                                <span class="d-inline-block mb-2 fs-5 fw-bold">
                                    Votre carte bancaire
                                </span>
                                <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-bank translate rounded"></span>
                            </span>
                        </div>

                        <div class="d-flex flex-row p-5 mb-10 h-150px bg-white rounded">
                            <div class="symbol symbol-100px symbol-2by3 me-5">
                                <img src="/storage/card/{{ session()->get('card.type') }}.png" alt=""/>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="fs-4">Carte Bancaire Visa {{ \Illuminate\Support\Str::ucfirst(session()->get('card.type')) }} avec assurances & Assistances incluses</div>
                                <div class="fs-8">Fourniture d'une carte de {{ session()->get('card.debit') == 'immediate' ? 'débit' : 'crédit' }} (Carte de paiement internationnal à débit {{ session()->get('card.debit') == 'immediate' ? 'immédiat' : 'différé' }})</div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Type de débit</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">Débit {{ session()->get('card.debit') == 'immediate' ? 'immédiat' : 'différé' }}</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-row justify-content-between mb-10">
                            <span class="d-inline-block position-relative ms-2">
                                <!--begin::Label-->
                                <span class="d-inline-block mb-2 fs-5 fw-bold">
                                    Plafond de votre carte
                                </span>
                                <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-bank translate rounded"></span>
                            </span>
                        </div>

                        <div class="row mb-5">
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Paiement par carte / 30 jours</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">{{ eur(\App\Helper\CustomerCreditCard::calcLimitPayment(session('pro.pro_incoming') + session('pro.patrimoine'))) }}</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Retrait par carte / 7 jours</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">{{ eur(\App\Helper\CustomerCreditCard::calcLimitRetrait(session('pro.pro_incoming') + session('pro.patrimoine'))) }}</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(session('package.overdraft') == 1)
                            <div class="d-flex flex-row justify-content-between mb-10">
                                <span class="d-inline-block position-relative ms-2">
                                    <!--begin::Label-->
                                    <span class="d-inline-block mb-2 fs-5 fw-bold">
                                        Facilité de caisse
                                    </span>
                                    <span class="d-inline-block position-absolute h-3px bottom-0 end-0 start-0 bg-bank translate rounded"></span>
                                </span>
                            </div>
                            <p>
                                La facilité de caisse vous autorise à être débiteur, à un taux d'interet et dans la limite d'un montant
                                convenue contractuellement.<br>
                                Montant maximal autorisée: {{ eur(\App\Helper\CustomerHelper::calcOverdraft(session('pro.pro_incoming') + session('pro.patrimoine'), session('pro.pro_category'))) }}.<br>
                                Taux nominal conventionnel: 9,98 %.<br>
                                Des agios seront perçus dès que votre compte est débiteur au taux nominal conventionnel indiqué ci-dessus. En cas de dépassement de votre
                                facilité de caisse, vous serez également redevable d'agios aux taux d'intéret majoré prévu au contrat.
                            </p>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="decouvert" value="true" id="flexCheckDefault"/>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Demander votre facilité de caisse d'un montant de <strong>{{ eur(\App\Helper\CustomerHelper::calcOverdraft(session('pro.pro_incoming') + session('pro.patrimoine'), session('pro.pro_category'))) }}</strong>
                                </label>
                            </div>
                        @endif

                        <div class="d-flex flex-row justify-content-between mb-10">
                            <span class="d-inline-block position-relative ms-2">
                                <!--begin::Label-->
                                <span class="d-inline-block mb-2 fs-3 fw-bold">
                                    Modalité de résiliation
                                </span>
                                <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-bank translate rounded"></span>
                            </span>
                        </div>

                        <p>
                            Vous pouvez, à tous moment, résilier votre offre et/ou clotûrer votre compte en adressant un message à la team {{ config('app.name') }}
                            via votre espace client.
                        </p>

                        <div class="d-flex flex-row justify-content-between mb-10">
                            <span class="d-inline-block position-relative ms-2">
                                <!--begin::Label-->
                                <span class="d-inline-block mb-2 fs-3 fw-bold">
                                    Votre versement initial
                                </span>
                                <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-bank translate rounded"></span>
                            </span>
                        </div>

                        <div class="row mb-5">
                            <div class="col">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Sur votre compte individuel</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">20 €</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col">
                                <div class="d-flex flex-column">
                                    <div class="text-muted">Moyen de versement</div>
                                    <div class="d-flex flex-row justify-content-between p-5 rounded bg-white">
                                        <div class="">Par carte ou par virement bancaire</div>
                                        <i class="fa-solid fa-check text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-10 p-5 bg-light-primary rounded text-center text-primary">
                            <p>Pour finaliser votre souscription, procédez à la signature electronique de vos contrat.</p>
                            <p>Recevez vos code confidentiel par SMS au {{ session('personnel.mobile') }}</p>
                            <p>Si votre numéro de téléphone est erroné, vous pouvez le modifié en cliquant ci-dessus.</p>

                            <x-form.button text="Signer en ligne" class="btn btn-danger"/>
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
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used by this page)-->
<script src="assets/js/custom/authentication/sign-in/general.js"></script>
@include("auths.scripts.register.register")
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>

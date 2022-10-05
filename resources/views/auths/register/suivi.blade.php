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
    <title>{{ config('app.name') }} - Ouverture de compte</title>
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
    <div class="d-flex flex-row align-items-center m-10 pb-15">
        <img src="/storage/logo/logo_carre_white.png" alt="" class="w-80px img-fluid" />
        <div class="d-flex flex-column ms-10 fw-bolder text-white fs-2">
            <span>Vos êtes pret à être serein ?</span>
            <span>Votre demande d'ouverture de compte est bel et bien enregistrée !</span>
        </div>
    </div>
    <div class="d-flex flex-center">
        <div class="d-flex flex-column">
            <div class="card shadow-sm w-100 mb-10">
                <div class="card-header bg-info">
                    <h3 class="card-title text-white"><i class="fa-solid fa-id-card fa-lg me-3"></i> Vos données personnelles</h3>
                </div>
                <div class="card-body fs-3">
                    <table class="table gy-3 gs-3">
                        <tbody>
                        <tr>
                            <td class="fw-bolder me-5">Nom:</td>
                            <td>{{ $user->customers->info->firstname }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bolder me-5">Prénom:</td>
                            <td>{{ $user->customers->info->lastname }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bolder me-5">Adresse:</td>
                            <td>{!! \App\Helper\CustomerInfoHelper::getAddress($user->customers->info) !!}</td>
                        </tr>
                        <tr>
                            <td class="fw-bolder me-5">Téléphone Fixe:</td>
                            <td>{{ $user->customers->info->phone }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bolder me-5">Téléphone Portable:</td>
                            <td>{{ $user->customers->info->mobile }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bolder me-5">Adresse Mail:</td>
                            <td>{{ \App\Helper\UserHelper::emailObscurate($user->email) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card w-100 card-flush shadow-sm">
                <div class="card-header bg-dark ">
                    <h3 class="card-title text-white">Vos demandes d'ouverture de compte</h3>
                </div>
                <div class="card-body py-5">
                    <table class="table table-rounded table-striped border gy-7 gs-7">
                        <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                            <th>Type de compte</th>
                            <th>Status Actuel</th>
                            <th>Action à mener</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="w-25">Compte Bancaire Particulier</td>
                            <td class="w-25">{!! \App\Helper\CustomerHelper::getStatusOpenAccount($user->customers->status_open_account, true) !!}</td>
                            <td class="w-25">
                                @if($user->customers->status_open_account == 'open')
                                    <p>Votre compte est à présent ouvert.<br>Afin de finaliser l'ouverture de votre compte, veuillez l'approvisionner d'un montant de <strong>20,00 €</strong> en completant le formulaire ci-dessous.</p>
                                    <button class="btn btn-sm btn-bank" data-bs-toggle="modal" data-bs-target="#TerminateCheckout">Approvisionner</button>
                                @elseif($user->customers->status_open_account == 'completed')
                                    <p>Le montant de 20,00 € à été crédité sur votre nouveau compte bancaire {{ config('app.name') }}.<br>Un conseiller {{ config('app.name') }} va étudier votre dossier et vous serez alerté de l'avancement de l'ouverture de votre compte (24h - 48h).</p>
                                @elseif($user->customers->status_open_account == 'accepted')
                                    <p>Votre dossier d'ouverture de compte à été <strong>ACCEPTER</strong> par notre service compte bancaire.</p>
                                    <p>Dans quelque jours, vous allez recevoir un email concernant l'ouverture définitive de votre compte bancaire.</p>
                                    <p>Votre conseiller est M. MOCKELYN Maxime.<br>Vous pouvez le contacter si vous avez des questions relatives à la gestion de votre compte client.</p>
                                    <p>Toutes l'équipe de {{ config('app.name') }} vous souhaitent la bienvenue parmis nous !</p>
                                @elseif($user->customers->status_open_account == 'declined')
                                    <p>Votre dossier d'ouverture de compte à été <strong>REFUSER</strong> par notre service compte bancaire.</p>
                                    <p>Nous sommes désolé de ne pouvoir donner suite à votre demande.</p>
                                    <p>Le montant de 20,00 € à été recréditer sur votre compte bancaire</p>
                                @elseif($user->customers->status_open_account == 'terminated')

                                @else

                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<div class="modal fade" tabindex="-1" id="TerminateCheckout">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-bank">
                <h3 class="modal-title text-white">Validation de votre compte</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark text-white"></i>
                </div>
                <!--end::Close-->
            </div>
            <form id="payment-form">
                @csrf
                <div class="modal-body">
                    <div id="payment-element">
                        <!--Stripe.js injects the Payment Element-->
                    </div>
                    <div id="payment-message" class="hidden"></div>
                    <x-base.alert
                        type="basic"
                        color="danger"
                        icon="xmark"
                        title="Erreur de Paiement"
                        content=""
                        class="d-none"
                        id="error-message" />
                </div>
                <div class="modal-footer">
                    <x-form.button id="submit" />
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "/assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
<script src="https://cdn.withpersona.com/dist/persona-v4.2.0.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used by this page)-->
<script src="assets/js/custom/authentication/sign-in/general.js"></script>
<script type="text/javascript">
        @isset($client_secret)
    let stripe = Stripe('{{ config('services.stripe.api_key') }}')
    let modals = document.querySelector("#TerminateCheckout")
    let modal = new bootstrap.Modal(modals)

    const options = {
        clientSecret: '{{ $client_secret }}',
        // Fully customizable with appearance API.
    };

    const elements = stripe.elements(options);

    // Create and mount the Payment Element
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const {error} = await stripe.confirmPayment({
            //`Elements` instance that was used to create the Payment Element
            elements,
            confirmParams: {
                return_url: '{{ config('app.url') }}/register/suivre?payment=success',
            },
        });

        if (error) {
            // This point will only be reached if there is an immediate error when
            // confirming the payment. Show error to your customer (for example, payment
            // details incomplete)
            const messageContainer = document.querySelector('#error-message');
            messageContainer.classList.remove('d-none')
            messageContainer.querySelector('span').textContent = error.message;
        } else {
            // Your customer will be redirected to your `return_url`. For some payment
            // methods like iDEAL, your customer will be redirected to an intermediate
            // site first to authorize the payment, then redirected to the `return_url`.
            modal.hide()
            toastr.success("Paiement Effectuer")
            setTimeout(() => {
                window.location.reload()
            }, 1500)
        }
    });
    @endisset

</script>
@include("auths.scripts.register.register")
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>

@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Nouveau client</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}"
                   class="text-muted text-hover-primary">Agence</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.index') }}"
                   class="text-muted text-hover-primary">Gestion clientèle</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>

            <li class="breadcrumb-item text-dark">Nouveau client</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="history.back()"><i class="fa-solid fa-arrow-left me-2"></i> Retour</button>
    </div>
@endsection

@section("content")
    <div class="card shadow-sm">
        <form id="" action="{{ route('agent.customer.create.part.options') }}" method="GET" enctype="multipart/form-data">
            <div class="card-body stepper stepper-pills stepper-column d-flex flex-column flex-lg-row">
                <div class="d-flex flex-row-auto w-100 w-lg-300px">
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
                                        Informations
                                    </h3>

                                    <div class="stepper-desc">
                                        Informations personnels du client
                                    </div>
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
                                        Revenues & Charges
                                    </h3>

                                    <div class="stepper-desc">
                                        Informations sur les revenues & charges du client
                                    </div>
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
                                        Forfait
                                    </h3>

                                    <div class="stepper-desc">
                                        Choix du forfait bancaire et associés
                                    </div>
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
                                        Carte bancaire
                                    </h3>

                                    <div class="stepper-desc">
                                        Choix de la carte bancaire et options
                                    </div>
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
                                        Options
                                    </h3>

                                    <div class="stepper-desc">
                                        Choix des options facultatives
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">6</span>
                                </div>
                                <!--begin::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Terminer
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
                <div class="d-flex flex-column w-100">
                    <x-base.underline title="Options de compte" size="3" sizeText="fs-1" color="bank" />
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <a href="#" class="card shadow-lg me-5" data-bs-toggle="modal" data-bs-target="#subscribeAlerta">
                                <div class="card-body">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px me-5">
                                            <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-bell fs-2"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fw-bolder fs-2 text-black">Alerta PLUS</div>
                                            <div class="fs-italic text-muted">Notification programmer pour vous tenir au courant des mouvements de votre compte au quotidien</div>
                                        </div>
                                        @if(session()->has('subscribe.alerta') && session()->get('subscribe.alerta'))
                                            <i class="fa-solid fa-check-circle fs-1 text-success"></i>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-3">
                            <a href="" class="card shadow-lg me-5" data-bs-toggle="modal" data-bs-target="#subscribeDailyInsurance">
                                <div class="card-body">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px me-5">
                                            <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-umbrella fs-2"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fw-bolder fs-2 text-dark">Assurance au quotidien</div>
                                            <div class="fs-italic text-muted">Assurez-vous contre l’utilisation frauduleuse de vos moyens de paiement et la perte ou le vol de vos clés et de vos papiers.</div>
                                        </div>
                                        @if(session()->has('subscribe.daily_insurance') && session()->get('subscribe.daily_insurance'))
                                            <i class="fa-solid fa-check-circle fs-1 text-success"></i>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-3">
                            <a href="" class="card shadow-lg me-5" data-bs-toggle="modal" data-bs-target="#subscribeWithdraw">
                                <div class="card-body">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px me-5">
                                            <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-eur fs-2"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fw-bolder fs-2 text-dark">Retrait DAB Illimité</div>
                                            <div class="fs-italic text-muted">Retirez sans frais additionnels dans les distributeurs de toutes les banques.</div>
                                        </div>
                                        @if(session()->has('subscribe.dab') && session()->get('subscribe.dab'))
                                            <i class="fa-solid fa-check-circle fs-1 text-success"></i>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-3">
                            <a href="" class="card shadow-lg me-5" data-bs-toggle="modal" data-bs-target="#subscribeOverdraft">
                                <div class="card-body">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px me-5">
                                            <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-eur fs-2"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fw-bolder fs-2 text-dark">Facilité de caisse</div>
                                            <div class="fs-italic text-muted">Vous souhaitez éviter en fin de mois des décalages de trésorerie et les intérêts débiteurs associés ? Le Forfait d’exonération d’agios est une option simple et sans engagement qui vous permet d’être exonéré d’agios quand votre compte est à découvert.</div>
                                        </div>
                                        @if(session()->has('subscribe.overdraft') && session()->get('subscribe.overdraft'))
                                            <i class="fa-solid fa-check-circle fs-1 text-success"></i>
                                        @endif

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <x-base.underline title="Options de Carte Bancaire" size="3" sizeText="fs-1" color="bank" />
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <a href="#" class="card shadow-lg me-5" data-bs-toggle="modal" data-bs-target="#subscribeCardCode">
                                <div class="card-body">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px me-5">
                                            <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-credit-card fs-2"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fw-bolder fs-2 text-black">Choisir son Code Secret</div>
                                            <div class="fs-italic text-muted">Choisissez simplement le code secret de votre carte bancaire par téléphone pour être sûr.e de ne pas l’oublier.</div>
                                        </div>
                                        @if(session()->has('subscribe.card_code') && session()->get('subscribe.card_code'))
                                            <i class="fa-solid fa-check-circle fs-1 text-success"></i>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <x-form.button />
            </div>
        </form>
    </div>
    <div class="modal fade" tabindex="-1" id="subscribeAlerta">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Abonnement Alerta Plus</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa-solid fa-bell fs-3hx text-primary mb-5"></i><br>
                        Abonnement à un produit offrant des alertes sur la situation du compte par SMS
                    </div>
                    <table class="table border gs-5 gy-5">
                        <tbody>
                            <tr>
                                <td class="fw-bolder">Tarif:</td>
                                <td>{{ eur(2.90) }} <span class="fs-6">/ par mois sans engagement</span> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="d-flex">
                        <button class="btn btn-bank btn-circle w-100 btnSubscribe" data-subscribe="alerta">Souscrire</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="subscribeDailyInsurance">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Mon Assurance au quotidien</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa-solid fa-umbrella fs-3hx text-primary mb-5"></i><br>
                        Avec Mon assurance au quotidien(1) vous êtes assuré contre l’utilisation frauduleuse de vos moyens de paiement et la perte et le vol de vos clés et de vos papiers. L’assurance prolonge votre garantie Constructeur en cas de panne de vos appareils domestiques.
                    </div>
                    <table class="table border gs-5 gy-5">
                        <tbody>
                            <tr>
                                <td class="fw-bolder">Tarif:</td>
                                <td>{{ eur(24) }} <span class="fs-6">/ par an</span> </td>
                            </tr>
                            <tr>
                                <td class="fw-bolder">Avantages:</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="fw-bolder">Offre Complète</div>
                                            <ul>
                                                <li>Nombreuses garanties</li>
                                                <li>Plafonds élevés</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="fw-bolder">Rapide</div>
                                            <ul>
                                                <li>Prise en charge du sinistre dès sa déclaration</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="fw-bolder">Solution simple</div>
                                            <ul>
                                                <li>Prélèvement mensuel</li>
                                                <li>Possibilité de modifier son compte de prélèvement</li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bolder">Caractéristique:</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="fw-bolder mb-5">Quelles sont les garanties de Mon assurance au quotidien ?</div>
                                            <p>Sécurité financière : remboursement des pertes pécuniaires subies à l’issue d’un usage frauduleux des moyens de paiement et/ou de retrait suite à la perte ou au vol de ces moyens de paiement. Plafond d’indemnisation : jusque 6 000 € par sinistre et par an.</p>
                                            <p>Sécurité clés/papiers : remboursement des frais de remplacement de vos clés et/ou papiers en cas de perte ou de vol de ces derniers.</p>
                                            <p>Plafonds d’indemnisation :</p>
                                            <ul>
                                                <li>Clés et serrures : 500 € par sinistre et par an dont 350€ par sinistre pour les clés et serrures autres que celles d’un coffre loué par Société Générale.</li>
                                                <li>Papiers : 150 € par sinistre et par an.</li>
                                            </ul>
                                            <p>Prolongation de la garantie constructeur : prolongation de 2 ans en cas de panne des appareils électroménagers, informatiques, hi-fi et/ou vidéo achetés neufs par l’assuré au moyen de tous moyens de paiement dont il est titulaire ou co-titulaire. Plafond d’indemnisation : 5 000 € par sinistre et par an.</p>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <p>Sécurité vol d’espèces : remboursement des espèces retirées depuis moins de 48h et volées à la suite d’une agression, d’un malaise, ou d’un accident de la circulation.</p>
                                            <p>Plafonds d’indemnisation :</p>
                                            <ul>
                                                <li>1 000 € par sinistre et par an pour les retraits dans les DAB/guichets du groupe Société Générale et Crédit du Nord.</li>
                                                <li>500 € par sinistre et par an pour les espèces retirées dans les DAB/guichets hors Société Générale.</li>
                                            </ul>
                                            <p>Sécurité téléphone mobile : remboursement du montant des communications effectuées frauduleusement dans les 48h suivant le vol de votre téléphone mobile et avant la mise en opposition de la carte SIM. Plafond d’indemnisation : 500 € par sinistre et par an.</p>
                                            <div class="fw-bolder my-5">Qui peut en bénéficier ?</div>
                                            <p>Toute personne physique titulaire ou cotitulaire d’un compte Société Générale en qualité de particulier dans le cadre de sa vie privée. L’adhésion est possible dès 15 ans.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="d-flex">
                        <button class="btn btn-bank btn-circle w-100 btnSubscribe" data-subscribe="dailyInsurance">Souscrire</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="subscribeWithdraw">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Retraits DAB illimités</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa-solid fa-eur fs-3hx text-primary mb-5"></i><br>
                        <p>Retirez où vous voulez, quand vous voulez : avec le Forfait de retraits DAB illimités, vous êtes exonéré des éventuels frais supplémentaires lorsque vous retirez des espèces aux Distributeurs Automatiques de Billets (DAB) d’une autre banque, partout dans la zone Euro(1).</p>
                    </div>
                    <table class="table border gs-5 gy-5">
                        <tbody>
                            <tr>
                                <td class="fw-bolder">Tarif:</td>
                                <td>{{ eur(2) }} <span class="fs-6">/ par mois sans engagement</span> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="d-flex">
                        <button class="btn btn-bank btn-circle w-100 btnSubscribe" data-subscribe="dab">Souscrire</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="subscribeOverdraft">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Facilité de caisse</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa-solid fa-eur fs-3hx text-primary mb-5"></i><br>
                        <p>Vous souhaitez éviter en fin de mois des décalages de trésorerie et les intérêts débiteurs associés ? Le Forfait d’exonération d’agios est une option simple et sans engagement qui vous permet d’être exonéré d’agios quand votre compte est à découvert.</p>
                    </div>
                    <table class="table border gs-5 gy-5">
                        <tbody>
                            <tr>
                                <td class="fw-bolder">Tarif:</td>
                                <td>{{ eur(2) }} <span class="fs-6">/ par mois sans engagement</span> </td>
                            </tr>
                            <tr>
                                <td class="fw-bolder">Montant Maximal Accordé:</td>
                                <td>
                                    @if($overdraft->access)
                                        {{ eur($overdraft->value) }} ({{ $overdraft->taux }} / par an)
                                    @else
                                        {{ $overdraft->reason }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <x-form.input
                        name="overdraft_amount"
                        label="Montant Souhaité"
                        required="true" />
                </div>
                <div class="modal-footer">
                    <div class="d-flex">
                        <button class="btn btn-bank btn-circle w-100 btnSubscribe" data-subscribe="overdraft">Souscrire</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="subscribeCardCode">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Choisir son code secret</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa-solid fa-eur fs-3hx text-primary mb-5"></i><br>
                        <p>Codes de carte bancaire, de téléphone, de digicode... le nombre de codes que nous utilisons quotidiennement ne cesse d'augmenter. Pour ne pas oublier celui de votre carte bancaire, Société Générale vous propose de le choisir vous-même.</p>
                    </div>
                    <table class="table border gs-5 gy-5">
                        <tbody>
                            <tr>
                                <td class="fw-bolder">Tarif:</td>
                                <td><span class="badge badge-success">Gratuit</span> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="d-flex">
                        <button class="btn btn-bank btn-circle w-100 btnSubscribe" data-subscribe="card_code">Souscrire</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.create")
@endsection

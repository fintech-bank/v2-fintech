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
                    <div class="d-flex flex-row justify-content-between">
                        <a href="#" class="card shadow-lg me-5" data-bs-toggle="modal" data-bs-target="#subscribeAlerta">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="symbol symbol-50px me-5">
                                        <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-bell fs-2"></i> </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-2 text-black">Alerta PLUS</div>
                                        <div class="fs-italic text-muted">Notification programmer pour vous tenir au courant des mouvements de votre compte au quotidien</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="card shadow-lg me-5" data-bs-toggle="modal" data-bs-target="#subscribeDailyInsurance">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="symbol symbol-50px me-5">
                                        <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-umbrella fs-2"></i> </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-2">Assurance au quotidien</div>
                                        <div class="fs-italic text-muted">Assurez-vous contre l’utilisation frauduleuse de vos moyens de paiement et la perte ou le vol de vos clés et de vos papiers.</div>
                                    </div>
                                </div>
                            </div>
                        </a>
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
        <div class="modal-dialog ">
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
@endsection

@section("script")
    @include("agent.scripts.customer.create")
@endsection

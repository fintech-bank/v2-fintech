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
        <form id="formPartPro" action="{{ route('agent.customer.create.part.package') }}" method="GET" enctype="multipart/form-data">
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
                        <div class="stepper-item mx-8 my-4 pending" data-kt-stepper-element="nav">
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
                <div class="d-flex flex-column">
                    <x-base.underline title="Situation Professionnel" size="3" sizeText="fs-1" color="bank" />
                    <x-form.select
                        name="pro_category"
                        :datas="\App\Helper\CustomerSituationHelper::dataProCategories()"
                        label="Catégorie sociaux Professionnel" />

                    <x-form.input
                        name="pro_profession"
                        type="text"
                        label="Profession" />

                    <x-base.underline title="Revenue" size="3" sizeText="fs-1" color="bank" />
                    <div class="row">
                        <div class="col-6">
                            <x-form.input-group
                                name="pro_incoming"
                                label="Revenue Professionnel"
                                placement="left"
                                symbol="€" />
                        </div>
                        <div class="col-6">
                            <x-form.input-group
                                name="patrimoine"
                                label="Patrimoine"
                                placement="left"
                                symbol="€" />
                        </div>
                    </div>
                    <x-base.underline title="Charges" size="3" sizeText="fs-1" color="bank" />
                    <div class="row">
                        <div class="col-6">
                            <x-form.input-group
                                name="rent"
                                label="Loyer, mensualité crédit immobilier"
                                placement="left"
                                symbol="€" />
                        </div>
                        <div class="col-6">
                            <x-form.input-group
                                name="divers"
                                label="Charges Divers (pension, etc...)"
                                placement="left"
                                symbol="€" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-form.input
                                name="nb_credit"
                                type="text"
                                label="Nombre de crédit (Crédit Personnel, Renouvelable, etc...)" />
                        </div>
                        <div class="col-6">
                            <x-form.input-group
                                name="credit"
                                label="Mensualité de vos crédits"
                                placement="left"
                                symbol="€" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <x-form.button />
            </div>
        </form>
    </div>
    <div class="modal fade" tabindex="-1" id="modalVerifCustomer">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Vérification clientèle</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="d-flex flex-column justify-content-center align-items-center h-300px">
                        <div class="icon">
                            <svg class="spinner mb-5" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                            </svg>
                        </div>
                        <div class="fw-bolder fs-2">Vérification des informations du client</div>
                        <div id="errors" class="text-danger"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.create")
@endsection

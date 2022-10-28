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
        <form id="" action="{{ route('agent.customer.create.part.pro') }}" method="GET" enctype="multipart/form-data">
            <div class="card-body stepper stepper-pills stepper-column d-flex flex-column flex-lg-row">
                <div class="d-flex flex-row-auto w-100 w-lg-300px">
                    <div class="stepper-nav flex-center flex-wrap mb-10">
                        <!--begin::Step 1-->
                        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
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
                        <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
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
                    <x-base.underline
                        title="Information personnel"
                        size-text="fs-1"
                        class="mb-10"
                        size="4"
                        color="bank" />

                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="mb-10">
                                <label for="civility" class="form-label required">Civilité</label>
                                <select class="form-control" data-control="select2" name="civility" data-placeholder="Civilité">
                                    <option value=""></option>
                                    <option value="M">Monsieur</option>
                                    <option value="Mme">Madame</option>
                                    <option value="Mlle">Mademoiselle</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <x-form.input
                                name="lastname"
                                label="Nom de famille"
                                required="true" />
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <x-form.input
                                name="middlename"
                                label="Nom marital" />
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <x-form.input
                                name="firstname"
                                label="Prénom"
                                required="true" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <x-form.input-date
                                name="datebirth"
                                type="text"
                                label="Date de naissance"
                                required="true" />
                        </div>

                        <div class="col-md-4 col-sm-12 mb-10">
                            <label for="countrybirth" class="required form-label">
                                Pays de Naissance
                            </label>
                            <select id="countrybirth" class="form-select form-select-solid" data-placeholder="Selectionnez un pays de naissance" name="countrybirth" onchange="citiesFromCountry(this)">
                                <option value=""></option>
                                @foreach(\App\Helper\GeoHelper::getAllCountries() as $data)
                                    <option value="{{ $data->name }}" data-kt-select2-country="{{ $data->flag }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="mb-10" id="divCities"></div>
                        </div>
                    </div>

                    <x-base.underline title="Adresse Postal" size="4" sizeText="fs-1" color="bank"/>

                    <x-form.input
                        name="address"
                        type="text"
                        label="Adresse Postal"
                        required="true" />
                    <x-form.input
                        name="addressbis"
                        type="text"
                        label="Complément d'adresse" />

                    <div class="row">
                        <div class="col-4">
                            <x-form.input
                                name="postal"
                                type="text"
                                label="Code Postal"
                                required="true" />
                        </div>
                        <div class="col-4">
                            <div class="mb-10" id="divCity"></div>
                        </div>
                        <div class="col-4">
                            <div class="mb-10">
                                <label for="country" class="required form-label">
                                    Pays de résidence
                                </label>
                                <select id="country" class="form-select form-select-solid" data-placeholder="Selectionnez un pays" name="country">
                                    <option value=""></option>
                                    @foreach(\App\Helper\GeoHelper::getAllCountries() as $data)
                                        <option value="{{ $data->name }}" data-kt-select2-country="{{ $data->flag }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <x-base.underline title="Contact" size="3" sizeText="fs-1" color="bank" />
                    <div class="row">
                        <div class="col-4">
                            <x-form.input
                                name="phone"
                                type="text"
                                label="Domicile" text="Format: +33999999999"/>
                        </div>
                        <div class="col-4">
                            <x-form.input
                                name="mobile"
                                type="text"
                                label="Mobile"
                                text="Format: +33999999999"
                                required="true" />
                        </div>
                        <div class="col-4">
                            <x-form.input
                                name="email"
                                type="email"
                                label="Adresse Mail"
                                required="true" />
                        </div>
                    </div>

                    <x-base.underline title="Situation Personnel" size="3" sizeText="fs-1" color="bank" />

                    <div class="row">
                        <div class="col-6">
                            <x-form.select
                                name="legal_capacity"
                                :datas="\App\Helper\CustomerSituationHelper::dataLegalCapacity()"
                                label="Capacité Juridique" required="false"/>
                        </div>
                        <div class="col-6">
                            <x-form.select
                                name="family_situation"
                                :datas="\App\Helper\CustomerSituationHelper::dataFamilySituation()"
                                label="Situation Familiale" required="false"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-form.select
                                name="logement"
                                :datas="\App\Helper\CustomerSituationHelper::dataLogement()"
                                label="Dans votre logement, vous êtes" required="false"/>
                        </div>
                        <div class="col-6">
                            <x-form.input-date
                                name="logement_at"
                                type="text"
                                label="Depuis le" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-form.input-dialer
                                name="child"
                                label="Nombre d'enfant"
                                min="0"
                                max="99"
                                step="1"
                                value="0" />
                        </div>
                        <div class="col-6">
                            <x-form.input-dialer
                                name="person_charged"
                                label="Nombre de personne à charge"
                                min="0"
                                max="99"
                                step="1"
                                value="0" />
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <x-form.button />
            </div>
        </form>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.create")
@endsection

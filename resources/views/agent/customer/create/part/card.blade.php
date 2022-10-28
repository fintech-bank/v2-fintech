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
                        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
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
                <div class="d-flex flex-column w-100">
                    <x-base.underline title="Carte Bancaire" size="3" sizeText="fs-1" color="bank" />
                    <div class="mb-10">
                        <label for="card_support" class="required form-label">
                            Type de carte bancaire
                        </label>
                        <select id="card_support" class="form-select form-select-solid" data-placeholder="Selectionner un type de carte" name="card_support" required onchange="getShowDifferedType(this)">
                            <option value=""></option>
                            @foreach(\App\Models\Core\CreditCardSupport::where('type_customer', 'part')->get() as $type)
                                <option value="{{ $type->slug }}" data-card-img="/storage/card/{{ $type->slug }}.png">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="differed_card_type" class="d-none">
                        <div class="mb-10">
                            <label for="card_debit" class="form-label">
                                Type de débit
                            </label>
                            <select id="card_debit" class="form-select form-select-solid" data-control="select2" data-placeholder="Selectionner un type de débit" name="card_debit" onchange="getShowDifferedAmount(this)">
                                <option value=""></option>
                                <option value="immediat">Débit Immédiat</option>
                                <option value="differed">Débit Différé</option>
                            </select>
                        </div>
                    </div>
                    <div id="differed_card_amount" class="d-none">
                        <x-form.input-dialer
                            name="differed_limit"
                            label="Montant disponible"
                            min="100"
                            max="7500"
                            step="100"
                            value="500"
                            prefix="€"
                            />
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

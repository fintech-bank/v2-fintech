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
        <form id="" action="{{ route('agent.customer.create.part.package') }}" method="GET" enctype="multipart/form-data">
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
                        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
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
                <div class="d-flex flex-column w-100">
                    <x-base.underline title="Compte bancaire" size="3" sizeText="fs-1" color="bank" />
                    <div class="mb-10 w-250px">
                        <label for="package_id" class="required form-label">
                            Plan de compte
                        </label>
                        <select id="package_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Selectionner un plan" name="package_id" required onchange="getInfoPackage(this)">
                            <option value=""></option>
                            @foreach(\App\Models\Core\Package::where('type_cpt', 'part')->get() as $package)
                                <option value="{{ $package->id }}">{{ $package->name }} - {{ eur($package->price) }} / par mois</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="package_info" class="border rounded p-10 bg-gray-200 d-none">
                        <div class="d-flex flex-row align-items-center" id="blockDivPackage">
                            <div class="symbol symbol-200px me-5">
                                <div class="symbol-label fw-semibold" data-content="icon"><i class="fa-regular fa-gem fs-5tx"></i> </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex flex-column mb-10">
                                            <div class="d-flex flex-row mb-2">
                                                <div class="fw-bolder me-3">Nom du forfait:</div>
                                                <span data-content="package_name"></span>
                                            </div>
                                            <div class="d-flex flex-row mb-2">
                                                <div class="fw-bolder me-3">Tarification:</div>
                                                <span data-content="package_price"></span>
                                            </div>
                                            <div class="d-flex flex-row mb-2">
                                                <div class="fw-bolder me-3">Type de Prélèvement:</div>
                                                <span data-content="package_type_prlv"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex flex-row justify-content-between w-100">
                                            <div class="d-flex flex-column me-2">
                                                <div class="d-flex flex-row mb-2" data-content="visa_classic">
                                                    <i class="fa-solid fa-check-circle fs-2 text-success me-3"></i>
                                                    <span>Visa Classic</span>
                                                </div>
                                                <div class="d-flex flex-row mb-2" data-content="check_deposit">
                                                    <i class="fa-solid fa-check-circle fs-2 text-success me-3"></i>
                                                    <span>Dépot de Chèque</span>
                                                </div>
                                                <div class="d-flex flex-row mb-2" data-content="payment_withdraw">
                                                    <i class="fa-solid fa-check-circle fs-2 text-success me-3"></i>
                                                    <span>Retrait et paiement illimité en zone Euro</span>
                                                </div>
                                                <div class="d-flex flex-row mb-2" data-content="overdraft">
                                                    <i class="fa-solid fa-check-circle fs-2 text-success me-3"></i>
                                                    <span>Mise en place d'un découvert bancaire</span>
                                                </div>
                                                <div class="d-flex flex-row mb-2" data-content="cash_deposit">
                                                    <i class="fa-solid fa-check-circle fs-2 text-success me-3"></i>
                                                    <span>Dépot d'espèce en agent distributeur</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex flex-row mb-2" data-content="withdraw_international">
                                                    <i class="fa-solid fa-check-circle fs-2 text-success me-3"></i>
                                                    <span>Retrait à l'internationnal</span>
                                                </div>
                                                <div class="d-flex flex-row mb-2" data-content="payment_international">
                                                    <i class="fa-solid fa-check-circle fs-2 text-success me-3"></i>
                                                    <span>Paiement à l'internationnal</span>
                                                </div>
                                                <div class="d-flex flex-row mb-2" data-content="payment_insurance">
                                                    <i class="fa-solid fa-check-circle fs-2 text-success me-3"></i>
                                                    <span>Assurance des moyens de paiement</span>
                                                </div>
                                                <div class="d-flex flex-row mb-2" data-content="check">
                                                    <i class="fa-solid fa-check-circle fs-2 text-success me-3"></i>
                                                    <span>Mise en place d'un chéquier</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="card shadow-lg bg-light-primary mb-5">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="symbol symbol-50px me-5">
                                                <div class="symbol-label fw-semibold text-primary"><i class="fa-regular fa-credit-card fs-1"></i> </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fs-3 fw-bold">Nombre de carte bancaire physique</span>
                                                <span data-content="nb_carte_physique" class="fs-1 fw-bolder"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow-lg bg-light-info mb-5">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="symbol symbol-50px me-5">
                                                <div class="symbol-label fw-semibold text-info"><i class="fa-solid fa-credit-card fs-1"></i> </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fs-3 fw-bold">Nombre de carte bancaire virtuel</span>
                                                <span data-content="nb_carte_virtuel" class="fs-1 fw-bolder"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow-lg bg-light-warning mb-5">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="symbol symbol-50px me-5">
                                                <div class="symbol-label fw-semibold text-warning"><i class="fa-solid fa-users-viewfinder fs-1"></i> </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fs-3 fw-bold">Nombre de sous compte</span>
                                                <span data-content="subaccount" class="fs-1 fw-bolder"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Souscription à un contrat de pret</h1>
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
                   class="text-muted text-hover-primary">Client</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.show', $customer->id) }}"
                   class="text-muted text-hover-primary">{{ $customer->user->identifiant }} - {{ $customer->info->full_name }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Souscription à un contrat de pret</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>-->
    </div>
@endsection

@section("content")
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Souscription à un Crédit</h3>
        </div>
        <div class="card-body">
            <!--begin::Stepper-->
            <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="credit_stepper">
                <!--begin::Aside-->
                <div class="d-flex flex-row-auto w-100 w-lg-300px">
                    <!--begin::Nav-->
                    <div class="stepper-nav flex-cente">
                        <!--begin::Step 1-->
                        <div class="stepper-item me-5 current" data-kt-stepper-element="nav">
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
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 1-->

                        <!--begin::Step 3-->
                        <div class="stepper-item me-5" data-kt-stepper-element="nav">
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
                                        Validation
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
                        <div class="stepper-item me-5" data-kt-stepper-element="nav">
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
                                        Souscription
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Step 4-->
                    </div>
                    <!--end::Nav-->
                </div>

                <!--begin::Content-->
                <div class="flex-row-fluid">
                    <!--begin::Form-->
                    <form id="formAddCredit" class="form" action="{{ route('agent.customer.pret.store', $customer->id) }}" method="POST">
                        @csrf
                        <!--begin::Group-->
                        <div class="mb-5">
                            <!--begin::Step 1-->
                            <div class="flex-column w-100 current" data-kt-stepper-element="content">
                                <div class="d-flex flex-row mb-10">
                                    <x-form.checkbox
                                        name="required_insurance"
                                        label="Assurance emprunteur requise"
                                        value="1" class="me-5"/>
                                    <x-form.checkbox
                                        name="required_caution"
                                        label="Caution requise"
                                        value="1" />
                                </div>

                                <!--<div class="mb-10">
                                    <label for="loan_plan_id" class="form-label required">Type de crédit</label>
                                    <select class="form-control form-control-solid" data-control="select2" name="loan_plan_id" data-placeholder="Selectionner un type de crédit">
                                        <option value=""></option>
                                        @foreach(\App\Models\Core\LoanPlan::where('type_pret', $customer->info->type)->get() as $plan)
                                            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>-->
                                <x-form.select
                                    name="loan_plan_id"
                                    label="Type de Crédit"
                                    placeholder="Selectionner un type de crédit..."
                                    :datas="\App\Models\Core\LoanPlan::where('type_pret', $customer->info->type)->get()->pluck('id', 'name')" />
                                <div class="row mb-10">
                                    <div class="col-4">
                                        <x-form.input
                                            name="amount_loan"
                                            label="Montant Souhaité"
                                            required="true" />
                                    </div>
                                    <div class="col-4">
                                        <x-form.input
                                            name="duration"
                                            label="Durée du crédit (en année)"
                                            required="true" />
                                    </div>
                                    <div class="col-4">
                                        <x-form.input
                                            name="prlv_day"
                                            label="Jours de prélèvement" />
                                    </div>
                                </div>
                                <div class="mb-10">
                                    <label for="wallet_payment_id" class="form-label required">Compte de Paiement</label>
                                    <select class="form-control form-control-solid" data-control="select2" name="wallet_payment_id" data-placeholder="Selectionner un compte de paiement">
                                        <option value=""></option>
                                        @foreach($customer->wallets()->where('type', 'compte')->where('status', 'active')->get() as $wallet)
                                            <option value="{{ $wallet->id }}">{{ $wallet->name_account }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-10">
                                    <label for="assurance_type" class="form-label required">Type d'assurance</label>
                                    <select class="form-control form-control-solid" data-control="select2" name="assurance_type" data-placeholder="Selectionner un type d'assurance" required>
                                        <option value=""></option>
                                        <option value="D">Décès</option>
                                        <option value="DIM">Décès, Invalidité, Maladie</option>
                                        <option value="DIMC">Décès, Invalidité, Maladie, Perte d'emploi</option>
                                    </select>
                                </div>
                            </div>
                            <!--begin::Step 1-->

                            <!--begin::Step 1-->
                            <div class="flex-column w-100" data-kt-stepper-element="content">
                                <div class="card shadow-sm mb-10" id="validResultPrerequest">
                                    <div class="card-body">
                                        <ul></ul>
                                    </div>
                                </div>
                                <div class="card shadow-sm mb-10" id="validResultPret">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                            <!--begin::Step 1-->

                            <!--begin::Step 1-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <table class="table table-border table-sm gy-3 gx-3" id="result">
                                            <tbody class="border border-bottom-2 border-gray-300">
                                                <tr>
                                                    <td class="fw-bolder">Montant de l'emprunt</td>
                                                    <td data-content="amount_loan"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">Durée</td>
                                                    <td data-content="duration"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">Mensualité</td>
                                                    <td data-content="mensuality"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">TAEG (Taux Annuel Effectif Global)</td>
                                                    <td data-content="taux"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">Montant total dû par l'emprunteur</td>
                                                    <td data-content="amount_du"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">Type d'assurance emprunteur</td>
                                                    <td data-content="assurance_type"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">TAAE (Taux Annuel Assurance emprunteur)</td>
                                                    <td data-content="taxe_assurance"></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="fw-bolder fs-3">
                                                    <td>Montant total dû</td>
                                                    <td data-content="amount_du_assurance"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Step 1-->
                        </div>
                        <!--end::Group-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-stack">
                            <!--begin::Wrapper-->
                            <div class="me-2">
                                <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                    Retour
                                </button>
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Wrapper-->
                            <div>
                                <button type="submit" class="btn btn-bank" data-kt-stepper-action="submit">
                                        <span class="indicator-label">
                                            Créer le dossier
                                        </span>
                                    <span class="indicator-progress">
                                            Veuillez patienter... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                </button>

                                <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                    Suivant
                                </button>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
            <!--end::Stepper-->
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.wallet.createPret")
@endsection

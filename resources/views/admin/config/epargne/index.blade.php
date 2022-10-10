@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Plan d'épargne</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-muted text-hover-primary">Administration</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href=""
                   class="text-muted text-hover-primary">Configuration</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Plan d'épargne</li>
        </ul>
    </div>
    <!--<div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
    </div>-->
@endsection

@section("content")
<div class="card card-flush shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Liste des plan d'épargne</h3>
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#AddPlan">
                <i class="fa-solid fa-plus me-2"></i> Nouveau plan
            </button>
        </div>
    </div>
    <div class="card-body py-5">
        <div class="d-flex align-items-center position-relative my-1">
            <i class="fa-solid fa-search fa-lg position-absolute ms-4"></i>
            <input type="text" data-kt-plan-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..." />
        </div>
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_plan_table" aria-describedby="Liste des banque">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px" scope="col">Designation</th>
                <th class="min-w-100px" scope="col">Informations</th>
                <th class="min-w-75px" scope="col"></th>
            </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
            @foreach($plans as $plan)
                <tr>
                    <td class="w-250px">{{ $plan->name }}</td>
                    <td>
                        <strong>Taux:</strong> {{ $plan->profit_percent }} %<br>
                        <strong>Disponibilité:</strong>
                        @if($plan->lock_days != 0)
                            Disponible après {{ $plan->lock_days }} jours à compter de la signature de votre contrat.
                        @else
                            Immédiate, votre argent est 100% disponible, par un virement sur votre compte courant.
                        @endif
                        <br>
                        <strong>Calcul des intêrets acquis:</strong> Tous les {{ $plan->profit_days }} jours.<br>
                        <strong>Dépot Initial:</strong> {{ eur($plan->init) }}<br>
                        <strong>Plafond:</strong> {{ eur($plan->limit) }}, au-delà de ce plafond, vos nouveaux versements seront crédités sur un livret LEF et bénéficieront d’un taux d’intérêt annuel de 0,10% brut.<br>
                    </td>
                    <td>
                        <button class="btn btn-circle btn-icon btn-primary btnEdit" data-plan="{{ $plan->id }}"><i class="fa-solid fa-edit" data-plan="{{ $plan->id }}"></i> </button>
                        <button class="btn btn-circle btn-icon btn-danger btnDelete" data-plan="{{ $plan->id }}"><i class="fa-solid fa-trash" data-plan="{{ $plan->id }}"></i> </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
    <div class="modal fade" tabindex="-1" id="AddPlan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Ajout d'un plan d'épargne</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formAddPlan" action="{{ route('admin.config.epargne.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            type="text"
                            name="name"
                            label="Nom du plan"
                            required="true"
                            value="{{ old('name') }}" />

                        <div class="row">
                            <div class="col-4">
                                <x-form.input-group
                                    name="profit_percent"
                                    symbol="%"
                                    placement="right"
                                    label="Taux d'intêret"
                                    required="true" />
                            </div>
                            <div class="col-4">
                                <x-form.input
                                    name="lock_days"
                                    type="text"
                                    label="Disponibilité"
                                    required="true" />
                            </div>
                            <div class="col-4">
                                <x-form.input
                                    name="profit_days"
                                    type="text"
                                    label="Nb de jours d'interval pour les intêrets"
                                    required="true" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <x-form.input-group
                                    name="init"
                                    symbol="€"
                                    placement="right"
                                    label="Montant Initial"
                                    required="true" />
                            </div>
                            <div class="col-6">
                                <x-form.input-group
                                    name="limit"
                                    symbol="€"
                                    placement="right"
                                    label="Plafond"
                                    required="true" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="EditPlan">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Edition d'un plan d'épargne</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formEditPlan" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            type="text"
                            name="name"
                            label="Nom du plan"
                            required="true"
                            value="{{ old('name') }}" />

                        <div class="row">
                            <div class="col-4">
                                <x-form.input-group
                                    name="profit_percent"
                                    symbol="%"
                                    placement="right"
                                    label="Taux d'intêret"
                                    required="true" />
                            </div>
                            <div class="col-4">
                                <x-form.input
                                    name="lock_days"
                                    type="text"
                                    label="Disponibilité"
                                    required="true" />
                            </div>
                            <div class="col-4">
                                <x-form.input
                                    name="profit_days"
                                    type="text"
                                    label="Nb de jours d'interval pour les intêrets"
                                    required="true" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <x-form.input-group
                                    name="init"
                                    symbol="€"
                                    placement="right"
                                    label="Montant Initial"
                                    required="true" />
                            </div>
                            <div class="col-6">
                                <x-form.input-group
                                    name="limit"
                                    symbol="€"
                                    placement="right"
                                    label="Plafond"
                                    required="true" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("admin.scripts.config.epargne.index")
@endsection

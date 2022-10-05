@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Agence</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-muted text-hover-primary">Administration</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="" class="text-muted text-hover-primary">ERP</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Agence</li>
        </ul>
    </div>
    <!--<div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
    </div>-->
@endsection

@section("content")
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="fa-solid fa-search fa-lg position-absolute ms-4"></i>
                    <input type="text" data-kt-agence-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..." />
                </div>
                <!--end::Search-->
                <!--begin::Export buttons-->
                <div id="kt_log_bank_export" class="d-none"></div>
                <!--end::Export buttons-->
            </div>
            <!--end::Card title-->
            <div class="card-toolbar">
                <button class="btn btn-outline btn-outline-primary" data-bs-toggle="modal" data-bs-target="#AddAgency">Nouvelle Agence</button>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_agence_table">
                <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-100px">Nom de l'agence</th>
                    <th class="min-w-75px">Identification</th>
                    <th class="min-w-75px">Coordonnée</th>
                    <th class="min-w-75px">En ligne</th>
                    <th class="min-w-75px"></th>
                </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                @foreach($agences as $agence)
                    <tr>
                        <td>{{ $agence->name }}</td>
                        <td>
                            <strong>BIC:</strong> {{ $agence->bic }}<br>
                            <strong>Code Banque:</strong> {{ $agence->code_banque }}<br>
                            <strong>Code Agence:</strong> {{ $agence->code_agence }}<br>
                        </td>
                        <td>
                            {{ $agence->address }}<br>
                            {{ $agence->postal }} {{ $agence->city }}<br>
                            {{ $agence->country }}<br>
                            <div class="pt-3">
                                <i class="fa-solid fa-phone"></i>: {{ $agence->phone }}
                            </div>
                        </td>
                        <td>{!! $agence->online_label !!}</td>
                        <td>
                            <button class="btn btn-circle btn-icon btn-default viewAgency" data-agency="{{ $agence->id }}" data-bs-toggle="tooltip" title="Information sur l'agence"><i class="fa-solid fa-eye"></i> </button>
                            <button class="btn btn-circle btn-icon btn-primary editAgency" data-agency="{{ $agence->id }}" data-bs-toggle="tooltip" title="Editer l'agence"><i class="fa-solid fa-edit"></i> </button>
                            <button class="btn btn-circle btn-icon btn-danger deleteAgency" data-agency="{{ $agence->id }}" data-bs-toggle="tooltip" title="Supprimer l'agence"><i class="fa-solid fa-trash"></i> </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="AddAgency">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Nouvelle Agence</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formAddAgency" action="{{ route('admin.erp.agence.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            type="text"
                            name="name"
                            label="Nom de l'agence"
                            required="true" />

                        <x-form.input
                            type="text"
                            name="address"
                            label="Adresse Postal"
                            required="true" />

                        <div class="row">
                            <div class="col-4">
                                <x-form.input
                                    type="text"
                                    name="postal"
                                    label="Code Postal"
                                    required="true" />
                            </div>
                            <div class="col-5">
                                <x-form.input
                                    type="text"
                                    name="city"
                                    label="Ville"
                                    required="true" />
                            </div>
                            <div class="col-3">
                                <div class="mb-10">
                                    <label for="country" class="required form-label">
                                        Pays
                                    </label>
                                    <select id="country" class="form-select form-select-solid" data-placeholder="Selectionnez un pays de naissance" name="country" data-dropdown-parent="#AddAgency">
                                        <option value=""></option>
                                        @foreach(\App\Helper\GeoHelper::getAllCountries() as $data)
                                            <option value="{{ $data->name }}" data-kt-select2-country="{{ $data->flag }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <x-form.input-group
                            name="phone"
                            symbol="<i class='fa-solid fa-phone'></i>"
                            placement="left"
                            label="Téléphone"
                            required="true" />

                        <x-form.switches
                            name="online"
                            label="Cette agence est une agence en ligne"
                            value="1" />

                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="viewAgence">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white" data-content="title"></h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="card card-flush shadow-sm">
                                <div class="card-body py-5">
                                    <div class="d-flex flex-center mb-20">
                                        <div class="symbol symbol-125px symbol-circle">
                                            <div class="symbol-label fs-2tx fw-semibold text-success" data-content="agenceSl"></div>
                                        </div>
                                    </div>
                                    <div class="fw-bolder fs-3 mb-5">Information</div>
                                    <div class="d-flex flex-row align-items-center mb-10">
                                        <div class="symbol symbol-50px symbol-circle me-5">
                                            <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-location-dot"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column mb-10">
                                            <div class="fw-bolder">Adresse Postal</div>
                                            <div class="" data-content="address">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-10">
                                        <div class="symbol symbol-50px symbol-circle me-5">
                                            <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-phone"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column mb-10">
                                            <div class="fw-bolder">Communication</div>
                                            <div class="" data-content="communication">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-10">
                                        <div class="symbol symbol-50px symbol-circle me-5">
                                            <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-at"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column mb-10">
                                            <div class="fw-bolder">Type d'agence</div>
                                            <div class="" data-content="agence_type">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card card-flush shadow-sm mb-5">
                                <div class="card-body py-5">
                                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                                        <!--begin::Body-->
                                        <div class="card-body">
                                            <i class="fa-solid fa-users text-primary fs-2tx ms-n1"></i>
                                            <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5" data-content="count_user">0</div>
                                            <div class="fw-semibold text-gray-400">Client dans l'agence</div>
                                        </div>
                                        <!--end::Body-->
                                    </a>
                                </div>
                            </div>
                            <div class="card card-flush shadow-sm">
                                <div class="card-body py-5">
                                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8 bg-light-primary">
                                        <!--begin::Body-->
                                        <div class="card-body">
                                            <i class="fa-solid fa-users text-primary fs-2tx ms-n1"></i>
                                            <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5" data-content="sum_wallet">0</div>
                                            <div class="fw-semibold text-gray-400">Total de l'agence</div>
                                        </div>
                                        <!--end::Body-->
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("admin.scripts.erp.agence.index")
@endsection

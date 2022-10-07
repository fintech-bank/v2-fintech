@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Distributeur</h1>
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
            <li class="breadcrumb-item text-dark">Distributeur</li>
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
                    <input type="text" data-kt-reseller-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..." />
                </div>
                <!--end::Search-->
                <!--begin::Export buttons-->
                <div id="kt_log_bank_export" class="d-none"></div>
                <!--end::Export buttons-->
            </div>
            <div class="card-toolbar">
                <button class="btn btn-circle btn-outline btn-outline-primary" data-bs-toggle="modal" data-bs-target="#AddReseller"><i class="fa-solid fa-plus"></i> Nouveau distributeur</button>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_reseller_table" aria-describedby="Liste des banque">
                <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-100px" scope="col">Identité</th>
                    <th class="min-w-75px" scope="col">Coordonnée</th>
                    <th class="min-w-75px" scope="col">Etat</th>
                    <th class="min-w-75px" scope="col"></th>
                </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                @foreach($resellers as $reseller)
                    <tr>
                        <td>
                            <div class="d-flex flex-row">
                                <div class="symbol symbol-50px symbol-2by3">
                                    <img src="{{ $reseller->dab->img }}" alt=""/>
                                </div>
                                <div class="d-flex flex-column ms-5">
                                    <div class="fw-bolder">{{ $reseller->dab->name }}</div>
                                    <div class="text-muted">{{ $reseller->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $reseller->dab->address }}<br>
                            {{ $reseller->dab->postal }} {{ $reseller->dab->city }}<br>
                            <a href="tel:{{ $reseller->dab->phone }}"><i class="fa-solid fa-phone me-2"></i>: {{ $reseller->dab->phone }}</a><br>
                            <a href="mailto:{{ $reseller->user->email }}"><i class="fa-solid fa-envelope me-2"></i>: {{ $reseller->user->email }}</a><br>
                        </td>
                        <td>{!! $reseller->status_label !!}</td>
                        <td>
                            <a href="{{ route('admin.erp.reseller.show', $reseller->id) }}" class="btn btn-circle btn-icon btn-light" data-bs-toggle="tooltip" title="Fiche"><i class="fa-solid fa-eye"></i> </a>
                            <a href="{{ route('admin.erp.reseller.edit', $reseller->id) }}" class="btn btn-circle btn-icon btn-primary" data-bs-toggle="tooltip" title="Editer"><i class="fa-solid fa-edit"></i> </a>
                            <button class="btn btn-circle btn-icon btn-danger btnDeleteReseller" data-reseller="{{ $reseller->id }}" data-bs-toggle="tooltip" title="Supprimer"><i class="fa-solid fa-trash"></i> </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="AddReseller">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Nouveau distributeur</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formAddReseller" action="{{ route('admin.erp.reseller.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            type="text"
                            name="name"
                            label="Raison social"
                            required="true"
                            value="{{ old('name') }}"/>

                        <div class="mb-10">
                            <label for="" class="form-label required">Type</label>
                            <select class="form-control form-control-solid" name="type">
                                <option value="bank" {{ old('type') == 'bank' ? 'selected' : '' }}>Banque & Distributeur</option>
                                <option value="supermarket" {{ old('type') == 'supermarket' ? 'selected' : '' }}>Grande Distribution</option>
                                <option value="tabac" {{ old('type') == 'tabac' ? 'selected' : '' }}>Tabac / Presse</option>
                            </select>
                        </div>

                        <div class="mb-10">
                            <label for="" class="form-label required">Etat</label>
                            <select class="form-control form-control-solid" name="open">
                                <option value="1" {{ old('open') == 1 ? 'selected' : '' }}>Ouvert</option>
                                <option value="0" {{ old('open') == 0 ? 'selected' : '' }}>Fermé</option>
                            </select>
                        </div>

                        <x-base.underline
                            title="Adresse" size-text="fs-3" size="3" />

                        <x-form.input
                            type="text"
                            name="address"
                            label="Adresse"
                            required="true"
                            value="{{ old('address') }}"/>

                        <div class="row">
                            <div class="col-4">
                                <x-form.input
                                    type="text"
                                    name="postal"
                                    label="Code Postal"
                                    required="true"
                                    value="{{ old('postal') }}"/>
                            </div>
                            <div class="col-8">
                                <x-form.input
                                    type="text"
                                    name="city"
                                    label="Ville"
                                    required="true"
                                    value="{{ old('city') }}"/>
                            </div>
                        </div>

                        <x-base.underline
                            title="Communication" size-text="fs-3" size="3" />

                        <x-form.input-group
                            name="phone"
                            label="Téléphone"
                            symbol="<i class='fa-solid fa-phone'></i>"
                            placement="left"
                            required="true"
                            value="{{ old('phone') }}"/>

                        <x-form.input-group
                            name="email"
                            label="Adresse Mail"
                            symbol="<i class='fa-solid fa-envelope'></i>"
                            placement="left"
                            required="true"
                            value="{{ old('email') }}"/>

                        <x-form.input-file
                            name="logo"
                            label="Logo de votre entreprise"
                            required="true" />

                        <x-base.underline
                            title="Définissions des limites" size-text="fs-3" size="3" />

                        <div class="row">
                            <div class="col-6">
                                <x-form.input-group
                                    name="limit_outgoing"
                                    label="Limite de retrait"
                                    symbol="<i class='fa-solid fa-arrow-up'></i>"
                                    placement="left"
                                    required="true"
                                    value="{{ old('limit_outgoing') }}"/>
                            </div>
                            <div class="col-6">
                                <x-form.input-group
                                    name="limit_incoming"
                                    label="Limite de dépot"
                                    symbol="<i class='fa-solid fa-arrow-down'></i>"
                                    placement="left"
                                    required="true"
                                    value="{{ old('limit_incoming') }}"/>
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
    @include("admin.scripts.erp.reseller.index")
@endsection

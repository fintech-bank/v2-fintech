@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Service Bancaire</h1>
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
            <li class="breadcrumb-item text-dark">Service Bancaire</li>
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
        <h3 class="card-title">Liste des service bancaire</h3>
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#AddService">
                <i class="fa-solid fa-plus me-2"></i> Nouveau service
            </button>
        </div>
    </div>
    <div class="card-body py-5">
        <div class="d-flex align-items-center position-relative my-1">
            <i class="fa-solid fa-search fa-lg position-absolute ms-4"></i>
            <input type="text" data-kt-service-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..." />
        </div>
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_pret_table" aria-describedby="Liste des banque">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px" scope="col">Designation</th>
                <th class="min-w-100px" scope="col">Information</th>
                <th class="min-w-75px" scope="col"></th>
            </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
            @foreach($services as $service)
                <tr>
                    <td class="w-250px">{{ $service->name }}</td>
                    <td class="w-550px">
                        <strong>Tarif:</strong> {{ $service->price_format }}<br>
                        <strong>Fréquence:</strong> {{ $service->type_prlv_text }}<br>
                    </td>
                    <td>
                        <button class="btn btn-circle btn-icon btn-primary btnEdit" data-service="{{ $service->id }}"><i class="fa-solid fa-edit" data-service="{{ $service->id }}"></i> </button>
                        <button class="btn btn-circle btn-icon btn-danger btnDelete" data-service="{{ $service->id }}"><i class="fa-solid fa-trash" data-service="{{ $service->id }}"></i> </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
    <div class="modal fade" tabindex="-1" id="AddService">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Ajout d'un service bancaire</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formAddService" action="{{ route('admin.config.service.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            type="text"
                            name="name"
                            label="Nom du service bancaire"
                            required="true"
                            value="{{ old('name') }}" />

                        <div class="mb-10">
                            <label for="type_prlv" class="form-label required">Fréquence de prélèvement</label>
                            <select name="type_prlv" id="type_prlv" class="form-control" data-control="select2" data-parent="#AddService" data-placeholder="Selectionnez une fréquence..." required>
                                <option value=""></option>
                                <option value="ponctual">Ponctuel</option>
                                <option value="mensual">Mensuel</option>
                                <option value="trim">Trimestriel</option>
                                <option value="sem">Semestriel</option>
                                <option value="annual">Annuel</option>
                            </select>
                        </div>

                        <x-form.input-group
                            name="price"
                            label="Tarif"
                            symbol="€"
                            placement="right"
                            required="true" />

                        <div class="mb-10">
                            <label for="package_id" class="form-label">Forfait associé</label>
                            <select name="package_id" id="package_id" class="form-control" data-control="select2" data-parent="#AddService" data-placeholder="Selectionnez un forfait...">
                                <option value=""></option>
                                @foreach(\App\Models\Core\Package::all() as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="EditService">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Edition d'un service bancaire</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formEditService" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            type="text"
                            name="name"
                            label="Nom du service bancaire"
                            required="true"
                            value="{{ old('name') }}" />

                        <div class="mb-10">
                            <label for="type_prlv" class="form-label required">Fréquence de prélèvement</label>
                            <select name="type_prlv" id="type_prlv" class="form-control" data-control="select2" data-parent="#AddService" data-placeholder="Selectionnez une fréquence..." required>
                                <option value=""></option>
                                <option value="ponctual">Ponctuel</option>
                                <option value="mensual">Mensuel</option>
                                <option value="trim">Trimestriel</option>
                                <option value="sem">Semestriel</option>
                                <option value="annual">Annuel</option>
                            </select>
                        </div>

                        <x-form.input-group
                            name="price"
                            label="Tarif"
                            symbol="€"
                            placement="right"
                            required="true" />

                        <div class="mb-10">
                            <label for="package_id" class="form-label">Forfait associé</label>
                            <select name="package_id" id="package_id" class="form-control" data-control="select2" data-parent="#AddService" data-placeholder="Selectionnez un forfait...">
                                <option value=""></option>
                                @foreach(\App\Models\Core\Package::all() as $package)
                                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach
                            </select>
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
    @include("admin.scripts.config.service.index")
@endsection

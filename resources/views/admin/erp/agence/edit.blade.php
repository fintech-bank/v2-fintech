@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Edition de l'agence {{ $agency->name }}</h1>
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
            <li class="breadcrumb-item text-muted">
                <a href="" class="text-muted text-hover-primary">Agence</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Edition de l'agence {{ $agency->name }}</li>
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
            <h3 class="card-title">Edition de l'agence {{ $agency->name }}</h3>
        </div>
        <form id="formEditAgency" action="/api/core/agency/{{ $agency->id }}" method="POST">
            @csrf
            <div class="card-body py-5">
                <x-form.input
                    type="text"
                    name="name"
                    label="Nom de l'agence"
                    required="true"
                    value="{{ $agency->name }} "/>

                <x-form.input
                    type="text"
                    name="address"
                    label="Adresse Postal"
                    required="true"
                    value="{{ $agency->address }}" />

                <div class="row">
                    <div class="col-4">
                        <x-form.input
                            type="text"
                            name="postal"
                            label="Code Postal"
                            required="true"
                            value="{{ $agency->postal }}" />
                    </div>
                    <div class="col-5">
                        <x-form.input
                            type="text"
                            name="city"
                            label="Ville"
                            required="true"
                            value="{{ $agency->city }}"/>
                    </div>
                    <div class="col-3">
                        <div class="mb-10">
                            <label for="country" class="required form-label">
                                Pays
                            </label>
                            <select id="country" class="form-select form-select-solid" data-placeholder="Selectionnez un pays de naissance" name="country" data-dropdown-parent="#AddAgency">
                                <option value=""></option>
                                @foreach(\App\Helper\GeoHelper::getAllCountries() as $data)
                                    <option value="{{ $data->name }}" data-kt-select2-country="{{ $data->flag }}" @if($agency->country == $data->name) selected @endif>{{ $data->name }}</option>
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
                    required="true"
                    value="{{ $agency->phone }}" />

                <x-form.switches
                    name="online"
                    label="Cette agence est une agence en ligne"
                    value="1"
                    check="{{ $agency->online == 1 ? 'checked' : '' }}"/>
            </div>
            <div class="card-footer">
                <x-form.button />
            </div>
        </form>
    </div>
@endsection

@section("script")
    @include("admin.scripts.erp.agence.index")
@endsection

@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">{{ $reseller->dab->name }}</h1>
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
                <a href="" class="text-muted text-hover-primary">Distributeur</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">{{ $reseller->dab->name }}</li>
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
            <h3 class="card-title">Edition du distributeur</h3>
        </div>
        <form id="formEdit" action="{{ route('admin.erp.reseller.update', $reseller->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="card-body py-5">
                <x-form.input
                    type="text"
                    name="name"
                    label="Raison social"
                    required="true"
                    value="{{ $reseller->dab->name }}"/>

                <div class="mb-10">
                    <label for="" class="form-label required">Type</label>
                    <select class="form-control form-control-solid" name="type">
                        <option value="bank" {{ $reseller->dab->type == 'bank' ? 'selected' : '' }}>Banque & Distributeur</option>
                        <option value="supermarket" {{ $reseller->dab->type == 'supermarket' ? 'selected' : '' }}>Grande Distribution</option>
                        <option value="tabac" {{ $reseller->dab->type == 'tabac' ? 'selected' : '' }}>Tabac / Presse</option>
                    </select>
                </div>

                <div class="mb-10">
                    <label for="" class="form-label required">Etat</label>
                    <select class="form-control form-control-solid" name="open">
                        <option value="1" {{ $reseller->dab->open == 1 ? 'selected' : '' }}>Ouvert</option>
                        <option value="0" {{ $reseller->dab->open == 0 ? 'selected' : '' }}>Fermé</option>
                    </select>
                </div>

                <x-base.underline
                    title="Adresse" size-text="fs-3" size="3" />

                <x-form.input
                    type="text"
                    name="address"
                    label="Adresse"
                    required="true"
                    value="{{ $reseller->dab->address }}"/>

                <div class="row">
                    <div class="col-4">
                        <x-form.input
                            type="text"
                            name="postal"
                            label="Code Postal"
                            required="true"
                            value="{{ $reseller->dab->postal }}"/>
                    </div>
                    <div class="col-8">
                        <x-form.input
                            type="text"
                            name="city"
                            label="Ville"
                            required="true"
                            value="{!! $reseller->dab->city !!}"/>
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
                    value="{{ $reseller->dab->phone }}"/>

                <x-form.input-group
                    name="email"
                    label="Adresse Mail"
                    symbol="<i class='fa-solid fa-envelope'></i>"
                    placement="left"
                    required="true"
                    value="{{ $reseller->user->email }}"/>

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
                            value="{{ $reseller->limit_outgoing}}"/>
                    </div>
                    <div class="col-6">
                        <x-form.input-group
                            name="limit_incoming"
                            label="Limite de dépot"
                            symbol="<i class='fa-solid fa-arrow-down'></i>"
                            placement="left"
                            required="true"
                            value="{{ $reseller->limit_incoming }}"/>
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

@endsection

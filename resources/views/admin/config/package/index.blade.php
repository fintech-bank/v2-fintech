@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Forfait bancaire</h1>
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
            <li class="breadcrumb-item text-dark">Forfait Bancaire</li>
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
        <h3 class="card-title">Liste des forfaits bancaires</h3>
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#AddForfait">
                <i class="fa-solid fa-plus me-2"></i> Nouveau forfait
            </button>
        </div>
    </div>
    <div class="card-body py-5">
        <div class="d-flex align-items-center position-relative my-1">
            <i class="fa-solid fa-search fa-lg position-absolute ms-4"></i>
            <input type="text" data-kt-forfait-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..." />
        </div>
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_forfait_table" aria-describedby="Liste des banque">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px" scope="col">Designation</th>
                <th class="" scope="col">Prix</th>
                <th class="min-w-100px" scope="col">Type de compte</th>
                <th class="min-w-100px" scope="col">Informations</th>
                <th class="min-w-75px" scope="col"></th>
            </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
            @foreach($packages as $package)
                <tr>
                    <td class="w-250px">{{ $package->name }}</td>
                    <td class="w-250px">{{ $package->price_format }}</td>
                    <td>{!! $package->type_cpt_label !!}</td>
                    <td></td>
                    <td>
                        <button class="btn btn-circle btn-icon btn-primary btnEdit" data-forfait="{{ $package->id }}"><i class="fa-solid fa-edit" data-forfait="{{ $package->id }}"></i> </button>
                        <button class="btn btn-circle btn-icon btn-danger btnDelete" data-forfait="{{ $package->id }}"><i class="fa-solid fa-trash" data-forfait="{{ $package->id }}"></i> </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="AddForfait">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-bank">
                <h3 class="modal-title text-white">Nouveau forfait bancaire</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark text-white"></i>
                </div>
                <!--end::Close-->
            </div>
            <form id="formAddForfait" action="{{ route('admin.config.package.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-9">
                            <x-form.input
                                name="name"
                                label="Nom du forfait"
                                required="true" />
                        </div>
                        <div class="col-3">
                            <x-form.input-group
                                name="price"
                                label="Tarif"
                                symbol="€"
                                placement="right"
                                required="true" />
                        </div>
                    </div>

                    <x-form.select-modal
                        name="type_cpt"
                        parent="#AddForfait"
                        :datas="\App\Models\Core\Package::dataTypeCpt()->toJson()"
                        label="Type de Compte"
                        required="true"
                        placeholder="Selectionner un type de compte" />

                    <x-form.select-modal
                        name="type_prlv"
                        parent="#AddForfait"
                        :datas="\App\Models\Core\Package::dataTypePrlv()->toJson()"
                        label="Fréquence de prélèvement"
                        required="true"
                        placeholder="Selectionner une fréquence de prélèvement" />

                    <x-form.checkbox
                        name="visa_classic"
                        label="Disponibilité d'une carte bancaire Visa Classic"
                        value="1"
                        checked="true" />

                    <x-form.checkbox
                        name="check_deposit"
                        label="Dépot de chèque"
                        value="1"
                        checked="true" />

                    <x-form.checkbox
                        name="payment_withdraw"
                        label="Retraits et paiements illimités en zone euro"
                        value="1" />

                    <x-form.checkbox
                        name="overdraft"
                        label="Mise en place du découvert autorisé"
                        value="1" />

                    <x-form.checkbox
                        name="cash_deposit"
                        label="Dépot d'espèce"
                        value="1" />

                    <x-form.checkbox
                        name="withdraw_international"
                        label="Retrait à l'internationnal"
                        value="1" />

                    <x-form.checkbox
                        name="payment_international"
                        label="Payment à l'internationnal"
                        value="1" />

                    <x-form.checkbox
                        name="payment_insurance"
                        label="Assurance des moyens de paiement"
                        value="1" />

                    <x-form.checkbox
                        name="check"
                        label="Mise à disposition d'un chéquier"
                        value="1" />

                    <div class="row">
                        <div class="col">
                            <x-form.input-group
                                name="nb_carte_physique"
                                label="Nombre de carte physique"
                                symbol="<i class='fa-solid fa-credit-card'></i>"
                                placement="right" />
                        </div>
                        <div class="col">
                            <x-form.input-group
                                name="nb_carte_virtuel"
                                label="Nombre de carte virtuel"
                                symbol="<i class='fa-solid fa-credit-card'></i>"
                                placement="right" />
                        </div>
                        <div class="col">
                            <x-form.input-group
                                name="subaccount"
                                label="Sous compte"
                                symbol="<i class='fa-solid fa-users-rectangle'></i>"
                                placement="right" />
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
<div class="modal fade" tabindex="-1" id="EditForfait">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-bank">
                <h3 class="modal-title text-white" data-content="title"></h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark text-white"></i>
                </div>
                <!--end::Close-->
            </div>
            <form id="formEditForfait" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-9">
                            <x-form.input
                                name="name"
                                label="Nom du forfait"
                                required="true" />
                        </div>
                        <div class="col-3">
                            <x-form.input-group
                                name="price"
                                label="Tarif"
                                symbol="€"
                                placement="right"
                                required="true" />
                        </div>
                    </div>

                    <x-form.select-modal
                        name="type_cpt"
                        parent="#EditForfait"
                        :datas="\App\Models\Core\Package::dataTypeCpt()->toJson()"
                        label="Type de Compte"
                        required="true"
                        placeholder="Selectionner un type de compte" />

                    <x-form.select-modal
                        name="type_prlv"
                        parent="#EditForfait"
                        :datas="\App\Models\Core\Package::dataTypePrlv()->toJson()"
                        label="Fréquence de prélèvement"
                        required="true"
                        placeholder="Selectionner une fréquence de prélèvement" />

                    <x-form.checkbox
                        name="visa_classic"
                        label="Disponibilité d'une carte bancaire Visa Classic"
                        value="1"
                        checked="true" />

                    <x-form.checkbox
                        name="check_deposit"
                        label="Dépot de chèque"
                        value="1"
                        checked="true" />

                    <x-form.checkbox
                        name="payment_withdraw"
                        label="Retraits et paiements illimités en zone euro"
                        value="1" />

                    <x-form.checkbox
                        name="overdraft"
                        label="Mise en place du découvert autorisé"
                        value="1" />

                    <x-form.checkbox
                        name="cash_deposit"
                        label="Dépot d'espèce"
                        value="1" />

                    <x-form.checkbox
                        name="withdraw_international"
                        label="Retrait à l'internationnal"
                        value="1" />

                    <x-form.checkbox
                        name="payment_international"
                        label="Payment à l'internationnal"
                        value="1" />

                    <x-form.checkbox
                        name="payment_insurance"
                        label="Assurance des moyens de paiement"
                        value="1" />

                    <x-form.checkbox
                        name="check"
                        label="Mise à disposition d'un chéquier"
                        value="1" />

                    <div class="row">
                        <div class="col">
                            <x-form.input-group
                                name="nb_carte_physique"
                                label="Nombre de carte physique"
                                symbol="<i class='fa-solid fa-credit-card'></i>"
                                placement="right" />
                        </div>
                        <div class="col">
                            <x-form.input-group
                                name="nb_carte_virtuel"
                                label="Nombre de carte virtuel"
                                symbol="<i class='fa-solid fa-credit-card'></i>"
                                placement="right" />
                        </div>
                        <div class="col">
                            <x-form.input-group
                                name="subaccount"
                                label="Sous compte"
                                symbol="<i class='fa-solid fa-users-rectangle'></i>"
                                placement="right" />
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
    @include("admin.scripts.config.package.index")
@endsection

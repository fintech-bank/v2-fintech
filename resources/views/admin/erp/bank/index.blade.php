@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Banque</h1>
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
            <li class="breadcrumb-item text-dark">Banque</li>
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
                    <input type="text" data-kt-bank-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..." />
                </div>
                <!--end::Search-->
                <!--begin::Export buttons-->
                <div id="kt_log_bank_export" class="d-none"></div>
                <!--end::Export buttons-->
            </div>
            <div class="card-toolbar">

            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_bank_table" aria-describedby="Liste des banque">
                <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-100px" scope="col">Identité</th>
                    <th class="min-w-75px" scope="col">BIC</th>
                </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                @foreach($banks as $bank)
                    <tr>
                        <td>
                            <div class="d-flex flex-row">
                                <div class="symbol symbol-50px symbol-2by3">
                                    <img src="{{ $bank->logo }}" alt=""/>
                                </div>
                                <div class="d-flex flex-column ms-5">
                                    <div class="fw-bolder">{{ $bank->name }}</div>
                                    <div class="text-muted">{{ $bank->process_time }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $bank->bic }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("script")
    @include("admin.scripts.erp.bank.index")
@endsection

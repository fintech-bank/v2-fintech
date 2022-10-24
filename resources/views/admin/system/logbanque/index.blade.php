@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Log Bancaire</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Administration</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Système</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Log Bancaire</li>
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
                    <input type="text" data-kt-log-bank-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..." />
                </div>
                <!--end::Search-->
                <!--begin::Export buttons-->
                <div id="kt_log_bank_export" class="d-none"></div>
                <!--end::Export buttons-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <div class="w-100 mw-150px">
                    <!--begin::Select2-->
                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Type" data-kt-log-bank-filter="type">
                        <option></option>
                        <option value="all">Tous</option>
                        <option value="error">Erreur</option>
                        <option value="warning">Attention</option>
                        <option value="success">Réussi</option>
                        <option value="info">Information</option>
                    </select>
                    <!--end::Select2-->
                </div>
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_log_bank_table">
                <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-100px">Date</th>
                    <th class="min-w-75px">Type</th>
                    <th class="min-w-75px">Message</th>
                    <th class="min-w-75px">Utilisateur</th>
                </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        <td data-order="{{ $log->type }}">{!! $log->type_label !!}</td>
                        <td>{!! $log->message !!}</td>
                        <td>
                            @if(isset($log->user))
                                <div class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-circle symbol-50px">
                                        {!! \App\Helper\UserHelper::getAvatar($log->user->email) !!}
                                    </div>
                                    <div class="d-flex flex-column ms-4">
                                        <a href="" class="fw-bolder">{{ $log->user->name }}</a>
                                        <div class="text-muted">{{ $log->user->email }}</div>
                                        <div class="badge badge-{{ random_color() }}">{{ \App\Helper\UserHelper::getGroupNamed($log->user) }}</div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("script")
    @include("admin.scripts.system.logbanque.index")
@endsection

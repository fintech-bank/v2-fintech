@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Gestion clientèle</h1>
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
                <a href="{{ route('agent.customer.show', $wallet->customer->id) }}"
                   class="text-muted text-hover-primary">{{ $wallet->customer->user->identifiant }} - {{ $wallet->customer->info->full_name }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">{{ $wallet->type_text }} - N°{{ $wallet->loan->reference }}</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>-->
    </div>
@endsection

@section("content")
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <div class="symbol-label"><i class="fa-solid fa-wallet fs-2tx text-black"></i></div>
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-{{ $wallet->status_color }} rounded-circle border border-4 border-body h-20px w-20px" data-bs-toggle="tooltip" title="{{ $wallet->status_text }}"></div>
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $wallet->name_account_generic }}</a>
                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="fa-solid fa-bank me-1"></i>
                                    <span>{{ $wallet->iban }}</span>
                                </a>
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="fa-solid fa-circle-o-notch me-1"></i>
                                    <span>{{ $wallet->type_text }}</span>
                                </a>
                                @if($wallet->alert_debit)
                                    <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2" data-bs-toggle="popover" data-bs-trigger="hover" title="{{ $wallet->alert_status_text }}" data-bs-html="true" data-bs-content="{{ $wallet->alert_status_comment }}">
                                        <i class="fa-solid fa-exclamation-triangle text-warning me-1"></i>
                                        <span>Alert sur le compte</span>
                                    </a>
                                @endif
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <div class="d-flex my-4">
                            <button class="btn btn-sm btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="fa-solid fa-chevron-down fs-3 me-2"></i> Outils
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-300px py-3" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <a href="#showRib" class="menu-link px-3" data-bs-toggle="modal"><span class="iconify fs-3 me-2" data-icon="icon-park-twotone:bank-card"></span> Afficher le RIB</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#updateStateAccount" class="menu-link px-3" data-bs-toggle="modal"><span class="iconify fs-3 me-2" data-icon="fluent-mdl2:status-circle-checkmark"></span> Changer le status du compte</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Title-->
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-row flex-grow-1 pe-8">
                            &nbsp;<div class="d-flex flex-column border rounded p-2 mb-2 me-2">
                                <div class="fs-4 fw-bolder">Etat du Prêt</div>
                                <div class="" data-bs-toggle="tooltip" title="{{ $wallet->loan->status_explanation }}">{!! $wallet->loan->status_label !!}</div>
                            </div>
                            <div class="d-flex flex-column border rounded p-2 mb-2 me-2">
                                <div class="fs-4 fw-bolder">Type de pret</div>
                                <div class="">{{ $wallet->loan->plan->name }}</div>
                            </div>
                            <div class="d-flex flex-column border rounded p-2 mb-2 me-2">
                                <div class="fs-4 fw-bolder">Date de fin</div>
                                <div class="">{{ $wallet->loan->first_payment_at->addMonths($wallet->loan->duration)->format("d/m/Y") }}</div>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Progress-->
                        <div class="d-flex flex-column w-200px w-sm-650px mt-3">
                            <div class="d-flex flex-row align-items-center justify-content-between mb-2 p-5 border rounded-2">
                                <div class="fw-bolder fs-3 w-50">Capital restant du au {{ now()->format('d/m/Y') }}</div>
                                <div class="text-black fs-3 w-50 text-end">{{ $wallet->loan->amount_du_format }}</div>
                            </div>
                        </div>
                        <!--end::Progress-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#transactions"><i class="fa-solid fa-exchange me-2"></i> Transactions</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#infos"><i class="fa-solid fa-info-circle me-2"></i> Informations</a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.wallet.pret")
@endsection

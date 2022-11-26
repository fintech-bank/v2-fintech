@extends('agent.layouts.app')

@section('css')
@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Gestion clientèle</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}" class="text-muted text-hover-primary">Agence</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.index') }}" class="text-muted text-hover-primary">Client</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.show', $wallet->customer->id) }}"
                    class="text-muted text-hover-primary">{{ $wallet->customer->user->identifiant }} -
                    {{ $wallet->customer->info->full_name }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">{{ $wallet->type_text }} - N°{{ $wallet->number_account }}</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>-->
    </div>
@endsection

@section('content')
    <div id="app">
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <!--begin: Pic-->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <div class="symbol-label"><i class="fa-solid fa-wallet fs-2tx text-black"></i></div>
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-{{ $wallet->status_color }} rounded-circle border border-4 border-body h-20px w-20px"
                                data-bs-toggle="tooltip" title="{{ $wallet->status_text }}"></div>
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
                                    <a href="#"
                                        class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $wallet->name_account_generic }}</a>
                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <a href="#"
                                        class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="fa-solid fa-bank me-1"></i>
                                        <span>{{ $wallet->iban }}</span>
                                    </a>
                                    <a href="#"
                                        class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="fa-solid fa-circle-o-notch me-1"></i>
                                        <span>{{ $wallet->type_text }}</span>
                                    </a>
                                    @if ($wallet->alert_debit)
                                        <a href="#"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2"
                                            data-bs-toggle="popover" data-bs-trigger="hover"
                                            title="{{ $wallet->alert_status_text }}" data-bs-html="true"
                                            data-bs-content="{{ $wallet->alert_status_comment }}">
                                            <i class="fa-solid fa-exclamation-triangle text-warning me-1"></i>
                                            <span>Alert sur le compte</span>
                                        </a>
                                    @endif
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                            <div class="d-flex my-4">
                                <button class="btn btn-sm btn-bg-light btn-active-color-primary"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="fa-solid fa-chevron-down fs-3 me-2"></i> Outils
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-300px py-3"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="#showRib" class="menu-link px-3" data-bs-toggle="modal"><span
                                                class="iconify fs-3 me-2" data-icon="icon-park-twotone:bank-card"></span>
                                            Afficher le RIB</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#updateStateAccount" class="menu-link px-3" data-bs-toggle="modal"><span
                                                class="iconify fs-3 me-2"
                                                data-icon="fluent-mdl2:status-circle-checkmark"></span> Changer le status du
                                            compte</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Title-->
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap flex-stack">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                &nbsp;
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Progress-->
                            <div class="d-flex flex-column w-200px w-sm-450px mt-3">
                                <div
                                    class="d-flex flex-row align-items-center justify-content-between mb-2 p-5 border border-{{ $wallet->balance_actual <= 0 ? 'danger' : 'success' }} rounded-2">
                                    <div class="fw-bolder fs-2">Solde</div>
                                    <div class="text-{{ $wallet->balance_actual <= 0 ? 'danger' : 'success' }} fs-3">
                                        {{ $wallet->balance_actual_format }}</div>
                                </div>
                                <div
                                    class="d-flex flex-row align-items-center justify-content-between mb-2 p-5 border rounded-2">
                                    <div class="fw-bolder fs-2">Intêret</div>
                                    <div class="text-info fs-3">{{ $wallet->epargne->profit_format }}</div>
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
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab"
                            href="#transactions"><i class="fa-solid fa-exchange me-2"></i> Transactions</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#infos"><i
                                class="fa-solid fa-info-circle me-2"></i> Informations</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    @if (json_decode($wallet->epargne->plan->info_retrait)->retrait_type->transfer)
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab"
                                href="#transfers"><i class="fa-solid fa-exchange me-2"></i> Virements</a>
                        </li>
                    @endif

                    @if (json_decode($wallet->epargne->plan->info_retrait)->retrait_type->money ||
                        json_decode($wallet->epargne->plan->info_retrait)->retrait_type->card)
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab"
                                href="#withdraw"><i class="fa-solid fa-money-bill-transfer me-2"></i> Retrait bancaire</a>
                        </li>
                    @endif

                    @if (json_decode($wallet->epargne->plan->info_versement)->depot_type->money ||
                        json_decode($wallet->epargne->plan->info_versement)->depot_type->card ||
                        json_decode($wallet->epargne->plan->info_versement)->depot_type->check)
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab"
                                href="#deposit"><i class="fa-solid fa-money-bill-transfer me-2"></i> Dépot bancaire</a>
                        </li>
                    @endif

                    <!--end::Nav item-->
                </ul>
                <!--begin::Navs-->
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="transactions" role="tabpanel">
                <x-base.underline title="Transaction au {{ now()->format('d/m/Y') }}" class="w-650px" />
                <div class="separator border-gray-300 my-5"></div>
                <div class="w-50" data-kt-search-element="suggestions">

                    @foreach ($wallet->transactions()->where('confirmed', true)->orderBy('confirmed_at', 'desc')->get() as $transaction)
                        <div class="mb-5">
                            <a class="d-flex flex-row h-50px p-5 justify-content-between align-items-center rounded bg-white mb-0"
                                data-bs-toggle="collapse" href="#{{ $transaction->type }}_{{ $transaction->id }}">
                                <div class="d-flex flex-row align-items-center text-black">
                                    {!! $transaction->getTypeSymbolAttribute() !!}
                                    <div class="d-flex flex-column">
                                        {{ $transaction->designation }}<br>
                                        <div class="text-muted">
                                            {{ $transaction->confirmed ? $transaction->confirmed_at->format('d/m/Y') : ($transaction->differed ? $transaction->differed_at->format('d/m/Y') : $transaction->updated_at->format('d/m/Y')) }}
                                        </div>
                                    </div>
                                </div>
                                @if ($transaction->amount < 0)
                                    <span class="text-danger fs-2 fw-bolder">{{ $transaction->amount_format }}</span>
                                @else
                                    <span class="text-success fs-2 fw-bolder">+ {{ $transaction->amount_format }}</span>
                                @endif
                            </a>
                            <div class="collapse" id="{{ $transaction->type }}_{{ $transaction->id }}">
                                <div class="card card-body">
                                    <div class="ps-5 text-muted mb-5">{{ $transaction->type_text }}</div>
                                    <div class="mb-5">
                                        <x-base.underline title="Détails de l'opération" class="mb-2" size-text="fs-3"
                                            size="3" color="{{ $transaction->type_color }}" />
                                        <div class="d-flex flex-row justify-content-around">
                                            <div>Transaction effectuée le: {{ $transaction->updated_at->format('d/m/Y') }}
                                            </div>
                                            <div>Comptabilisé à la date du:
                                                {{ $transaction->confirmed ? $transaction->confirmed_at->format('d/m/Y') : ($transaction->differed ? $transaction->differed_at->format('d/m/Y') : $transaction->updated_at->format('d/m/Y')) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <x-base.underline title="Libellé complet" class="mb-2" size-text="fs-3"
                                            size="3" color="{{ $transaction->type_color }}" />
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold">{{ $transaction->designation }}</div>
                                            <div>{{ $transaction->description }}</div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        @if (!$transaction->confirmed)
                                            <button class="btn btn-lg btn-circle btn-success btnAcceptTransaction me-2"
                                                data-transaction="{{ $transaction->id }}"><i
                                                    class="fa-solid fa-check-circle me-2"></i> Accepter</button>
                                            <button class="btn btn-lg btn-circle btn-danger btnRejectTransaction me-2"
                                                data-transaction="{{ $transaction->id }}"><i
                                                    class="fa-solid fa-xmark-circle me-2"></i> Refuser</button>
                                        @endif
                                        @if ($transaction->type == 'payment')
                                            <button class="btn btn-lg btn-circle btn-info btnOppositPayment me-2"
                                                data-transaction="{{ $transaction->id }}"><i
                                                    class="fa-solid fa-ban me-2"></i> Opposition</button>
                                        @endif
                                        @if ($transaction->type == 'frais')
                                            <button class="btn btn-lg btn-circle btn-info btnRemb me-2"
                                                data-transaction="{{ $transaction->id }}"><i
                                                    class="fa-solid fa-exchange me-2"></i> Remboursement</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="tab-pane fade" id="infos" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="fw-bolder fs-1">Information sur le {{ $wallet->name_account_generic }}
                                    ({{ $wallet->epargne->plan->name }})</div>
                                <div class="separator separator-dashed my-5"></div>
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-sm-4">
                                        <div
                                            class="d-flex flex-row p-2 border border-dashed border-gray-400 h-100px align-items-center">
                                            <div class="symbol symbol-50px me-3">
                                                <div class="symbol-label"><i class="fa-solid fa-percentage fs-2"></i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h3 class="fw-bolder">Intêret</h3>
                                                <div class="fs-2">{{ $wallet->epargne->plan->profit_percent_format }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-4">
                                        <div
                                            class="d-flex flex-row p-2 border border-dashed border-gray-400 h-100px align-items-center">
                                            <div class="symbol symbol-50px me-3">
                                                <div class="symbol-label"><i class="fa-solid fa-unlock fs-2"></i> </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h3 class="fw-bolder">Déblocage des fond</h3>
                                                <div class="fs-2">
                                                    @if ($wallet->epargne->plan->lock_days == 0)
                                                        <span class="text-success">Disponible</span>
                                                    @else
                                                        @if (now()->startOfDay() <= $wallet->epargne->unlocked_at->startOfDay())
                                                            <div class="text-warning">
                                                                {{ now()->diffForHumans($wallet->epargne->unlocked_at) }}
                                                            </div>
                                                        @else
                                                            <span class="text-success">Disponible</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-4">
                                        <div
                                            class="d-flex flex-row p-2 border border-dashed border-gray-400 h-100px align-items-center">
                                            <div class="symbol symbol-50px me-3">
                                                <div class="symbol-label"><i class="fa-solid fa-calendar fs-2"></i> </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h3 class="fw-bolder">Prochain calcul des intêrets</h3>
                                                <div class="fs-2">
                                                    <span
                                                        class="text-warning">{{ $wallet->epargne->next_profit->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 justify-content-end">
                                        @if ($wallet->epargne->plan->limit_amount == 0 || $wallet->epargne->plan->limit_amount == 999999999)
                                            <div class="d-flex align-items-end flex-column mt-3 justify-content-end">
                                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                    <span class="fw-semibold fs-6 text-gray-400">Limite de fond</span>
                                                    <div class="">Aucune Limite</div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-end flex-column mt-3 justify-content-end">
                                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                    <span class="fw-semibold fs-6 text-gray-400">Limite de fond</span>
                                                    <span
                                                        class="fw-bold fs-6">{{ $wallet->epargne->getSoldeWalletForLimit('percent_format') }}</span>
                                                </div>
                                                <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                    <div class="bg-{{ $wallet->epargne->getSoldeWalletForLimit('color') }} rounded h-5px"
                                                        role="progressbar"
                                                        style="width: {{ $wallet->epargne->getSoldeWalletForLimit('percent') }}%;"
                                                        aria-valuenow="{{ $wallet->epargne->getSoldeWalletForLimit('percent') }}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="transfers" role="tabpanel">
                <button class="btn btn-bank w-100 mb-5" data-bs-toggle="modal" data-bs-target="#newTransfer"><i
                        class="fa-solid fa-plus-circle fs-2 text-white me-2"></i> Nouveau virement</button>
                <div class="mb-10">
                    <div class="fw-bolder fs-1 mb-5">Virement en attente</div>
                    @foreach ($wallet->transfers()->where('status', 'pending')->orWhere('status', 'in_transit')->get() as $transfer)
                        @if ($transfer->count() != 0)
                            <div class="card shadow-lg mb-5">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-5">
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold fs-2">{{ $transfer->beneficiaire->full_name }}</div>
                                            depuis <strong>{{ $transfer->wallet->name_account_generic }}</strong>
                                        </div>
                                        <div class="fs-1 fw-bolder">{{ $transfer->amount_format }}</div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                        {!! $transfer->status_label !!}
                                        {{ $transfer->transfer_date->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                        <div class="fw-bold fs-3">{{ $transfer->type_text }}</div>
                                        <div class="btn-group">
                                            <button class="btn btn-icon btn-bank btnViewTransfer"
                                                data-transfer="{{ $transfer->reference }}" data-bs-toggle="tooltip"
                                                title="Voir le virement"><i class="fa-solid fa-eye text-white"></i>
                                            </button>
                                            @if ($transfer->status == 'pending')
                                                <button class="btn btn-icon btn-success btnAcceptTransfer"
                                                    data-transfer="{{ $transfer->reference }}" data-bs-toggle="tooltip"
                                                    title="Accepter le virement"><i
                                                        class="fa-solid fa-check text-white"></i> </button>
                                                <button class="btn btn-icon btn-danger btnRefuseTransfer"
                                                    data-transfer="{{ $transfer->reference }}" data-bs-toggle="tooltip"
                                                    title="Refuser le virement"><i
                                                        class="fa-solid fa-xmark text-white"></i> </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="d-flex flex-center w-25 rounded p-5 shadow-sm">
                                <i class="fa-solid fa-xmark-circle fs-2hx text-danger mb-2"></i>
                                <div class="fs-1">Aucun virement en attente actuellement</div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="mb-10">
                    <div class="fw-bolder fs-1 mb-5">Virement passés</div>
                    @foreach ($wallet->transfers()->where('status', 'paid')->get() as $transfer)
                        @if ($transfer->count() != 0)
                            <div class="card shadow-lg mb-5">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-5">
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold fs-2">{{ $transfer->beneficiaire->full_name }}</div>
                                            depuis <strong>{{ $transfer->wallet->name_account_generic }}</strong>
                                        </div>
                                        <div class="fs-1 fw-bolder">{{ $transfer->amount_format }}</div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                        {!! $transfer->status_label !!}
                                        {{ $transfer->transfer_date->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex flex-row justify-content-between">
                                        {{ $transfer->type_text }}
                                        <a href="" class="btn btn-link"><i
                                                class="fa-solid fs-2 fa-refresh me-2"></i> Renouveler</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="d-flex flex-center w-25 rounded p-5 shadow-sm">
                                <i class="fa-solid fa-xmark-circle fs-2hx text-danger mb-2"></i>
                                <div class="fs-1">Aucun virement en attente actuellement</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @if (json_decode($wallet->epargne->plan->info_retrait)->retrait_type->money ||
                json_decode($wallet->epargne->plan->info_retrait)->retrait_type->card)
                <div class="tab-pane fade" id="withdraw" role="tabpanel">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Retrait Bancaire</h3>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal"
                                    data-bs-target="#addRetrait">
                                    Nouveau retrait
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped gx-5 gy-5">
                                <thead>
                                    <tr>
                                        <th>Référence</th>
                                        <th>Lieu de retrait</th>
                                        <th>Montant</th>
                                        <th>Etat</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wallet->withdraws as $withdraw)
                                        <tr>
                                            <td>{{ $withdraw->reference }}</td>
                                            <td>{{ $withdraw->dab->name }}</td>
                                            <td>{{ $withdraw->amount_format }}</td>
                                            <td>{{ $withdraw->status_text }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            @if (json_decode($wallet->epargne->plan->info_versement)->depot_type->money ||
                json_decode($wallet->epargne->plan->info_versement)->depot_type->card ||
                json_decode($wallet->epargne->plan->info_versement)->depot_type->check)
                <div class="tab-pane fade" id="deposit" role="tabpanel">
                    @if (json_decode($wallet->epargne->plan->info_versement)->depot_type->money ||
                        json_decode($wallet->epargne->plan->info_versement)->depot_type->card)
                        <div class="card shadow-sm mb-10">
                            <div class="card-header">
                                <h3 class="card-title">Dépot d'espèce</h3>
                                <div class="card-toolbar">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addDepot"
                                        class="btn btn-sm btn-light">
                                        Nouveau dépot
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped gx-5 gy-5">
                                    <thead>
                                        <tr>
                                            <th>Référence</th>
                                            <th>Lieu de dépot</th>
                                            <th>Montant</th>
                                            <th>Etat</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wallet->moneys as $withdraw)
                                            <tr>
                                                <td>{{ $withdraw->reference }}</td>
                                                <td>{{ $withdraw->dab->name }}</td>
                                                <td>{{ $withdraw->amount_format }}</td>
                                                <td>{{ $withdraw->status_text }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    @if (json_decode($wallet->epargne->plan->info_versement)->depot_type->check)
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Dépot de chèque</h3>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-light">
                                        Nouveau dépot
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped gx-5 gy-5">
                                    <thead>
                                        <tr>
                                            <th>Référence</th>
                                            <th>Montant</th>
                                            <th>Nb de chèque</th>
                                            <th>Etat</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wallet->deposits as $withdraw)
                                            <tr>
                                                <td>{{ $withdraw->reference }}</td>
                                                <td>{{ $withdraw->amount_format }}</td>
                                                <td>{{ $withdraw->lists->count() }}</td>
                                                <td>{{ $withdraw->status_text }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        <div class="modal fade" tabindex="-1" id="showRib">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-bank">
                        <h3 class="modal-title text-white"></h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-solid fa-xmark text-white fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="d-flex flex-row border rounded-2 justify-content-center border-gray-200 mb-15">
                            <div class="d-flex flex-column align-items-center p-2">
                                <strong>{{ $wallet->type_text }}</strong>
                                <p>{{ $wallet->name_account }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-row border justify-content-between align-items-center p-2 mb-2">
                            <div class="d-flex flex-column">
                                <div class="fs-2">IBAN</div>
                                <div class="fs-4 ibanText">{{ $wallet->iban }}</div>
                            </div>
                        </div>
                        <div class="d-flex flex-row border justify-content-between align-items-center p-2 mb-2">
                            <div class="d-flex flex-column">
                                <div class="fs-2">BIC</div>
                                <div class="fs-4 ibanText">{{ $wallet->customer->agency->bic }}</div>
                            </div>
                        </div>
                        <div class="d-flex flex-row border justify-content-between align-items-center p-2 mb-2">
                            <div class="d-flex flex-column">
                                <div class="fs-2">Code Banque</div>
                                <div class="fs-4 ibanText">{{ $wallet->customer->agency->code_banque }}</div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="fs-2">Code Agence</div>
                                <div class="fs-4 ibanText">{{ $wallet->customer->agency->code_agence }}</div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="fs-2">N° du compte</div>
                                <div class="fs-4 ibanText">{{ $wallet->number_account }}</div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="fs-2">Clé RIB</div>
                                <div class="fs-4 ibanText">{{ $wallet->rib_key }}</div>
                            </div>
                        </div>
                        <div class="d-flex flex-column p-2 mt-2">
                            {{ config('app.name') }}
                            <p>Agence: {{ $wallet->customer->agency->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="updateStateAccount">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-bank">
                        <h3 class="modal-title text-white">Changement du status du compte</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-solid fa-xmark text-white fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <form id="formUpdateStateAccount"
                        action="/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="action" value="state">
                        <div class="modal-body">
                            <div class="mb-10">
                                <label for="status" class="form-label required">Etat</label>
                                <select name="status" class="form-select form-select-solid" data-control="select2">
                                    <option value=""></option>
                                    @foreach (\App\Models\Customer\CustomerWallet::getState() as $state)
                                        <option value="{{ $state['slug'] }}"
                                            {{ $wallet->status == $state['slug'] ? 'selected' : '' }}>{{ $state['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex align-items-end">
                                <x-form.button />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="newTransfer">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-bank">
                        <h3 class="modal-title text-white">Nouveau virement</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-solid fa-xmark fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <form id="formNewTransfer" action="/api/epargne/{{ $wallet->epargne->reference }}/transfer"
                        method="post">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="customer_wallet_id" value="{{ $wallet->id }}">
                            <input type="hidden" name="customer_beneficiaire_id" value="{{ $wallet->customer->id }}">
                            <input type="hidden" name="type_wallet" value="epargne">

                            <div class="mb-10">
                                <label for="" class="form-label required">Destinataire du virement</label>
                                <select name="type_transfer" class="form-control selectpicker" required
                                    onchange="selectDestTransfer(this)">
                                    <option value="courant">Compte Courant</option>
                                    @if (json_decode($wallet->epargne->plan->info_retrait)->retrait_type->sepa_orga)
                                        <option value="orga">Organisme Public</option>
                                    @endif
                                    @if (json_decode($wallet->epargne->plan->info_retrait)->retrait_type->sepa_assoc)
                                        <option value="assoc">Association</option>
                                    @endif
                                </select>
                            </div>
                            <x-form.input name="amount" label="Montant à envoyer" :value="json_decode($wallet->epargne->plan->info_retrait)->amount" required="true" />

                            <div id="courant">
                                <div class="mb-10">
                                    <label for="" class="form-label required">Type de virement</label>
                                    <select name="type" class="form-control selectpicker" required
                                        onchange="selectTypeTransfer(this)">
                                        <option value="immediat">Immédiat</option>
                                        <option value="differed">Différé</option>
                                        <option value="permanent">Permanent</option>
                                    </select>
                                </div>
                                <div id="immediat">
                                    <x-form.input-date name="transfer_date" label="Date de transfer" :value="now()->hour >= 16
                                        ? now()
                                            ->addDay()
                                            ->format('Y-m-d H:i')
                                        : now()->format('Y-m-d H:i')" />
                                </div>
                                <div id="permanent">
                                    <x-form.input-date name="recurring_start" label="Date de début" />
                                    <x-form.input-date name="recurring_start" label="Date de fin" />
                                </div>
                            </div>
                            <div id="orga">
                                <x-form.input name="name_organisme" label="Nom de l'organisme publique" />

                                <x-form.input name="iban_organisme" label="IBAN de l'organisme" />
                            </div>
                            <div id="assoc">
                                <x-base.alert type="solid" color="primary" icon="info-circle" title="Information"
                                    content="Les virements vers une association est soumise au conditions des dons effectifs en réduction d'impôt" />

                                <x-form.input name="name_assoc" label="Nom de l'association" />

                                <x-form.input name="email_assoc" label="Adresse Mail de l'association" />

                                <x-form.input name="iban_assoc" label="IBAN de l'association" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <x-form.button />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="addRetrait">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-bank">
                        <h3 class="modal-title text-white">Nouveau retrait</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-solid fa-xmark fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <form id="formNewWithdraw" action="/api/epargne/{{ $wallet->epargne->reference }}/withdraw"
                        method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <x-form.input name="amount" class="form-control-transparent" label="Montant du retrait"
                                    text="Montant limité à votre solde de: {{ $wallet->solde_remaining }} €"
                                    required="true" />

                            </div>
                        </div>
                        <div class="modal-footer">
                            <x-form.button />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="addDepot">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-bank">
                        <h3 class="modal-title text-white">Nouveau depot d'espèce</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-solid fa-xmark fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <form id="formNewDeposit" action="/api/epargne/{{ $wallet->epargne->reference }}/deposit"
                        method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-10">
                                @if(json_decode($wallet->epargne->plan->info_versement)->depot_type->money)
                                    <div class="mb-3">
                                        <x-form.radio
                                            name="type_deposit"
                                            value="money"
                                            for="money"
                                            label="Dépot d'espèce" />
                                    </div>
                                @endif

                                @if(json_decode($wallet->epargne->plan->info_versement)->depot_type->check)
                                    <x-form.radio
                                        name="type_deposit"
                                        value="check"
                                        for="check"
                                        label="Dépot de chèque" />
                                @endif
                            </div>

                            @if(json_decode($wallet->epargne->plan->info_versement)->depot_type->money)
                                <div id="money_deposit">
                                    <x-form.input
                                        name="amount"
                                        label="Montant à déposé"
                                        required="true" />
                                </div>
                            @endif
                            @if(json_decode($wallet->epargne->plan->info_versement)->depot_type->check)
                                <div id="check_deposit">
                                    <x-form.input
                                        name="amount"
                                        label="Montant à déposé"
                                        required="true" />

                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                        <tr>
                                            <th>Date de dépot</th>
                                            <th>Numéro</th>
                                            <th>Montant</th>
                                            <th>Nom du chèque</th>
                                            <th>Banque</th>
                                            <th>Vérifié ?</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="date_deposit" class="form-control form-control-sm datepick">
                                            </td>
                                            <td>
                                                <input type="text" name="number[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="name_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="bank_deposit[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="verified[]" value="1" />
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        </div>
                        <div class="modal-footer">
                            <x-form.button />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('agent.scripts.customer.wallet.epargne')
@endsection

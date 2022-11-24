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
            <li class="breadcrumb-item text-dark">{{ $wallet->type_text }} - N°{{ $wallet->number_account }}</li>
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
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            &nbsp;
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Progress-->
                        <div class="d-flex flex-column w-200px w-sm-450px mt-3">
                            <div class="d-flex flex-row align-items-center justify-content-between mb-2 p-5 border border-{{ $wallet->balance_actual <= 0 ? 'danger' : 'success' }} rounded-2">
                                <div class="fw-bolder fs-2">Solde</div>
                                <div class="text-{{ $wallet->balance_actual <= 0 ? 'danger' : 'success' }} fs-3">{{ $wallet->balance_actual_format }}</div>
                            </div>
                            <div class="d-flex flex-row align-items-center justify-content-between mb-2 p-5 border rounded-2">
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
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#transactions"><i class="fa-solid fa-exchange me-2"></i> Transactions</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#infos"><i class="fa-solid fa-info-circle me-2"></i> Informations</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                @if($wallet->epargne->plan->info_retrait->retrait_type->transfer)
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#transfers"><i class="fa-solid fa-exchange me-2"></i> Virements</a>
                    </li>
                @endif

                @if($wallet->epargne->plan->info_retrait->retrait_type->money || $wallet->epargne->plan->info_retrait->retrait_type->card)
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#withdraw"><i class="fa-solid fa-money-bill-transfer me-2"></i> Retrait bancaire</a>
                    </li>
                @endif

                @if($wallet->epargne->plan->info_versement->depot_type->money || $wallet->epargne->plan->info_versement->depot_type->card || $wallet->epargne->plan->info_versement->depot_type->check)
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#deposit"><i class="fa-solid fa-money-bill-transfer me-2"></i> Dépot bancaire</a>
                    </li>
                @endif

                <!--end::Nav item-->
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="transactions" role="tabpanel">
            <x-base.underline
                title="Transaction au {{ now()->format('d/m/Y') }}"
                class="w-650px" />
            <div class="separator border-gray-300 my-5"></div>
            <div
                id="kt_docs_search_handler_basic"

                data-kt-search-keypress="true"
                data-kt-search-min-length="2"
                data-kt-search-enter="true"
                data-kt-search-layout="inline">
                <div class="w-50" data-kt-search-element="suggestions">

                    @foreach($wallet->transactions as $transaction)
                        <div class="mb-5">
                            <a class="d-flex flex-row h-50px p-5 justify-content-between align-items-center rounded bg-white mb-0" data-bs-toggle="collapse" href="#content">
                                <div class="d-flex flex-row align-items-center text-black">
                                    {!! $transaction->getTypeSymbolAttribute() !!}
                                    <div class="d-flex flex-column">
                                        {{ $transaction->designation }}<br>
                                        <div class="text-muted">
                                            {{ $transaction->confirmed ? $transaction->confirmed_at->format('d/m/Y') : ($transaction->differed ? $transaction->differed_at->format('d/m/Y') : $transaction->updated_at->format("d/m/Y")) }}
                                        </div>
                                    </div>
                                </div>
                                @if($transaction->amount < 0)
                                    <span class="text-danger fw-bolder">{{ $transaction->amount_format }}</span>
                                @else
                                    <span class="text-success fw-bolder">+ {{ $transaction->amount_format }}</span>
                                @endif
                            </a>
                            <div class="collapse" id="content">
                                <div class="card card-body">
                                    <div class="ps-5 text-muted mb-5">{{ $transaction->type_text }}</div>
                                    <div class="mb-5">
                                        <x-base.underline
                                            title="Détails de l'opération"
                                            class="mb-2"
                                            size-text="fs-3"
                                            size="3"
                                            color="{{ $transaction->type_color }}" />
                                        <div class="d-flex flex-row justify-content-around">
                                            <div>Transaction effectuée le: {{ $transaction->updated_at->format("d/m/Y") }}</div>
                                            <div>Comptabilisé à la date du: {{ $transaction->confirmed ? $transaction->confirmed_at->format("d/m/Y") : ($transaction->differed ? $transaction->differed_at->format("d/m/Y") : $transaction->updated_at->format("d/m/Y")) }}</div>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <x-base.underline
                                            title="Libellé complet"
                                            class="mb-2"
                                            size-text="fs-3"
                                            size="3"
                                            color="{{ $transaction->type_color }}" />
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold">{{ $transaction->designation }}</div>
                                            <div>{{ $transaction->description }}</div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-lg btn-circle btn-success btnAcceptTransaction me-2" data-transaction="{{ $transaction->id }}"><i class="fa-solid fa-check-circle me-2"></i> Accepter</button>
                                        <button class="btn btn-lg btn-circle btn-danger btnRejectTransaction me-2" data-transaction="{{ $transaction->id }}"><i class="fa-solid fa-xmark-circle me-2"></i> Refuser</button>
                                        @if($transaction->type == 'payment')
                                            <button class="btn btn-lg btn-circle btn-info btnOppositPayment me-2" data-transaction="{{ $transaction->id }}"><i class="fa-solid fa-ban me-2"></i> Opposition</button>
                                        @endif
                                        @if($transaction->type == 'frais')
                                            <button class="btn btn-lg btn-circle btn-info btnRemb me-2" data-transaction="{{ $transaction->id }}"><i class="fa-solid fa-exchange me-2"></i> Remboursement</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div data-kt-search-element="results" class="w-50 d-none">
                    ...
                </div>
                <div data-kt-search-element="empty" class="w-50 text-center d-none">
                    <div class="fw-semibold py-0 mb-10">
                        <div class="text-gray-600 fs-3 mb-2">Nous sommes désolés, il n'y a aucun résultat correspondant à votre recherche.</div>
                        <div class="text-gray-400 fs-6">Veuillez vérifier l'orthographe des mots saisis ou complétez-les par un nouveau mot clé.</div>
                    </div>
                    <div class="text-center px-4">
                        <img class="mw-100 mh-200px" alt="image" src="/assets/media/illustrations/sigma-1/2.png">
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="infos" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="fw-bolder fs-1">Information sur le {{ $wallet->name_account_generic }}</div>
                            <div class="separator separator-dashed my-5"></div>
                            <div class="row align-items-center">
                                <div class="col-md-2 col-sm-4">
                                    <div class="d-flex flex-row p-2 border border-dashed border-gray-400 h-100px align-items-center">
                                        <div class="symbol symbol-50px me-3">
                                            <div class="symbol-label"><i class="fa-solid fa-percentage fs-2"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h3 class="fw-bolder">Intêret</h3>
                                            <div class="fs-2">{{ $wallet->epargne->plan->profit_percent_format }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <div class="d-flex flex-row p-2 border border-dashed border-gray-400 h-100px align-items-center">
                                        <div class="symbol symbol-50px me-3">
                                            <div class="symbol-label"><i class="fa-solid fa-unlock fs-2"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h3 class="fw-bolder">Déblocage des fond</h3>
                                            <div class="fs-2">
                                                @if($wallet->epargne->plan->lock_days == 0)
                                                    <span class="text-success">Disponible</span>
                                                @else
                                                    @if(now()->startOfDay() <= $wallet->epargne->unlocked_at->startOfDay())
                                                        <div class="text-warning">{{ now()->diffForHumans($wallet->epargne->unlocked_at) }}</div>
                                                    @else
                                                        <span class="text-success">Disponible</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <div class="d-flex flex-row p-2 border border-dashed border-gray-400 h-100px align-items-center">
                                        <div class="symbol symbol-50px me-3">
                                            <div class="symbol-label"><i class="fa-solid fa-calendar fs-2"></i> </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h3 class="fw-bolder">Prochain calcul des intêrets</h3>
                                            <div class="fs-2">
                                                <span class="text-warning">{{ $wallet->epargne->next_profit->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 justify-content-end">
                                    @if($wallet->epargne->plan->limit_amount == 0 || $wallet->epargne->plan->limit_amount == 999999999)
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
                                                <span class="fw-bold fs-6">{{ $wallet->epargne->getSoldeWalletForLimit('percent_format') }}</span>
                                            </div>
                                            <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                <div class="bg-{{ $wallet->epargne->getSoldeWalletForLimit('color') }} rounded h-5px" role="progressbar" style="width: {{ $wallet->epargne->getSoldeWalletForLimit('percent') }}%;" aria-valuenow="{{ $wallet->epargne->getSoldeWalletForLimit('percent') }}" aria-valuemin="0" aria-valuemax="100"></div>
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
            <div class="card ">
                <div class="card-header card-header-stretch">
                    <h3 class="card-title">Gestion des virements bancaires</h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#virements"><i class="fa-solid fa-exchange me-2"></i> Virements</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#beneficiaires"><i class="fa-solid fa-users me-2"></i> Bénéficiaires</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="virements" role="tabpanel">
                            <div class="d-flex flex-row justify-content-between">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                                    </svg>
                                                </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-transfers-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher un virements" />
                                </div>
                                <!--end::Search-->
                                <div class="d-flex flex-stack">
                                    <div class="w-100 mw-150px me-3">
                                        <!--begin::Select2-->
                                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Type de virement" data-kt-transfer-filter="type">
                                            <option></option>
                                            <option value="all">Tous</option>
                                            <option value="immediat">Immédiat</option>
                                            <option value="differed">Différé</option>
                                            <option value="permanant">Permanent</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                    <div class="w-100 mw-150px me-3">
                                        <!--begin::Select2-->
                                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status du virement" data-kt-transfer-filter="status">
                                            <option></option>
                                            <option value="all">Tous</option>
                                            <option value="paid">Payer</option>
                                            <option value="pending">En attente</option>
                                            <option value="in_transit">En cours d'execution</option>
                                            <option value="canceled">Annulé</option>
                                            <option value="failed">Rejeté</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                    <!--begin::Add product-->
                                    <a href="#add_virement" class="btn btn-primary" data-bs-toggle="modal">Nouveau virement</a>
                                    <!--end::Add product-->
                                </div>
                            </div>
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="liste_transfers">
                                <!--begin::Table head-->
                                <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="">Description</th>
                                    <th class="text-end">Montant</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Etat</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                <!--begin::Table row-->
                                @foreach($wallet->transfers()->orderBy('transfer_date', 'desc')->get() as $transfer)
                                    <tr>
                                        <td>
                                            {{ \App\Helper\CustomerTransferHelper::getNameBeneficiaire($transfer->beneficiaire) }}
                                        </td>
                                        <td class="text-end">{{ eur($transfer->amount) }}</td>
                                        <td class="text-center" data-order="{{ $transfer->type }}">
                                            {{ \App\Helper\CustomerTransferHelper::getTypeTransfer($transfer->type) }}
                                        </td>
                                        <td class="text-center" data-order="{{ $transfer->status }}">
                                            {!! $transfer->status_label !!}
                                        </td>
                                        <td class="text-end">

                                            @if($transfer->status == 'pending')

                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button class="btn btn-xs btn-bank btn-icon btnShowTransfer" data-bs-toggle="tooltip" title="Voir le virement" data-transfer="{{ $transfer->uuid }}"><i class="fa-solid fa-eye text-white"></i> </button>
                                                    <x-base.button
                                                        class="btn-xs btn-success btn-icon btnAcceptTransfer"
                                                        :datas="[['name' => 'transfer', 'value' => $transfer->uuid]]"
                                                        text='<i class="fa-solid fa-check"></i>'
                                                        tooltip="Accepter le virement" />

                                                    <x-base.button
                                                        class="btn-xs btn-danger btn-icon btnDeclineTransfer"
                                                        :datas="[['name' => 'transfer', 'value' => $transfer->uuid]]"
                                                        text='<i class="fa-solid fa-times"></i>'
                                                        tooltip="Refuser le virement" />
                                                </div>
                                            @else
                                                <button class="btn btn-xs btn-bank btn-icon btnShowTransfer" data-bs-toggle="tooltip" title="Voir le virement" data-transfer="{{ $transfer->uuid }}"><i class="fa-solid fa-eye text-white"></i> </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                @endforeach
                                <!--end::Table row-->
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>

                        <div class="tab-pane fade" id="beneficiaires" role="tabpanel">
                            <div class="d-flex flex-row justify-content-between">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                                    </svg>
                                                </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-beneficiaire-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher un bénéficiaire" />
                                </div>
                                <!--end::Search-->
                                <div class="d-flex flex-stack">
                                    <div class="w-100 mw-150px me-3">
                                        <!--begin::Select2-->
                                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Type de bénéficiaire" data-kt-beneficiaire-filter="type">
                                            <option></option>
                                            <option value="all">Tous</option>
                                            <option value="Particulier">Particulier</option>
                                            <option value="Professionnel">Professionnel</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                    <!--begin::Add product-->
                                    <a href="#add_beneficiaire" class="btn btn-primary" data-bs-toggle="modal">Nouveau bénéficiaire</a>
                                    <!--end::Add product-->
                                </div>
                            </div>
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="liste_beneficiaires">
                                <!--begin::Table head-->
                                <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="">Type</th>
                                    <th class="">Nom / Raison Social</th>
                                    <th class="">Domiciliation bancaire</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                <!--begin::Table row-->
                                @foreach($wallet->customer->beneficiaires as $beneficiaire)
                                    <tr>
                                        <td data-order="{{ $beneficiaire->type }}">
                                            @if($beneficiaire->type == 'retail')
                                                Particulier
                                            @else
                                                Professionnel
                                            @endif
                                        </td>
                                        <td>
                                            {{ \App\Helper\CustomerTransferHelper::getNameBeneficiaire($beneficiaire) }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex flex-row">
                                                    <img src="{{ $beneficiaire->bank->logo }}" height="16" class="img-responsive me-5">
                                                    <span class="fs-8">{{ $beneficiaire->bank->name }}</span>
                                                </div>
                                                <div class="">{{ $beneficiaire->iban }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-circle btn-outline btn-outline-bank" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="30px, 30px"><i class="fa-solid fa-pencil me-3"></i> Actions</button>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Actions</div>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu separator-->
                                                <div class="separator mb-3 opacity-75"></div>
                                                <!--end::Menu separator-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3 btnEditBeneficiaire" data-beneficiaire="{{ $beneficiaire->id }}" data-wallet="{{ $wallet->id }}">
                                                        Editer le bénéficiaire
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="" class="menu-link px-3 btnDeleteBeneficiaire" data-beneficiaire="{{ $beneficiaire->id }}">
                                                        Supprimer le bénéficiaire
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                            </div>
                                            <!--end::Menu-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                @endforeach
                                <!--end::Table row-->
                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="showRib">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white"></h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
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
                            <div class="fs-4 ibanText">{{ $wallet->rib_key}}</div>
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
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formUpdateStateAccount" action="/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="state">
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="status" class="form-label required">Etat</label>
                            <select name="status" class="form-select form-select-solid" data-control="select2">
                                <option value=""></option>
                                @foreach(\App\Models\Customer\CustomerWallet::getState() as $state)
                                    <option value="{{ $state['slug'] }}" {{ $wallet->status == $state['slug'] ? 'selected' : '' }}>{{ $state['name'] }}</option>
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
@endsection

@section("script")
    @include("agent.scripts.customer.wallet.epargne")
@endsection

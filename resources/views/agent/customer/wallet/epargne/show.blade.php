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
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#transfers"><i class="fa-solid fa-exchange me-2"></i> Virements</a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="transactions" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
									<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
								</svg>
							</span>
                            <input type="text" data-kt-transaction-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..." />
                        </div>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <div class="input-group w-250px">
                            <input class="form-control form-control-solid rounded rounded-end-0" placeholder="Ranger de date" id="kt_transaction_flatpickr" />
                            <button class="btn btn-icon btn-light" id="kt_transaction_flatpickr_clear">
                                <span class="svg-icon svg-icon-2">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
										<rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
									</svg>
								</span>
                            </button>
                        </div>
                        <div class="w-100 mw-150px">
                            <!--begin::Select2-->
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Types" data-kt-transaction-filter="types">
                                <option></option>
                                <option value="all">Tous</option>
                                <option value="depot">Dépot</option>
                                <option value="retrait">Retrait</option>
                                <option value="payment">Paiement CB</option>
                                <option value="virement">Virement bancaire</option>
                                <option value="sepa">Prélèvement</option>
                                <option value="frais">Frais Bancaire</option>
                                <option value="souscription">Souscription</option>
                                <option value="autre">Autre</option>
                                <option value="facelia">Crédit Facelia</option>
                            </select>
                            <!--end::Select2-->
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_transaction_table">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">Date</th>
                            <th class="d-none"></th>
                            <th class="min-w-175px">Libellé</th>
                            <th class="text-end">Montant</th>
                            <th class="text-end"></th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        @foreach($wallet->transactions()->where('confirmed', true)->orderBy('confirmed_at', 'desc')->get() as $transaction)
                            <tr>
                                <td data-order="{{ $transaction->confirmed ? $transaction->confirmed_at->format('Y-m-d') : $transaction->updated_at->format('Y-m-d') }}">
                                    {{ $transaction->confirmed ? $transaction->confirmed_at->format('Y-m-d') : $transaction->updated_at->format('Y-m-d') }}
                                </td>
                                <td class="d-none" data-order="{{ $transaction->type }}">{{ $transaction->type }}</td>
                                <td>
                                    <div class="d-flex flex-row align-items-center">
                                        {!! $transaction->type_symbol !!}
                                        <div class="d-flex flex-column">
                                            {{ $transaction->description }}
                                            <div class="text-muted">{{ $transaction->designation }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    @if($transaction->amount < 0)
                                        <span class="text-danger">{{ $transaction->amount_format }}</span>
                                    @else
                                        <div class="text-success fw-semibold">+{{ $transaction->amount_format }}</div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($transaction->type == 'frais' || $transaction->type == 'souscription')
                                        <button class="btn btn-xs btn-danger btn-icon btnRemb" data-transaction="{{ $transaction->uuid }}" data-bs-toggle="tooltip" title="Rembourser"><i class="fa-solid fa-ban"></i> </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
                            <div class="row">
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
                                                    <span class="text-warning">{{ now()->diffForHumans(now()->addDays($wallet->epargne->plan->lock_days)) }}</span>
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
                                    <div class="d-flex align-items-end w-200px w-sm-300px flex-column mt-3">
                                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                            <span class="fw-semibold fs-6 text-gray-400">Profile Compleation</span>
                                            <span class="fw-bold fs-6">50%</span>
                                        </div>
                                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                                            <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
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
    <div class="modal fade" tabindex="-1" id="add_virement">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Nouveau virement depuis ce compte</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formAddVirement" action="/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}/transfers" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="customer_beneficiaire_id" class="form-label required">Bénéficiaire</label>
                            <select class="form-select form-select-solid" id="customer_beneficiaire_id" name="customer_beneficiaire_id" data-control="select2" data-dropdown-parent="#add_virement" data-placeholder="Bénéficiaire" data-allow-clear="true">
                                <option></option>
                                @foreach($wallet->customer->beneficiaires as $beneficiaire)
                                    <option value="{{ $beneficiaire->id }}">{{ \App\Helper\CustomerTransferHelper::getNameBeneficiaire($beneficiaire) }} @if($beneficiaire->titulaire == true) (Compte Personnel) @endif </option>
                                @endforeach
                            </select>
                        </div>

                        <x-form.input
                            name="amount"
                            type="text"
                            label="Montant à envoyer"
                            required="true"
                            text="Montant du compte: {{ eur($wallet->balance_actual) }}" />

                        <x-form.input
                            name="reference"
                            type="text"
                            label="Référence" />

                        <x-form.input
                            name="reason"
                            type="text"
                            label="Description" />

                        <div class="mb-10">
                            <label for="type" class="form-label">Type de Virement</label>
                            <select class="form-select form-select-solid" id="type" name="type" data-control="select2" data-dropdown-parent="#add_virement" data-placeholder="Type de Virement" data-allow-clear="true" onchange="selectedTypeVirement(this)">
                                <option></option>
                                <option value="immediat" selected>Immédiat</option>
                                <option value="differed">Différé</option>
                                <option value="permanent">Permanent</option>
                            </select>
                        </div>

                        <div id="immediat">
                            <div class="mb-5">
                                <input type="radio" class="btn-check" name="access" value="classic" checked="checked"  id="kt_radio_buttons_2_option_1"/>
                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex flex-row justify-content-between align-items-center mb-5" for="kt_radio_buttons_2_option_1">
                                    <i class="fa-solid fa-arrows-left-right-to-line fs-2tx me-4"></i>
                                    <span class="d-flex flex-column fw-semibold text-start">
                                        <span class="text-dark fw-bold d-block fs-3">Virement Classique</span>
                                        <span class="text-muted fw-semibold fs-6">
                                            Le virement classique SEPA est exécuté <strong>dans un délai d’un jour ouvré</strong>.
                                        </span>
                                    </span>
                                    <span class="text-end text-success">
                                        Gratuit
                                    </span>
                                </label>
                            </div>
                            <div class="mb-5">
                                <input type="radio" class="btn-check" name="access" value="express" id="kt_radio_buttons_2_option_2"/>
                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex flex-row justify-content-between align-items-center mb-5" for="kt_radio_buttons_2_option_2">
                                    <i class="fa-solid fa-bolt-lightning fs-2tx me-4"></i>
                                    <span class="d-flex flex-column fw-semibold text-start">
                                        <span class="text-dark fw-bold d-block fs-3">Virement Instantané</span>
                                        <span class="text-muted fw-semibold fs-6">
                                            Le virement instantané est exécuté <strong>dans un délai maximum de 20 secondes</strong>.
                                        </span>
                                    </span>
                                    <span class="text-end text-danger">
                                        0,80 €
                                    </span>
                                </label>
                            </div>

                        </div>
                        <div id="differed" class="d-none">
                            <x-form.input-date
                                name="transfer_date"
                                type="text"
                                label="Date du virement" />
                        </div>
                        <div id="permanent" class="d-none">
                            <x-form.input-date
                                name="permanent_date"
                                type="text"
                                label="Date du virement permanent" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="add_beneficiaire">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Nouveau bénéficiaire</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formAddBeneficiaire" action="/api/customer/{{ $wallet->customer->id }}/beneficiaire" method="POST">
                    <div class="modal-body">
                        <div class="mb-10">
                            <h3 class="mb-3">Type de bénéficiaire</h3>
                            <div class="d-flex flex-row">
                                <x-form.radio
                                    name="type"
                                    value="retail"
                                    for="type"
                                    label="Particulier" />

                                <x-form.radio
                                    name="type"
                                    value="corporate"
                                    for="type"
                                    label="Entreprise" />
                            </div>
                        </div>
                        <div id="corporateField">
                            <x-form.input
                                name="company"
                                type="text"
                                label="Entreprise" />
                        </div>
                        <div id="retailField">
                            <div class="mb-10">
                                <h3 class="mb-3">Civilité</h3>
                                <div class="d-flex flex-row">
                                    <x-form.radio
                                        name="civility"
                                        value="M"
                                        for="type"
                                        label="Monsieur"
                                        checked="false" />

                                    <x-form.radio
                                        name="civility"
                                        value="MME"
                                        for="type"
                                        label="Madame"
                                        checked="false" />

                                    <x-form.radio
                                        name="civility"
                                        value="MME"
                                        for="type"
                                        label="Mademoiselle"
                                        checked="false" />
                                </div>
                            </div>
                            <div class="d-flex flex-row">
                                <x-form.input
                                    name="firstname"
                                    type="text"
                                    label="Nom"
                                    class="me-3" />

                                <x-form.input
                                    name="lastname"
                                    type="text"
                                    label="Prénom" />
                            </div>
                        </div>
                        <div class="separator my-10"></div>
                        <h3 class="fw-bolder text-bank">Information bancaire</h3>
                        <div class="mb-10">
                            <label for="bank_id" class="form-label">Banque</label>
                            <select name="bank_id" class="form-select form-select-solid" data-dropdown-parent="#add_beneficiaire" data-placeholder="Selectionner une banque" id="bank_id" onchange="checkBankInfo(this)">
                                <option value=""></option>
                                @foreach(\App\Models\Core\Bank::all() as $bank)
                                    <option value="{{ $bank->id }}" data-bank-logo="{{ $bank->logo }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="bankname">
                        <x-form.input
                            name="bic"
                            type="text"
                            label="BIC/SWIFT" />

                        <x-form.input
                            name="iban"
                            type="text"
                            label="IBAN" />

                        <x-form.checkbox
                            name="titulaire"
                            label="Ce compte appartient au client"
                            value="true" />


                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="show_transfer" class="bg-white"
         data-kt-drawer="true"
         data-kt-drawer-activate="true"
         data-kt-drawer-toggle="#kt_drawer_example_advanced_button"
         data-kt-drawer-close="#kt_drawer_example_advanced_close"
         data-kt-drawer-name="docs"
         data-kt-drawer-overlay="true"
         data-kt-drawer-width="{default:'300px', 'md': '500px'}"
         data-kt-drawer-direction="end">
        <!--begin::Card-->
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header bg-bank pe-5">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bold text-white text-hover-primary me-1 lh-1">Ordre de Virement N°48856965</a>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_example_advanced_close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-2">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
								<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
							</svg>
						</span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
                <div class="d-flex flex-center fs-2 mb-5" data-content="transfer_status">
                    <i class="fa-solid fa-circle-dot fs-1 text-success me-3"></i> Votre ordre de virement à été traité
                </div>

                <div class="d-flex flex-column bg-gray-300 rounded-2 mb-5">
                    <div class="d-flex flex-row bg-white rounded-2 border">
                        <div class="bg-success w-5px">&nbsp;</div>
                        <div class="d-flex flex-column p-5">
                            <div class="fw-bolder">Compte</div>
                            <div class="" data-content="emet_transfer">FR76 3000 3017 4200 0501 7057 192</div>
                        </div>
                    </div>
                    <div class="d-flex flex-center p-10 boxAmount">
                        <div class="fw-bolder fs-2" data-content="amount">900,00 €</div>
                    </div>
                    <div class="d-flex flex-row bg-white rounded-2 border">
                        <div class="bg-primary w-5px">&nbsp;</div>
                        <div class="d-flex flex-column p-5">
                            <div class="fw-bolder">Beneficiaire</div>
                            <div class="" data-content="receip_transfer">FR76 3000 3017 4200 0501 7057 192</div>
                        </div>
                    </div>
                </div>

                <table class="table table-row-bordered table-row-gray-600 gy-5">
                    <tbody>
                    <tr>
                        <td class="fw-bolder">Type de virement</td>
                        <td class="text-end" data-content="transfer_type">Virement Immédiat</td>
                    </tr>
                    <tr>
                        <td class="fw-bolder">Date de débit</td>
                        <td class="text-end" data-content="transfer_date">12/11/2022</td>
                    </tr>
                    <tr>
                        <td class="fw-bolder">Référence du virement</td>
                        <td class="text-end" data-content="transfer_reference">FRT58965211FRG</td>
                    </tr>
                    </tbody>
                </table>

                <div class="d-flex flex-center">
                    <button class="btn btn-circle btn-lg btn-success btnAcceptTransfer" data-transfer="">Accepter le virement</button>
                    <button class="btn btn-circle btn-lg btn-danger btnDeclineTransfer" data-transfer="">Refuser le virement</button>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.wallet.epargne")
@endsection

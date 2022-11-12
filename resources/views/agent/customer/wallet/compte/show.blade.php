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
                                <div class="menu-item px-3">
                                    <a href="#requestOverdraft" class="menu-link px-3 requestOverdraft" data-bs-toggle="modal"><span class="iconify fs-3 me-2" data-icon="fa6-solid:money-bill-trend-up"></span> Demander un découvert bancaire</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Title-->
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-arrow-up fs-1 text-success me-2"></i>
                                        <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="{{ \App\Helper\CustomerHelper::getAmountAllDeposit($wallet->customer) }}" data-kt-countup-suffix="€" data-kt-initialized="1">{{ \App\Helper\CustomerHelper::getAmountAllDeposit($wallet->customer) }}</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Dépots</div>
                                    <!--end::Label-->
                                </div>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-arrow-down fs-1 text-danger me-2"></i>
                                        <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="{{ \App\Helper\CustomerHelper::getAmountAllWithdraw($wallet->customer) }}" data-kt-countup-suffix="€" data-kt-initialized="1">{{ \App\Helper\CustomerHelper::getAmountAllWithdraw($wallet->customer) }}</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Retraits</div>
                                    <!--end::Label-->
                                </div>
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Progress-->
                        <div class="d-flex flex-column w-200px w-sm-450px mt-3">
                            <div class="d-flex flex-row align-items-center justify-content-between mb-2 p-5 border border-{{ $wallet->balance_actual <= 0 ? 'danger' : 'success' }} rounded-2">
                                <div class="fw-bolder fs-2">Solde</div>
                                <div class="text-{{ $wallet->balance_actual <= 0 ? 'danger' : 'success' }} fs-3">{{ $wallet->balance_actual_format }}</div>
                            </div>
                            <div class="d-flex flex-row align-items-center justify-content-between mb-2 p-5 border border-gray-500 rounded-2">
                                <div class="fw-bolder fs-2">Découvert Bancaire</div>
                                <div class="fs-3">{{ eur($wallet->balance_decouvert) }}</div>
                            </div>
                            <div class="d-flex flex-row align-items-center justify-content-between mb-2 p-5 border border-gray-500 rounded-2">
                                <div class="fw-bolder fs-2">A Venir</div>
                                <div class="fs-3">{{ eur($wallet->balance_coming) }}</div>
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
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#sepas"><i class="fa-solid fa-bank me-2"></i> Prélèvements</a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#cards"><i class="fa-solid fa-credit-card me-2"></i> Cartes bancaires</a>
                </li>
                <!--end::Nav item-->
                @if($wallet->customer->setting->check)
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#checks"><i class="fa-solid fa-money-check-dollar me-2"></i> Chèques</a>
                </li>
                @endif
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="transactions" role="tabpanel">
            <div class="card shadow-sm mb-10">
                <div class="card-header">
                    <h3 class="card-title">A venir</h3>
                    <div class="card-toolbar">
                        <!--<button type="button" class="btn btn-sm btn-light">
                            Action
                        </button>-->
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-row-bordered gy-5 gs-7" id="table_coming">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-600">
                                <th>Date de paiement</th>
                                <th>Libelle</th>
                                <th class="text-end">Montant</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wallet->transactions()->where('confirmed', false)->get() as $transaction)
                                <tr class="align-middle">
                                    <td>{{ $transaction->updated_at->format('d/m/Y') }}</td>
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
                                        {{ $transaction->amount_format }}
                                    </td>
                                    <td class="text-end">
                                        @if($transaction->type == 'virement' || $transaction->type == 'sepa')
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-xs btn-success btn-icon btnAcceptTransaction" data-transaction="{{ $transaction->id }}" data-bs-toggle="tooltip" title="Accepter"><i class="fa-solid fa-check"></i> </button>
                                                <button class="btn btn-xs btn-danger btn-icon btnRejectTransaction" data-transaction="{{ $transaction->id }}" data-bs-toggle="tooltip" title="Refuser"><i class="fa-solid fa-xmark"></i> </button>
                                            </div>
                                        @endif
                                        @if($transaction->type == 'payment')
                                            <button class="btn btn-xs btn-danger btn-icon me-2 btnOppositPayment" data-transaction="{{ $transaction->uuid }}" data-bs-toggle="tooltip" title="Opposition"><i class="fa-solid fa-ban"></i> </button>
                                        @endif
                                        @if($transaction->opposit()->count() == 1)
                                            <i class="fa-solid fa-exclamation-triangle fs-2 text-warning" data-bs-toggle="tooltip" title="Opposition"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
                                    <td data-order="{{ $transaction->confirmed_at->format('Y-m-d') }}">{{ $transaction->confirmed_at->format("d/m/Y") }}</td>
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
                                        @if($transaction->type == 'frais')
                                            <button class="btn btn-xs btn-danger btn-icon btnRemb" data-transation="{{ $transaction->id }}" data-bs-toggle="tooltip" title="Rembourser"><i class="fa-solid fa-ban"></i> </button>
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
                <div class="col-md-8 col-sm-12 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Information sur le compte {{ $wallet->number_account }}</h3>
                            <div class="card-toolbar">
                                <!--<button type="button" class="btn btn-sm btn-light">
                                    Action
                                </button>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart_summary" class="mb-10 h-350px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card shadow-sm mb-10">
                        <div class="card-body">
                            <h3 class="fw-bolder text-center mb-3">Paiements</h3>
                            <div class="d-flex flex-row justify-content-between bg-gray-200 p-5 rounded">
                                <div class="d-flex flex-column flex-center">
                                    <i class="fa-solid fa-money-check-dollar fa-3x"></i>
                                    <span class="fw-bolder fs-3">Chèques</span>
                                    <span class="fw-bolder fs-2">{{ $wallet->transactions()->where('designation', 'LIKE', '%Chèque%')->count() }}</span>
                                    <span class="fs-6">{{ eur($wallet->transactions()->where('designation', 'LIKE', '%Chèque%')->sum('amount')) }}</span>
                                    <div class="text-muted">en moyenne</div>
                                </div>
                                <div class="d-flex flex-column flex-center">
                                    <i class="fa-solid fa-credit-card fa-3x"></i>
                                    <span class="fw-bolder fs-3">Achat CB</span>
                                    <span class="fw-bolder fs-2">{{ \App\Models\Customer\CustomerTransaction::where('customer_wallet_id', $wallet->id)->where('type', 'payment')->get()->count() }}</span>
                                    <span class="fs-6">{{ eur(\App\Models\Customer\CustomerTransaction::where('customer_wallet_id', $wallet->id)->where('type', 'payment')->avg('amount')) }}</span>
                                    <div class="text-muted">en moyenne</div>
                                </div>
                                <div class="d-flex flex-column flex-center">
                                    <i class="fa-solid fa-money-bill-transfer fa-3x"></i>
                                    <span class="fw-bolder fs-3">Prélèvements</span>
                                    <span class="fw-bolder fs-2">{{ \App\Models\Customer\CustomerTransaction::where('customer_wallet_id', $wallet->id)->where('type', 'sepa')->get()->count() }}</span>
                                    <span class="fs-6">{{ eur(\App\Models\Customer\CustomerTransaction::where('customer_wallet_id', $wallet->id)->where('type', 'sepa')->avg('amount')) }}</span>
                                    <div class="text-muted">en moyenne</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-10">
                        <div class="card-body">
                            <h3 class="fw-bolder text-center mb-3">Retraits</h3>
                            <div class="d-flex flex-row justify-content-between bg-gray-200 p-5 rounded">
                                <div class="d-flex flex-column flex-center">
                                    <i class="fa-solid fa-building fa-3x"></i>
                                    <span class="fw-bolder fs-3">Guichet</span>
                                    <span class="fw-bolder fs-2">0</span>
                                    <span class="fs-6">0,00 €</span>
                                    <div class="text-muted">en moyenne</div>
                                </div>
                                <div class="d-flex flex-column flex-center">
                                    <i class="fa-solid fa-money-bill fa-3x"></i>
                                    <span class="fw-bolder fs-3">Retrait DAB</span>
                                    <span class="fw-bolder fs-2">0</span>
                                    <span class="fs-6">0,00 €</span>
                                    <div class="text-muted">en moyenne</div>
                                </div>
                                <div class="d-flex flex-column flex-center">
                                    <i class="fa-solid fa-money-bill fa-3x"></i>
                                    <span class="fw-bolder fs-3">Retrait DABV</span>
                                    <span class="fw-bolder fs-2">0</span>
                                    <span class="fs-6">0,00 €</span>
                                    <div class="text-muted">en moyenne</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-column flex-center bg-light-success p-5 rounded text-center mb-3">
                                    <span class="fw-bolder fs-2">{{ eur($wallet->transactions()->where('amount', '>=', 0)->where('confirmed', true)->sum('amount')) }}</span>
                                    <div class="fs-6">Recette Moyenne</div>
                                </div>
                                <div class="d-flex flex-column flex-center bg-light-danger p-5 rounded text-center mb-3">
                                    <span class="fw-bolder fs-2">{{ eur($wallet->transactions()->where('amount', '<=', 0)->where('confirmed', true)->sum('amount')) }}</span>
                                    <div class="fs-6">Débit Moyen</div>
                                </div>
                                <div class="d-flex flex-column flex-center bg-light-info p-5 rounded text-center mb-3">
                                    <span class="fw-bolder fs-2">{{ eur($wallet->balance_decouvert) }}</span>
                                    <div class="fs-6">Découvert Autorisé</div>
                                </div>
                            </div>
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
    <div class="modal fade" tabindex="-1" id="requestOverdraft">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Demande de découvert bancaire</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formSubscribeOverdraft" action="/api/customer/{{ $wallet->customer->id }}/subscribe/overdraft" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="wallet_id" value="{{ $wallet->id }}">
                        <div id="overdraft"></div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-end">
                            <x-form.button />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.wallet.compte")
@endsection

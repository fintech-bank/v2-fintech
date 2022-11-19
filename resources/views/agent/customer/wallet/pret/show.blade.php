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
                            @if($wallet->loan->payment->solde_remaining <= 0)
                                @if($wallet->loan->first_payment_at->subDays(3)->startOfDay() <= now()->startOfDay())
                                    <div class="text-warning"><i class="fa-solid fa-exclamation-triangle text-warning me-2"></i> Compte de paiement débiteur, la mensualité va être rejetée {{ $wallet->loan->first_payment_at->diffForHumans() }}</div>
                                @else
                                    <div class="text-success"><i class="fa-solid fa-check text-success me-2"></i> La prochainement mensualité de {{ $wallet->loan->mensuality_format }} sera débité {{ $wallet->loan->first_payment_at->diffForHumans() }}</div>
                                @endif
                            @else
                                <div class="text-success"><i class="fa-solid fa-check text-success me-2"></i> La prochainement mensualité de {{ $wallet->loan->mensuality_format }} sera débité {{ $wallet->loan->first_payment_at->diffForHumans() }}</div>
                            @endif
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
                            <div class="d-flex flex-column border rounded p-2 mb-2 me-2">
                                <div class="fs-4 fw-bolder">Caution Obligatoire</div>
                                <div class="">{{ $wallet->loan->caution_text }}</div>
                            </div>
                            <div class="d-flex flex-column border rounded p-2 mb-2 me-2">
                                <div class="fs-4 fw-bolder">Assurance Obligatoire</div>
                                <div class="">{{ $wallet->loan->insurance_text }}</div>
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
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#cautions"><i class="fa-solid fa-users-between-lines me-2"></i> Cautions</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#actions"><i class="fa-solid fa-pen me-2"></i> Action</a>
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="infos" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped table-bordered table-sm gx-3 gy-3">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Référence du pret</td>
                                <td>{{ $wallet->loan->reference }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Type de pret</td>
                                <td>{{ $wallet->loan->plan->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Emprunteur</td>
                                <td>{{ $wallet->loan->customer->info->full_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Identifiant Client</td>
                                <td>{{ $wallet->loan->customer->user->identifiant }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Etat du pret</td>
                                <td>{!! $wallet->loan->status_label !!}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Date du premier Paiement</td>
                                <td>{{ \Carbon\Carbon::create($wallet->loan->created_at->year, $wallet->loan->created_at->addMonth()->month, $wallet->loan->prlv_day)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Date de fin du prêt</td>
                                <td>{{ $wallet->loan->first_payment_at->addMonths($wallet->loan->duration)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Capital demandée</td>
                                <td>{{ $wallet->loan->amount_loan_format }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total à payer (Montant + Intêret)</td>
                                <td>{{ $wallet->loan->amount_du_format }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total Payé</td>
                                <td>{{ \App\Scope\CalcLoanTrait::calcRestantDu($wallet->loan) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.wallet.pret")
@endsection

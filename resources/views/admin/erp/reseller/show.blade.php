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
    <div class="row">
        <div class="col-4">
            <div class="card card-flush shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">&nbsp;</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.erp.reseller.edit', $reseller->id) }}" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-edit me-2"></i> Editer
                        </a>
                    </div>
                </div>
                <div class="card-body py-5">
                    <div class="d-flex flex-center mb-20">
                        <div class="symbol symbol-150px symbol-circle">
                            <div class="symbol-label" style="background-image:url({{ $reseller->dab->img }})"></div>
                        </div>
                    </div>
                    <div class="fw-bolder fs-1 underline mb-10">Informations</div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-10">
                        <div class="fw-bolder fs-2 w-75">Etat</div>
                        <select name="state" class="form-control" id="state" onchange="changeState(this)">
                            <option value="1" {{ $reseller->dab->open ? 'selected' : '' }}>Ouvert</option>
                            <option value="0" {{ !$reseller->dab->open ? 'selected' : '' }}>Fermé</option>
                        </select>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-10">
                        <div class="fw-bolder fs-2 w-75">Type</div>
                        <select name="type" class="form-control" id="type" onchange="changeType(this)">
                            @foreach($reseller->dab->tableTypeDabs() as $type)
                            <option value="{{ $type['label'] }}" {{ $reseller->dab->type == $type['label'] ? 'selected' : '' }}>
                                {{ $type['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex flex-row align-items-center mb-5">
                        <div class="symbol symbol-70px symbol-circle">
                            <div class="symbol-label"><i class="fa-solid fa-location-arrow fs-2x"></i> </div>
                        </div>
                        <div class="d-flex flex-column fs-4  ms-5">
                            <div class="fw-bolder">Adresse</div>
                            {{ $reseller->dab->address }}<br>
                            {{ $reseller->dab->postal }} {{ $reseller->dab->city }}
                        </div>
                    </div>
                    <div class="d-flex flex-row align-items-center mb-5">
                        <div class="symbol symbol-70px symbol-circle">
                            <div class="symbol-label"><i class="fa-solid fa-phone fs-2x"></i> </div>
                        </div>
                        <div class="d-flex flex-column fs-4  ms-5">
                            <div class="fw-bolder">Coordonnée</div>
                            <strong>Téléphone:</strong> <a href="tel:{{ $reseller->dab->phone }}">{{ $reseller->dab->phone }}</a><br>
                            <strong>Email:</strong> <a href="mailto:{{ $reseller->user->email }}">{{ $reseller->user->email }}</a><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="row mb-10">
                <div class="col">
                    <div class="card card-flush shadow-sm">
                        <div class="card-body py-5">
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-row align-items-center mb-10">
                                    <i class="fa-solid fa-arrow-up fs-2tx text-danger me-5"></i>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-2">Limite de retrait</div>
                                        <div class="text-muted">En date du {{ now()->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                                <div class="fw-bolder fs-1 text-danger">{{ eur($reseller->calcRemainingOutgoing()) }} / {{ eur($reseller->limit_outgoing) }}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-6 text-black opacity-75 w-100 mt-auto mb-2">
                                    <span>&nbsp;</span>
                                    <span>{{ $reseller->calcRemainingOutgoingPercent() }}%</span>
                                </div>
                                <div class="h-8px mx-3 w-100 bg-grey-300 bg-opacity-50 rounded">
                                    <div class="bg-danger rounded h-8px" role="progressbar" style="width: {{ $reseller->calcRemainingOutgoingPercent() }}%;" aria-valuenow="{{ $reseller->calcRemainingOutgoingPercent() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-flush shadow-sm">
                        <div class="card-body py-5">
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-row align-items-center mb-10">
                                    <i class="fa-solid fa-arrow-down fs-2tx text-success me-5"></i>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-2">Limite de dépot</div>
                                        <div class="text-muted">En date du {{ now()->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                                <div class="fw-bolder fs-1 text-success">{{ eur($reseller->calcRemainingIncoming()) }} / {{ eur($reseller->limit_incoming) }}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-6 text-black opacity-75 w-100 mt-auto mb-2">
                                    <span>&nbsp;</span>
                                    <span>{{ $reseller->calcRemainingIncomingPercent() }}%</span>
                                </div>
                                <div class="h-8px mx-3 w-100 bg-grey-300 bg-opacity-50 rounded">
                                    <div class="bg-success rounded h-8px" role="progressbar" style="width: {{ $reseller->calcRemainingIncomingPercent() }}%;" aria-valuenow="{{ $reseller->calcRemainingIncomingPercent() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-flush shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">&nbsp;</h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#withdraw">Retraits</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#moneys">Dépot</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#invoices">Factures</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body py-5">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="withdraw" role="tabpanel">
                            <div class="d-flex flex-row justify-content-between mb-10">
                                <div class="fw-bolder fs-1">Liste des Retraits</div>
                                <div class="d-flex flex-row-fluid justify-content-end gap-5">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1 mx-2">
                                        <i class="fa-solid fa-search fa-lg position-absolute ms-4"></i>
                                        <input type="text" data-kt-outgoing-filter="search" class="form-control form-control-solid ps-14" placeholder="Rechercher..." />
                                    </div>
                                    <!--end::Search-->
                                    <div class="w-150px">
                                        <!--begin::Select2-->
                                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-outgoing-filter="status">
                                            <option></option>
                                            <option value="all">Tous</option>
                                            <option value="En Attente">En Attente</option>
                                            <option value="Accepter">Accepter</option>
                                            <option value="Refuser">Refuser</option>
                                            <option value="Terminer">Terminer</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_outgoing_table" aria-describedby="Liste des banque">
                                    <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px" scope="col">Référence</th>
                                        <th class="min-w-75px" scope="col">Client</th>
                                        <th class="min-w-75px" scope="col">Montant</th>
                                        <th class="min-w-75px" scope="col">Créer le</th>
                                        <th class="min-w-75px" scope="col">Expire le</th>
                                        <th class="min-w-75px" scope="col">Etat</th>
                                        <th class="min-w-75px" scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    @foreach($reseller->dab->withdraws as $withdraw)
                                        <tr>
                                            <td>{{ $withdraw->reference }}</td>
                                            <td>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="symbol symbol-30px">
                                                        {!! \App\Helper\UserHelper::getAvatar($withdraw->wallet->customer->user->email) !!}
                                                    </div>
                                                    <div class="d-flex flex-column ms-5">
                                                        <div class="fw-bolder">{{ \App\Helper\CustomerHelper::getName($withdraw->wallet->customer) }}</div>
                                                        <div class="text-muted">{{ $withdraw->wallet->customer->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $withdraw->amount_format }}</td>
                                            <td>{{ $withdraw->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($withdraw->created_at->addDays(7) <= now() && $withdraw->status != 'terminated')
                                                    <span class="badge badge-sm badge-danger" data-bs-toggle="tooltip" title="Expiré">{{ $withdraw->created_at->addDays(7)->format('d/m/Y') }}</span>
                                                @else
                                                    <span class="badge badge-sm badge-success">{{ $withdraw->created_at->addDays(7)->format('d/m/Y') }}</span>
                                                @endif
                                            </td>
                                            <td>{!! $withdraw->labeled_status !!}</td>
                                            <td>
                                                @if($withdraw->status == 'pending')
                                                    <button class="btn btn-circle btn-sm btn-primary btn-icon btnSendCode" data-withdraw="{{ $withdraw->id }}" data-action="withdraw" data-bs-toggle="tooltip" title="Renvoyer le code au client"><i class="fa-solid fa-key"></i> </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="moneys" role="tabpanel">
                            <div class="d-flex flex-row justify-content-between mb-10">
                                <div class="fw-bolder fs-1">Liste des Dépots</div>
                                <div class="d-flex flex-row-fluid justify-content-end gap-5">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1 mx-2">
                                        <i class="fa-solid fa-search fa-lg position-absolute ms-4"></i>
                                        <input type="text" data-kt-incoming-filter="search" class="form-control form-control-solid ps-14" placeholder="Rechercher..." />
                                    </div>
                                    <!--end::Search-->
                                    <div class="w-150px">
                                        <!--begin::Select2-->
                                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-incoming-filter="status">
                                            <option></option>
                                            <option value="all">Tous</option>
                                            <option value="En Attente">En Attente</option>
                                            <option value="Accepter">Accepter</option>
                                            <option value="Refuser">Refuser</option>
                                            <option value="Terminer">Terminer</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_incoming_table" aria-describedby="Liste des banque">
                                    <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px" scope="col">Référence</th>
                                        <th class="min-w-75px" scope="col">Client</th>
                                        <th class="min-w-75px" scope="col">Montant</th>
                                        <th class="min-w-75px" scope="col">Créer le</th>
                                        <th class="min-w-75px" scope="col">Expire le</th>
                                        <th class="min-w-75px" scope="col">Etat</th>
                                        <th class="min-w-75px" scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    @foreach($reseller->dab->moneys as $withdraw)
                                        <tr>
                                            <td>{{ $withdraw->reference }}</td>
                                            <td>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="symbol symbol-30px">
                                                        {!! \App\Helper\UserHelper::getAvatar($withdraw->wallet->customer->user->email) !!}
                                                    </div>
                                                    <div class="d-flex flex-column ms-5">
                                                        <div class="fw-bolder">{{ \App\Helper\CustomerHelper::getName($withdraw->wallet->customer) }}</div>
                                                        <div class="text-muted">{{ $withdraw->wallet->customer->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $withdraw->amount_format }}</td>
                                            <td>{{ $withdraw->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($withdraw->created_at->addDays(7) <= now() && $withdraw->status != 'terminated')
                                                    <span class="badge badge-sm badge-danger" data-bs-toggle="tooltip" title="Expiré">{{ $withdraw->created_at->addDays(7)->format('d/m/Y') }}</span>
                                                @else
                                                    <span class="badge badge-sm badge-success">{{ $withdraw->created_at->addDays(7)->format('d/m/Y') }}</span>
                                                @endif
                                            </td>
                                            <td>{!! $withdraw->labeled_status !!}</td>
                                            <td>
                                                @if($withdraw->status == 'pending')
                                                    <button class="btn btn-circle btn-sm btn-primary btn-icon btnSendCode" data-withdraw="{{ $withdraw->id }}" data-action="money" data-bs-toggle="tooltip" title="Renvoyer le code au client"><i class="fa-solid fa-key"></i> </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="invoices" role="tabpanel">
                            <div class="d-flex flex-row justify-content-between mb-10">
                                <div class="fw-bolder fs-1">Liste des Factures</div>
                                <div class="d-flex flex-row-fluid justify-content-end gap-5">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1 mx-2">
                                        <i class="fa-solid fa-search fa-lg position-absolute ms-4"></i>
                                        <input type="text" data-kt-invoice-filter="search" class="form-control form-control-solid ps-14" placeholder="Rechercher..." />
                                    </div>
                                    <!--end::Search-->
                                    <div class="w-150px">
                                        <!--begin::Select2-->
                                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-invoice-filter="status">
                                            <option></option>
                                            <option value="all">Tous</option>
                                            <option value="Brouillon">Brouillon</option>
                                            <option value="Ouvert">Ouvert</option>
                                            <option value="Payer">Payer</option>
                                            <option value="Non Recouvrable">Non Recouvrable</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_invoice_table" aria-describedby="Liste des banque">
                                    <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px" scope="col">Référence</th>
                                        <th class="min-w-75px" scope="col">Date de la facture</th>
                                        <th class="min-w-75px" scope="col">Montant</th>
                                        <th class="min-w-75px" scope="col">Etat</th>
                                        <th class="min-w-75px" scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    @foreach($reseller->invoices as $invoice)
                                        <tr>
                                            <td>{{ $invoice->reference }}</td>
                                            <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $invoice->amount_format }}</td>
                                            <td>{!! $invoice->status_label !!}</td>
                                            <td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("admin.scripts.erp.reseller.show")
@endsection

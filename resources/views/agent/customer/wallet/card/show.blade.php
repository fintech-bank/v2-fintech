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
                <a href="{{ route('agent.customer.show', $card->wallet->customer->id) }}"
                   class="text-muted text-hover-primary">{{ $card->wallet->customer->user->identifiant }} - {{ $card->wallet->customer->info->full_name }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.wallet.show', $card->wallet->number_account) }}"
                   class="text-muted text-hover-primary">{{ $card->wallet->type_text }} - N°{{ $card->wallet->number_account }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Carte Bancaire {{ $card->support->name }} - {{ $card->number_format }}</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>-->
    </div>
@endsection

@section("content")
    <div class="d-flex flex-row border border-{{ $card->getStatus('color') }} justify-content-between rounded rounded-2 bg-gray-300 p-5 mb-10 shadow-lg">
        <div class="d-flex flex-row">
            <div class="symbol symbol-175px symbol-2by3 ribbon ribbon-start ribbon-clip">
                <img src="{{ $card->logo_card }}" alt="">
                <div class="ribbon-label">
                    <i class="fa-solid fa-{{ $card->getStatus('icon') }} text-white me-2"></i> {{ $card->getStatus('text') }}
                    <span class="ribbon-inner bg-{{ $card->getStatus('color') }}"></span>
                </div>
            </div>
            <div class="d-flex flex-column">
                <div class="fw-bolder fs-2">CB {{ $card->support->name }}</div>
                <span class="mb-3">{{ $card->debit_format }}</span>
                <a href="{{ route('agent.customer.wallet.show', $card->wallet->number_account) }}">{{ $card->wallet->name_account_generic }}</a>
                <div class="d-flex flex-row mt-5">
                    @if($card->status == 'active')
                        <button class="btn btn-lg btn-circle btn-outline btn-outline-danger me-3 btnDesactiveCard">Désactiver la carte</button>
                        <button class="btn btn-lg btn-circle btn-danger btnOppositCard">Opposition</button>
                    @else
                        <button class="btn btn-lg btn-circle btn-outline btn-outline-success me-3 btnActiveCard">Activer la carte</button>
                        <button class="btn btn-lg btn-circle btn-danger btnOppositCard">Opposition</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-between align-items-center rounded bg-light p-5 shadow-lg me-3">
            <div class="d-flex flex-column">
                <div class="d-flex flex-row mb-3">
                    <i class="fa-solid fa-{{ $card->support->payment_internet ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->payment_internet ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->payment_internet_text }}
                    </div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <i class="fa-solid fa-{{ $card->support->payment_abroad ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->payment_abroad ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->payment_abroad_text }}
                    </div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <i class="fa-solid fa-{{ $card->support->payment_contact ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->payment_contact ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->payment_contact_text }}
                    </div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <i class="fa-solid fa-{{ $card->support->visa_spec ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->visa_spec ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->visa_spec_text }}
                    </div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <i class="fa-solid fa-{{ $card->support->choice_code ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->choice_code ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->choice_code_text }}
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-between rounded bg-light p-5 w-500px shadow-lg">
            <div class="d-flex flex-column w-250px me-3 ms-auto">
                <div class="d-flex flex-row align-items-center mb-3">
                    <i class="fa-solid fa-{{ $card->support->insurance->insurance_sante ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->insurance->insurance_sante ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->insurance->insurance_sante_text }}
                    </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-3">
                    <i class="fa-solid fa-{{ $card->support->insurance->insurance_accident_travel ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->insurance->insurance_accident_travel ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->insurance->insurance_accident_travel_text }}
                    </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-3">
                    <i class="fa-solid fa-{{ $card->support->insurance->trip_cancellation ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->insurance->trip_cancellation ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->insurance->trip_cancellation_text }}
                    </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-3">
                    <i class="fa-solid fa-{{ $card->support->insurance->civil_liability_abroad ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->insurance->civil_liability_abroad ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->insurance->civil_liability_abroad_text }}
                    </div>
                </div>
            </div>
            <div class="vr"></div>
            <div class="d-flex flex-column w-250px ms-1">
                <div class="d-flex flex-row align-items-center mb-3">
                    <i class="fa-solid fa-{{ $card->support->insurance->cash_breakdown_abroad ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->insurance->cash_breakdown_abroad ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->insurance->cash_breakdown_abroad_text }}
                    </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-3">
                    <i class="fa-solid fa-{{ $card->support->insurance->guarantee_snow ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->insurance->guarantee_snow ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->insurance->guarantee_snow_text }}
                    </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-3">
                    <i class="fa-solid fa-{{ $card->support->insurance->guarantee_loan ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->insurance->guarantee_loan ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->insurance->guarantee_loan_text }}
                    </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-3">
                    <i class="fa-solid fa-{{ $card->support->insurance->guarantee_purchase ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->insurance->guarantee_purchase ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->insurance->guarantee_purchase_text }}
                    </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-3">
                    <i class="fa-solid fa-{{ $card->support->insurance->advantage ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->insurance->advantage ? 'success' : 'danger' }} fs-2 me-3"></i>
                    <div class="d-flex flex-column">
                        {{ $card->support->insurance->advantage_text }}
                    </div>
                </div>
                @if($card->wallet->customer->info->type != 'part')
                    <div class="d-flex flex-row align-items-center mb-3">
                        <i class="fa-solid fa-{{ $card->support->insurance->business_travel ? 'check-circle' : 'xmark-circle' }} text-{{ $card->support->insurance->business_travel ? 'success' : 'danger' }} fs-2 me-3"></i>
                        <div class="d-flex flex-column">
                            {{ $card->support->insurance->business_travel_text }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Carte bancaire {{ $card->number_format }}</h3>
            <div class="card-toolbar">
                <button class="btn btn-sm btn-circle btn-outline btn-outline-primary me-2 btnEditCard" data-card="{{ $card->number }}">Editer la carte</button>
                <button class="btn btn-sm btn-circle btn-outline btn-outline-primary me-2 btnSendCodeCard" data-card="{{ $card->number }}">Renvoyer le code secret</button>
                @if($card->facelia)
                    <button class="btn btn-sm btn-circle btn-outline btn-outline-primary me-2 btnFaceliaCard" data-card="{{ $card->number }}">Liaison Facelia</button>
                @endif
                <button class="btn btn-sm btn-circle btn-outline btn-outline-danger me-2 btnCancelCard" data-card="{{ $card->number }}">Annuler la carte bancaire</button>
            </div>
        </div>
        <div class="card-body">
            <div id="divEditCard" class="">
                <form id="formEditCard" action="/api/customer/{{ $card->wallet->customer->id }}/wallet/{{ $card->wallet->number_account }}/card/{{ $card->id }}" method="POST">
                    <div class="mb-10">
                        <label for="debit" class="form-label">Type de débit</label>
                        <select name="debit" id="debit" class="form-control form-control-solid" data-control="select2">
                            <option value="immediat" {{ $card->debit == 'immediate' ? 'selected' : '' }}>Débit Immédiat</option>
                            <option value="differed" {{ $card->debit == 'differed' ? 'selected' : '' }}>Débit Différé</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 rounded bg-secondary p-5">
                            <x-form.switches
                                name="payment_internet"
                                label="Paiement par internet"
                                value="1"
                                check="{{ $card->payment_internet ? 'checked' : '' }}" />

                            <x-form.switches
                                name="payment_abroad"
                                label="Paiement / retrait à l'étranger"
                                value="1"
                                check="{{ $card->payment_abroad ? 'checked' : '' }}" />

                            <x-form.switches
                                name="payment_contact"
                                label="Paiement sans contact"
                                value="1"
                                check="{{ $card->payment_contact ? 'checked' : '' }}" />
                        </div>
                        <div class="col-6">
                            <x-form.input
                                name="limit_payment"
                                label="Limite de Paiement"
                                value="{{ $card->limit_payment }}"
                                required="true" />
                            <x-form.input
                                name="limit_retrait"
                                label="Limite de Retrait"
                                value="{{ $card->limit_retrait }}"
                                required="true" />
                            @if($card->debit == 'differed')
                                <x-form.input
                                    name="differed_limit"
                                    label="Limite différé"
                                    value="{{ $card->differed_limit }}"
                                    required="true" />
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div id="divSendCodeCard" class="d-none"></div>
            <div id="divFaceliaCard" class="d-none"></div>
            <div id="divCancelCard" class="d-none"></div>
            <div id="divOppositCard" class="d-none"></div>
        </div>
    </div>

@endsection

@section("script")
    @include("agent.scripts.customer.wallet.card")
@endsection

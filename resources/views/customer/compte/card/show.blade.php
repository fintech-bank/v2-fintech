@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="d-flex flex-wrap align-items-center w-75 rounded rounded-2 bg-white p-5 mb-10">
            <div class="d-flex flex-row align-items-center">
                <div class="w-50 me-5">
                    <img src="/storage/card/{{ $card->support->slug }}.png" alt="" class="img-fluid m-0 p-0">
                </div>
                <div class="w-50 align-items-center">
                    <div class="d-flex flex-center align-items-center">
                        <div class="d-flex flex-column align-items-center">
                            <div class="fw-bolder fs-2">CB VISA</div>
                            {{ $card->debit_format }}
                            <a href="{{ route('customer.compte.wallet', $card->wallet->uuid) }}" class="btn btn-link">{{ $card->wallet->name_account_generic }}</a>
                            @if($card->status == 'active')
                                <button class="btn btn-circle btn-outline btn-outline-dark mb-5 btnDesactiveCard" data-card="{{ $card->id }}">Verrouiller ma carte</button>
                            @else
                                <button class="btn btn-circle btn-outline btn-outline-dark mb-5 btnActiveCard" data-card="{{ $card->id }}">Deverrouiller ma carte</button>
                            @endif
                            @if($card->status != 'opposit')
                                <button class="btn btn-circle btn-outline btn-outline-danger mb-5" data-bs-toggle="modal" data-bs-target="#OppositCard">Faire opposition</button>
                            @else
                                <a href="{{ route('customer.card.opposit', $card->id) }}" class="btn btn-link mb-5">Dossier {{ $card->opposition->reference }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-10">
            <div class="card-header">
                <h3 class="card-title">Gérer mes plafonds</h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <div class="d-flex align-items-center flex-column mt-3 w-75">
                        <div class="d-flex justify-content-between fw-bold fs-6 opacity-75 w-100 mt-auto mb-2">
                            <span>Plafond de paiement mensuel <span class="text-muted fs-8">(jusqu'au {{ now()->endOfMonth()->format("d/m/Y") }})</span></span>
                            <span>{{ eur($card->limit_payment) }}</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-black bg-opacity-75 rounded">
                            <div class="bg-success rounded h-8px" role="progressbar" style="width: {{ $card->getTransactionsMonthPayment(true) }}%;" aria-valuenow="{{ $card->getTransactionsMonthPayment(true) }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-6 opacity-75 w-100 mt-auto mb-2">
                            <span class="text-success fw-bolder">Utilisé: {{ eur($card->getTransactionsMonthPayment()) }}</span>
                            <span>Restant: {{ eur($card->limit_payment - $card->getTransactionsMonthPayment()) }}</span>
                        </div>
                    </div>
                    <button class="btn btn-link btnEditLimitPayment"><i class="fa-solid fa-edit text-dark me-2"></i> Modifier</button>
                </div>
                <div class="separator separator-dashed my-5"></div>
                <div class="d-flex flex-row justify-content-between">
                    <div class="fw-bolder fs-4">Capacité de retrait (France et étranger) <span class="text-muted fs-9">sur 7 jours glissants</span></div>
                    <div class="fw-bolder fs-3">{{ eur($card->actual_limit_withdraw) }}</div>
                    <button class="btn btn-link btnEditLimitWithdraw"><i class="fa-solid fa-edit text-dark me-2"></i> Modifier</button>
                </div>
                <div class="d-flex align-items-center flex-column mt-3 w-75">
                    <div class="h-8px mx-3 w-100 bg-black bg-opacity-75 rounded">
                        <div class="bg-success rounded h-8px" role="progressbar" style="width: {{ $card->getTransactionsMonthWithdraw(true) }}%;" aria-valuenow="{{ $card->getTransactionsMonthwithdraw() }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-6 opacity-75 w-100 mt-auto mb-2">
                        <span class="text-success fw-bolder">Utilisé: {{ eur($card->getTransactionsMonthWithdraw()) }}</span>
                        <span>Restant: {{ eur($card->actual_limit_withdraw - $card->getTransactionsMonthWithdraw()) }}</span>
                    </div>
                </div>

            </div>
        </div>
        <!--begin::Accordion-->
        <div class="accordion mb-10" id="kt_accordion_1">
            <div class="accordion-item">
                <h2 class="accordion-header" id="kt_accordion_1_header_1">
                    <button class="accordion-button fs-1 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#options" aria-expanded="true" aria-controls="options">
                        Vos Options
                    </button>
                </h2>
                <div id="options" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                    <div class="accordion-body">
                        <table class="table table-sm mb-10">
                            <tr>
                                <td colspan="3" class="pe-5 bg-gray-300 fw-bold fs-3">Mes Options</td>
                            </tr>
                            <tr>
                                <td>Option Crédit</td>
                                <td>
                                    @if($card->facelia)
                                        <i class="fa-regular fa-circle-dot text-success me-3 fs-3"></i> Souscrit
                                    @else
                                        <i class="fa-regular fa-circle-dot text-danger me-3 fs-3"></i> Non souscrit
                                    @endif
                                </td>
                                <td>
                                    @if($card->facelia)
                                        <a href="" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#GestionCredit"><i class="fa-solid fa-eye me-2"></i> Gérez</a>
                                    @else
                                        <a href="" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#SubscribeCredit"><i class="fa-solid fa-eye me-2"></i> Découvrir</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Option E-carte bleu</td>
                                <td>
                                    @if($customer->setting->nb_virtual_card != 0)
                                        <i class="fa-regular fa-circle-dot text-success me-3 fs-3"></i> Souscrit
                                    @else
                                        <i class="fa-regular fa-circle-dot text-danger me-3 fs-3"></i> Non souscrit
                                    @endif
                                </td>
                                <td>
                                    @if($customer->setting->nb_virtual_card != 0)
                                        <a href="" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#GestionECard"><i class="fa-solid fa-eye me-2"></i> Gérez</a>
                                    @else
                                        <a href="" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#SubscribeECard"><i class="fa-solid fa-eye me-2"></i> Découvrir</a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <table class="table table-sm mb-10">
                            <tr>
                                <td colspan="3" class="pe-5 bg-gray-300 fw-bold fs-3">Mes Préférences</td>
                            </tr>
                            <tr>
                                <td>Paiement sans contact</td>
                                <td>
                                    @if($card->payment_contact)
                                        <i class="fa-regular fa-circle-dot text-success me-3 fs-3"></i> Actif
                                    @else
                                        <i class="fa-regular fa-circle-dot text-danger me-3 fs-3"></i> Inactif
                                    @endif
                                </td>
                                <td>
                                    @if($card->payment_contact)
                                        <a href="" class="btn btn-link btnDesactiveContact"><i class="fa-solid fa-lock me-2"></i> Désactiver</a>
                                    @else
                                        <a href="" class="btn btn-link btnActiveContact"><i class="fa-solid fa-unlock me-2"></i> Activer</a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Accordion-->
        @if(Agent::isMobile())
            <a href="" class="d-flex flex-row justify-content-between rounded border border-2 w-100 bg-white text-dark p-5 hover-elevate-up mb-10" data-bs-toggle="modal" data-bs-target="#showCodeCard">
                <div class="d-flex flex-column">
                    <span class="fw-bolder fs-2">Consulter mon code secret</span>
                    <p>Vous avez oublier le code secret de votre carte bancaire ? Consulter le !</p>
                </div>
                <i class="fa-solid fa-arrow-right-long fs-1 align-items-center"></i>
            </a>
        @endif
        <a href="" class="d-flex flex-row justify-content-between rounded border border-2 w-100 bg-white text-dark p-5 hover-elevate-up mb-10" data-bs-toggle="modal" data-bs-target="#ConfigCard">
            <div class="d-flex flex-column">
                <span class="fw-bolder fs-2">Paramétrer ma carte</span>
                <p>Adaptez les fonctionnalités de votre carte à vos usages : retraits, opérations à l'étranger ou achats en ligne chez les e-commercants</p>
            </div>
            <i class="fa-solid fa-arrow-right-long fs-1 align-items-center"></i>
        </a>
        <a href="" class="d-flex flex-row justify-content-between rounded border border-2 w-100 bg-white text-dark p-5 hover-elevate-up mb-10" data-bs-toggle="modal" data-bs-target="#DeclareTravel">
            <div class="d-flex flex-column">
                <span class="fw-bolder fs-2">Déclarer un voyage à l'étranger</span>
                <p> Vous partez à l'étranger ? Dites-le nous pour éviter tout blocage de carte. </p>
            </div>
            <i class="fa-solid fa-arrow-right-long fs-1 align-items-center"></i>
        </a>
    </div>
    <div class="modal fade" tabindex="-1" id="OppositCard">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Opposition sur ma carte bancaire</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formOppositCard" action="/api/card/{{ $card->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="oppositCard">
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="type" class="form-label required">Type d'opposition</label>
                            <select name="type" id="type" class="form-control form-control-solid selectpicker" data-title="Slectionner une cause à l'opposition">
                                <option value=""></option>
                                <option value="vol">Vol</option>
                                <option value="perte">Perte</option>
                                <option value="fraude">Fraude</option>
                            </select>
                        </div>
                        <x-form.textarea
                            name="description"
                            label="Décrivez la cause de l'opposition"
                            required="true" />
                    </div>
                    <div class="modal-footer text-end">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.card.show")
@endsection

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
                <a href="{{ route('agent.customer.show', $facelia->card->wallet->customer->id) }}"
                   class="text-muted text-hover-primary">{{ $facelia->card->wallet->customer->user->identifiant }} - {{ $facelia->card->wallet->customer->info->full_name }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.wallet.show', $facelia->card->wallet->number_account) }}"
                   class="text-muted text-hover-primary">{{ $facelia->card->wallet->type_text }} - N°{{ $facelia->card->wallet->number_account }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Carte Bancaire {{ $facelia->card->support->name }} - {{ $facelia->card->number_format }} / FACELIA</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>-->
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-3 col-sm-12 mb-10">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-hand me-2"></i> Information sur le prêt affilié</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Type de prêt</div>
                        <div class="ps-5">{{ $facelia->pret->plan->name }}</div>
                    </div>
                    <div class="separator separator-dashed border-black border-3 my-3"></div>
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Référence</div>
                        <div class="ps-5"><a href="{{ route('agent.customer.wallet.show', $facelia->pret->wallet->number_account) }}">{{ $facelia->pret->reference }}</a></div>
                    </div>
                    <div class="separator separator-dashed border-black border-3 my-3"></div>
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Etat</div>
                        <div class="ps-5">{!! $facelia->pret->status_label !!}</div>
                        <div class="ps-5 fs-6"><i>{{ $facelia->pret->status_explanation }}</i></div>
                    </div>
                    <div class="separator separator-dashed border-black border-3 my-3"></div>
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Compte affilié</div>
                        <div class="ps-5">{{ $facelia->card->wallet->name_account }}</div>
                    </div>
                    <div class="separator separator-dashed border-black border-3 my-3"></div>
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Carte Affilié</div>
                        <div class="ps-5">{{ $facelia->card->number_format }}</div>
                    </div>
                    @if($facelia->pret->status == 'study')
                    <div class="separator separator-dashed border-black border-3 my-3"></div>
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Information à vérifié</div>
                        <div class="ps-5">
                            <ul>
                                <li>Signature du contrat envoyé en requete</li>
                                <li>Information sur la fiche de paie = information bancaire</li>
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-end">
                        @if($facelia->pret->status == 'study')
                            <button class="btn btn-sm btn-success btnAcceptPret me-2" data-pret="{{ $facelia->pret->id }}"><i class="fa-solid fa-check me-2"></i> Valider le pret</button>
                            <button class="btn btn-sm btn-danger btnRejectPret me-2" data-pret="{{ $facelia->pret->id }}"><i class="fa-solid fa-xmark me-2"></i> Refuser le pret</button>
                        @endif
                        @if($facelia->pret->status == 'open')
                            <button class="btn btn-sm btn-success btnStudyPret me-2" data-pret="{{ $facelia->pret->id }}"><i class="fa-solid fa-question-circle me-2"></i> Passer le dossier en étude</button>
                        @endif
                        @if($facelia->pret->status == 'accepted')
                            <button class="btn btn-sm btn-success btnProgressPret me-2" data-pret="{{ $facelia->pret->id }}"><i class="fa-solid fa-arrow-circle-left me-2"></i> Libéré le pret</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="bg-gray-600 text-white p-5 fs-1 rounded-3 mb-5">
                <strong>Situation</strong> aux {{ now()->format('d/m/Y') }}
            </div>
            <div class="d-flex flex-row w-100 p-5 bg-white rounded-3">
                <div class="flex-column">
                    <div class="d-flex flex-row w-400px justify-content-between align-items-center mb-5">
                        <div class="d-flex flex-column fs-2">
                            <div class="fw-bolder">Crédit Renouvelable</div>
                            <div class="fs-3">N° {{ $facelia->reference }}</div>
                        </div>
                        @if($facelia->pret->alert == 1)
                            <div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="tooltip-dark"
                                 title="{{ "Votre dossier présente un retard de paiement de ".eur($facelia->amount_du).".Pour éviter une procédure de recouvrement, il est important de régulariser votre situation." }}">
                                <div class="symbol-label">
                                    <i class="fa-solid fa-exclamation-triangle fa-2x text-warning"></i>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="separator my-5 w-400px border-2"></div>
                    <div class="d-flex flex-column w-400px">
                        <div class="d-flex flex-row justify-content-between p-3 pb-5 fs-3 border-bottom">
                            <div class="fw-bolder">Prochain Prélèvement</div>
                            <div class="fs-4 text-primary fw-bold">{{ eur($facelia->amount_du) }}</div>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center p-3 fs-4 border-bottom">
                            <div class="fw-bold w-50">
                                Vos opérations au comptant
                                @if(\App\Helper\CustomerFaceliaHelper::calcComptantMensuality($facelia->wallet) > 0)
                                    <span class="fs-8">Prélevé le {{ $facelia->next_expiration->format('d/m/Y') }}</span>
                                @endif
                            </div>
                            <div class="fs-5 text-primary fw-bold text-right">{{ eur(\App\Helper\CustomerFaceliaHelper::calcComptantMensuality($facelia->wallet)) }}</div>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center p-3 fs-4 border-bottom border-bottom-4 border-gray-600">
                            <div class="fw-bold w-50">
                                Vos opérations selon votre mensualité choisie
                                @if(\App\Helper\CustomerFaceliaHelper::calcOpsSepaMensuality($facelia->pret->wallet) > 0)
                                    <span class="fs-8">Prélevé le {{ $facelia->next_expiration->format('d/m/Y') }}</span>
                                @endif
                            </div>
                            <div class="fs-5 text-primary fw-bold text-right">{{ eur(\App\Helper\CustomerFaceliaHelper::calcOpsSepaMensuality($facelia->pret->wallet)) }}</div>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center p-3 fs-3 border-bottom">
                            <div class="fw-bolder w-50">
                                Montant Disponible
                            </div>
                            <div class="fs-4 text-success fw-bold text-right">{{ eur($facelia->amount_available) }}</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column w-800px ms-5">
                    <table class="table border table-striped gs-7 gy-7 gx-7 fs-4">
                        <tbody>
                        <tr>
                            <td class="fw-bolder">Plafond du crédit renouvelable</td>
                            <td>{{ eur($facelia->pret->amount_loan) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">
                                Montant disponible*<br>
                                <span class="fs-6 fw-normal">*sous réserve des opérations en cours</span>
                            </td>
                            <td>{{ eur($facelia->amount_available) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Montant utilisé</td>
                            <td>{{ $facelia->amount_du == 0 ? eur(0) : eur($facelia->amount_du - $facelia->amount_available) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Montant restant du</td>
                            <td>{{ eur($facelia->amount_du) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">
                                Montant de vos opérations au comptant*<br>
                                <span class="fs-6 fw-normal">(achats différés du mois)</span>
                            </td>
                            <td>{{ eur(\App\Helper\CustomerFaceliaHelper::calcComptantMensuality($facelia->wallet)) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Mensualité actuel</td>
                            <td>{{ eur($facelia->mensuality) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Date de prélèvement</td>
                            <td>
                                @if($facelia->mensuality != 0)
                                    {{ $facelia->nex_expiration->format('d/m/Y') }}
                                @else
                                    Aucune Echéance à devoir
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.wallet.facelia")
@endsection

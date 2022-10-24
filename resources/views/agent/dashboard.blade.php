@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Tableau de Bord</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}"
                   class="text-muted text-hover-primary">Agence</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Tableau de Bord</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>
    </div>
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="row m-10">
            <div class="col">
                <div class="card card-xl-stretch mb-xl-8 cardCalendar min-h-450px">
                    <!--begin::Header-->
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bold mb-2 text-dark">Mes rendez-vous</span>
                            <span class="text-muted fw-semibold fs-7">{{ formatDateFrench(now()) }}</span>
                        </h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-5">
                        <!--begin::Timeline-->
                        <div class="timeline-label">
                            <x-base.indicator />
                            <x-base.button />
                        </div>
                        <!--end::Timeline-->
                    </div>
                    <!--end: Card Body-->
                </div>
            </div>
            <div class="col">
                <div class="card card-xl-stretch mb-5 mb-xl-8 cardNotification min-h-450px">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title fw-bold text-dark">Dernières notifications</h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0">
                        <x-base.indicator />
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col">
                <div class="card card-xl-stretch mb-5 mb-xl-8 cardMailbox min-h-450px">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title fw-bold text-dark">Derniers Message</h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0">
                        <a href="#" class="d-flex flex-row justify-centent-between align-items-center text-black">
                            <div class="d-flex flex-row align-items-center">
                                <div class="symbol symbol-50px me-5">
                                    <img src="/assets/media/avatars/300-6.jpg" alt=""/>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bolder">Test</div>
                                    <div class="text-muted">Sujet du message</div>
                                    <div class="fs-9">08:30</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-user fa-3x ms-n1 mb-5 text-success"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Client Actif</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="count_actif_customer"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-user fa-3x ms-n1 mb-5 text-danger"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Client Bloqué</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="count_disable_customer"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-euro fa-3x ms-n1 mb-5 text-success"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Nombre de dépot</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="count_deposit"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-euro fa-3x ms-n1 mb-5 text-success"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Nombre de retrait</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="count_withdraw"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-receipt fa-3x ms-n1 mb-5 text-success"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Nombre de prêt bancaire</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="count_loan"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-receipt fa-3x ms-n1 mb-5 text-warning"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Nombre de prêt bancaire (en étude)</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="count_loan_study"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-receipt fa-3x ms-n1 mb-5 text-primary"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Nombre de prêt bancaire (en cours)</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="count_loan_progress"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-receipt fa-3x ms-n1 mb-5 text-success"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Nombre de prêt bancaire (Terminer)</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="count_loan_terminated"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-receipt fa-3x ms-n1 mb-5 text-danger"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Nombre de prêt bancaire (Rejeté)</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="count_loan_rejected"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-arrow-circle-down fa-3x ms-n1 mb-5 text-danger"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Total des retraits effectué</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="sum_withdraw"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-arrow-circle-up fa-3x ms-n1 mb-5 text-success"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Total des dépot effectué</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="sum_deposit"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-euro fa-3x ms-n1 mb-5 text-danger"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Montant disponible en agence</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="sum_agency"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card bg-body hoverable card-xl-stretch mb-xl-8" id="card_according">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                        <span class="fa-solid fa-euro fa-3x ms-n1 mb-5 text-danger"></span>
                        <!--end::Svg Icon-->
                        <div class="fw-semibold text-gray-400">Montant disponible pour les prets bancaires</div>
                        <div class="text-gray-900 fw-bold fs-2 mb-2" data-content="according_pret"><span class="spinner-border text-primary"></span></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card card-flush shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Liste des derniers clients</h3>
            </div>
            <div class="card-body py-5">
                <table class="table table-striped border table-row-gray-500 gy-7 gx-7" id="liste_customer">
                    <thead>
                        <tr>
                            <th>Identifiant</th>
                            <th>Identification</th>
                            <th>Coordonnée</th>
                            <th>Montant disponible</th>
                            <th>Etat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\User::where('customer', 1)->orderBy('created_at', 'desc')->limit(5)->get() as $user)
                            <tr>
                                <td>{{ $user->identifiant }}</td>
                                <td>
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="d-flex flex-row">
                                            <div class="symbol symbol-50px me-5">
                                                {!! $user->avatar_symbol !!}
                                            </div>
                                            <div class="d-flex flex-column align-items-center me-10">
                                                <div class="fw-bolder">{{ $user->name }}</div>
                                                {!! $user->customers->info->type_label !!}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            {!! $user->customers->info->account_verified !!}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex flex-row mb-2 align-items-center">
                                            <i class="fa-solid fa-phone me-2"></i>:
                                            <span class="me-3">{{ $user->customers->info->phone }}</span>
                                            {!! $user->customers->info->phone_verified !!}
                                        </div>
                                        <div class="d-flex flex-row mb-2 align-items-center">
                                            <i class="fa-solid fa-mobile me-2"></i>:
                                            <span class="me-3">{{ $user->customers->info->mobile }}</span>
                                            {!! $user->customers->info->mobile_verified !!}
                                        </div>
                                        <div class="d-flex flex-row mb-2 align-items-center">
                                            <i class="fa-solid fa-envelope me-2"></i>:
                                            <span class="me-3">{{ $user->email }}</span>
                                            {!! $user->email_verified !!}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-row justify-content-between">
                                        <strong>Compte bancaire:</strong>
                                        @if($user->customers->sum_account >= 0)
                                            <span class="text-success">+ {{ eur($user->customers->sum_account) }}</span>
                                        @else
                                            <span class="text-danger">{{ eur($user->customers->sum_account) }}</span>
                                        @endif
                                    </div>

                                    <div class="d-flex flex-row justify-content-between">
                                        <strong>Compte épargne:</strong>
                                        @if($user->customers->sum_epargne >= 0)
                                            <span class="text-success">+ {{ eur($user->customers->sum_epargne) }}</span>
                                        @else
                                            <span class="text-danger">{{ eur($user->customers->sum_epargne) }}</span>
                                        @endif
                                    </div>

                                </td>
                                <td>
                                    {!! $user->customers->status_label !!}
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Fiche client</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.dashboard")
@endsection

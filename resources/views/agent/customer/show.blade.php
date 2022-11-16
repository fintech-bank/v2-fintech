@extends("agent.layouts.app")

@section("css")
    <link href="/assets/plugins/custom/jstree/jstree.bundle.css" rel="stylesheet" type="text/css" />
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
            <li class="breadcrumb-item text-dark">{{ $customer->user->identifiant }} - {{ $customer->info->full_name }}</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>-->
    </div>
@endsection

@section("content")
    {!! $customer->user->alert_same_default_password !!}
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        {!! $customer->user->avatar_symbol !!}
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
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
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $customer->info->full_name }}</a>

                                <a href="#" class="me-1">
                                    <i class="fa-solid fa-user-check fs-3 {{ $customer->info->isVerified ? 'text-success' : 'text-secondary' }}" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" title="{{ $customer->info->isVerified ? "Client Vérifié" : "Client non vérifier" }}"></i>
                                </a>
                                <a href="#" class="me-1">
                                    <i class="fa-solid fa-house-circle-check fs-3 {{ $customer->info->addressVerified ? 'text-success' : 'text-secondary' }}" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" title="{{ $customer->info->addressVerified ? "Adresse Postal Vérifié" : "Adresse Postal non vérifier" }}"></i>
                                </a>
                                <a href="#" class="me-1">
                                    <i class="fa-solid fa-user-slash fs-3 {{ $customer->ficp ? 'text-success' : 'text-secondary' }}" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" title="{{ $customer->ficp ? "Client non FICP" : "Client FICP" }}"></i>
                                </a>
                                <a href="#" class="me-1">
                                    <i class="fa-solid fa-money-check-dollar fs-3 {{ $customer->fcc ? 'text-success' : 'text-secondary' }}" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" title="{{ $customer->fcc ? "Client non FCC" : "Client FCC" }}"></i>
                                </a>
                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="fa-solid fa-boxes-packing me-1"></i>
                                    <span data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" title="{{ $customer->package->price_format }} / par mois">Forfait {{ $customer->package->name }}</span>
                                </a>
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="fa-solid fa-user-tie me-1"></i>
                                    <span>Client {{ $customer->info->type_text }}</span>
                                </a>
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <i class="fa-solid fa-envelope-circle-check me-1"></i>
                                    <span>{{ $customer->user->email }}</span>
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::Actions-->
                        <div class="d-flex my-4">

                            <!--begin::Menu-->
                            <div class="me-0">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                    <!--begin::Heading-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Général</div>
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#updateStatus" class="menu-link px-3" data-bs-toggle="modal">Changer l'état du compte client</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#updateAccount" data-bs-toggle="modal" class="menu-link px-3">Changer le type de compte</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                                        <a href="" class="menu-link px-3">
                                            <span class="menu-title">Nouveau compte</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#createWallet" data-bs-toggle="modal" class="menu-link px-3">Compte Bancaire</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#createEpargne" data-bs-toggle="modal" class="menu-link px-3">Compte Epargne</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#createPret" data-bs-toggle="modal" class="menu-link px-3">Pret Bancaire</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <div class="separator my-2"></div>
                                    <!--end::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Communication</div>
                                    </div>
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-5">
                                        <a href="tel:{{ $customer->info->phone }}" class="menu-link px-5"><i class="fa-solid fa-phone me-3"></i> Téléphone Fixe</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <div class="menu-item px-5">
                                        <a href="tel:{{ $customer->info->mobile }}" class="menu-link px-5"><i class="fa-solid fa-mobile me-3"></i> Téléphone Mobile</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <div class="menu-item px-5">
                                        <a href="#write-sms" data-bs-toggle="modal" class="menu-link px-5"><i class="fa-solid fa-comment-sms me-3"></i> Envoyer un sms</a>
                                    </div>
                                    <div class="menu-item px-5">
                                        <a href="#write-mail" data-bs-toggle="modal" class="menu-link px-5"><i class="fa-solid fa-envelope me-3"></i> Envoyer un Email</a>
                                    </div>
                                </div>
                                <!--end::Menu 3-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap">
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                        <span class="svg-icon svg-icon-3 svg-icon-success me-2">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
												<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor"></path>
											</svg>
										</span>
                                        <!--end::Svg Icon-->
                                        <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="{{ \App\Helper\CustomerHelper::getAmountAllDeposit($customer) }}" data-kt-countup-suffix="€" data-kt-initialized="1">{{ \App\Helper\CustomerHelper::getAmountAllDeposit($customer) }}</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Dépots</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
                                        <span class="svg-icon svg-icon-3 svg-icon-danger me-2">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect>
												<path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor"></path>
											</svg>
										</span>
                                        <!--end::Svg Icon-->
                                        <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="{{ \App\Helper\CustomerHelper::getAmountAllWithdraw($customer) }}" data-kt-countup-suffix="€" data-kt-initialized="1">{{ \App\Helper\CustomerHelper::getAmountAllWithdraw($customer) }}</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Retraits</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Progress-->
                        <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-semibold fs-6 text-gray-400">Cotation du client</span>
                                <span class="fw-bold fs-6">{{ $customer->cotation }}</span>
                            </div>
                            <div class="h-5px mx-3 w-100 bg-light mb-3">
                                @if($customer->cotation < 4)
                                    <div class="bg-danger rounded h-5px" role="progressbar" style="width: {{ $customer->cotation * 10 }}%;" aria-valuenow="{{ $customer->cotation * 10 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                @elseif($customer->cotation >= 4 && $customer->cotation <= 7)
                                    <div class="bg-warning rounded h-5px" role="progressbar" style="width: {{ $customer->cotation * 10 }}%;" aria-valuenow="{{ $customer->cotation * 10 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                @else
                                    <div class="bg-success rounded h-5px" role="progressbar" style="width: {{ $customer->cotation * 10 }}%;" aria-valuenow="{{ $customer->cotation * 10 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                @endif
                                <span class="text-muted fs-8">Basée sur l'ensemble des mouvements de tous les comptes</span>
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
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#dashboard">Tableau de Bord</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#customer">Fiche client</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#wallets">Compte bancaire</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#files">Fichiers</a>
                </li>
                <!--end::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#subscriptions">Souscriptions</a>
                </li>

                @if($customer->info->type != 'part')
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#business_plan">Calcul Prévisionnel</a>
                    </li>
                @endif
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <div class="tab-content" id="myTabContent">
        <!--begin:::Tab pane-->
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
            <div class="row g-5 g-xl-8">
                <div class="col-xl-3">
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <span class="svg-icon svg-icon-success svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M13 9.59998V21C13 21.6 12.6 22 12 22C11.4 22 11 21.6 11 21V9.59998H13Z"
                                                fill="currentColor"/>
                                            <path opacity="0.3"
                                                  d="M4 9.60002H20L12.7 2.3C12.3 1.9 11.7 1.9 11.3 2.3L4 9.60002Z"
                                                  fill="currentColor"/>
                                            </svg>
										</span>
                            <!--end::Svg Icon-->
                            <div
                                class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getAmountAllDeposit($customer) }}</div>
                            <div class="fw-bold text-gray-400">Total déposé</div>
                        </div>
                        <!--end::Body-->
                    </a>
                </div>
                <div class="col-xl-3">
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <span class="svg-icon svg-icon-danger svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.5"
                                                  d="M13 14.4V3.00003C13 2.40003 12.6 2.00003 12 2.00003C11.4 2.00003 11 2.40003 11 3.00003V14.4H13Z"
                                                  fill="currentColor"/>
                                            <path
                                                d="M5.7071 16.1071C5.07714 15.4771 5.52331 14.4 6.41421 14.4H17.5858C18.4767 14.4 18.9229 15.4771 18.2929 16.1071L12.7 21.7C12.3 22.1 11.7 22.1 11.3 21.7L5.7071 16.1071Z"
                                                fill="currentColor"/>
                                            </svg>
										</span>
                            <!--end::Svg Icon-->
                            <div
                                class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getAmountAllWithdraw($customer) }}</div>
                            <div class="fw-bold text-gray-400">Total Retiré</div>
                        </div>
                        <!--end::Body-->
                    </a>
                </div>
                <div class="col-xl-3">
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M7 6.59998V20C7 20.6 7.4 21 8 21C8.6 21 9 20.6 9 20V6.59998H7ZM15 17.4V4C15 3.4 15.4 3 16 3C16.6 3 17 3.4 17 4V17.4H15Z"
                                                fill="currentColor"/>
                                            <path opacity="0.3"
                                                  d="M3 6.59999H13L8.7 2.3C8.3 1.9 7.7 1.9 7.3 2.3L3 6.59999ZM11 17.4H21L16.7 21.7C16.3 22.1 15.7 22.1 15.3 21.7L11 17.4Z"
                                                  fill="currentColor"/>
                                            </svg>
										</span>
                            <!--end::Svg Icon-->
                            <div
                                class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getAmountAllTransfers($customer) }}</div>
                            <div class="fw-bold text-gray-400">Total Transféré</div>
                        </div>
                        <!--end::Body-->
                    </a>
                </div>
                <div class="col-xl-3">
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                  d="M3.20001 5.91897L16.9 3.01895C17.4 2.91895 18 3.219 18.1 3.819L19.2 9.01895L3.20001 5.91897Z"
                                                  fill="currentColor"/>
                                            <path opacity="0.3"
                                                  d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21C21.6 10.9189 22 11.3189 22 11.9189V15.9189C22 16.5189 21.6 16.9189 21 16.9189H16C14.3 16.9189 13 15.6189 13 13.9189ZM16 12.4189C15.2 12.4189 14.5 13.1189 14.5 13.9189C14.5 14.7189 15.2 15.4189 16 15.4189C16.8 15.4189 17.5 14.7189 17.5 13.9189C17.5 13.1189 16.8 12.4189 16 12.4189Z"
                                                  fill="currentColor"/>
                                            <path
                                                d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21V7.91895C21 6.81895 20.1 5.91895 19 5.91895H3C2.4 5.91895 2 6.31895 2 6.91895V20.9189C2 21.5189 2.4 21.9189 3 21.9189H19C20.1 21.9189 21 21.0189 21 19.9189V16.9189H16C14.3 16.9189 13 15.6189 13 13.9189Z"
                                                fill="currentColor"/>
                                            </svg>
										</span>
                            <!--end::Svg Icon-->
                            <div
                                class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getAmountAllTransactions($customer) }}</div>
                            <div class="fw-bold text-gray-400">Transactions</div>
                        </div>
                        <!--end::Body-->
                    </a>
                </div>
                <div class="col-xl-3">
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                  d="M15.8 11.4H6C5.4 11.4 5 11 5 10.4C5 9.80002 5.4 9.40002 6 9.40002H15.8C16.4 9.40002 16.8 9.80002 16.8 10.4C16.8 11 16.3 11.4 15.8 11.4ZM15.7 13.7999C15.7 13.1999 15.3 12.7999 14.7 12.7999H6C5.4 12.7999 5 13.1999 5 13.7999C5 14.3999 5.4 14.7999 6 14.7999H14.8C15.3 14.7999 15.7 14.2999 15.7 13.7999Z"
                                                  fill="currentColor"/>
                                            <path
                                                d="M18.8 15.5C18.9 15.7 19 15.9 19.1 16.1C19.2 16.7 18.7 17.2 18.4 17.6C17.9 18.1 17.3 18.4999 16.6 18.7999C15.9 19.0999 15 19.2999 14.1 19.2999C13.4 19.2999 12.7 19.2 12.1 19.1C11.5 19 11 18.7 10.5 18.5C10 18.2 9.60001 17.7999 9.20001 17.2999C8.80001 16.8999 8.49999 16.3999 8.29999 15.7999C8.09999 15.1999 7.80001 14.7 7.70001 14.1C7.60001 13.5 7.5 12.8 7.5 12.2C7.5 11.1 7.7 10.1 8 9.19995C8.3 8.29995 8.79999 7.60002 9.39999 6.90002C9.99999 6.30002 10.7 5.8 11.5 5.5C12.3 5.2 13.2 5 14.1 5C15.2 5 16.2 5.19995 17.1 5.69995C17.8 6.09995 18.7 6.6 18.8 7.5C18.8 7.9 18.6 8.29998 18.3 8.59998C18.2 8.69998 18.1 8.69993 18 8.79993C17.7 8.89993 17.4 8.79995 17.2 8.69995C16.7 8.49995 16.5 7.99995 16 7.69995C15.5 7.39995 14.9 7.19995 14.2 7.19995C13.1 7.19995 12.1 7.6 11.5 8.5C10.9 9.4 10.5 10.6 10.5 12.2C10.5 13.3 10.7 14.2 11 14.9C11.3 15.6 11.7 16.1 12.3 16.5C12.9 16.9 13.5 17 14.2 17C15 17 15.7 16.8 16.2 16.4C16.8 16 17.2 15.2 17.9 15.1C18 15 18.5 15.2 18.8 15.5Z"
                                                fill="currentColor"/>
                                            </svg>
										</span>
                            <!--end::Svg Icon-->
                            <div
                                class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getCountAllLoan($customer) }}</div>
                            <div class="fw-bold text-gray-400">Prets</div>
                        </div>
                        <!--end::Body-->
                    </a>
                </div>
                <div class="col-xl-4">
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M6 20C6 20.6 5.6 21 5 21C4.4 21 4 20.6 4 20H6ZM18 20C18 20.6 18.4 21 19 21C19.6 21 20 20.6 20 20H18Z"
                                                fill="currentColor"/>
                                            <path opacity="0.3"
                                                  d="M21 20H3C2.4 20 2 19.6 2 19V3C2 2.4 2.4 2 3 2H21C21.6 2 22 2.4 22 3V19C22 19.6 21.6 20 21 20ZM12 10H10.7C10.5 9.7 10.3 9.50005 10 9.30005V8C10 7.4 9.6 7 9 7C8.4 7 8 7.4 8 8V9.30005C7.7 9.50005 7.5 9.7 7.3 10H6C5.4 10 5 10.4 5 11C5 11.6 5.4 12 6 12H7.3C7.5 12.3 7.7 12.5 8 12.7V14C8 14.6 8.4 15 9 15C9.6 15 10 14.6 10 14V12.7C10.3 12.5 10.5 12.3 10.7 12H12C12.6 12 13 11.6 13 11C13 10.4 12.6 10 12 10Z"
                                                  fill="currentColor"/>
                                            <path
                                                d="M18.5 11C18.5 10.2 17.8 9.5 17 9.5C16.2 9.5 15.5 10.2 15.5 11C15.5 11.4 15.7 11.8 16 12.1V13C16 13.6 16.4 14 17 14C17.6 14 18 13.6 18 13V12.1C18.3 11.8 18.5 11.4 18.5 11Z"
                                                fill="currentColor"/>
                                            </svg>
										</span>
                            <!--end::Svg Icon-->
                            <div
                                class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getCoutAllEpargnes($customer) }}</div>
                            <div class="fw-bold text-gray-400">Epargnes</div>
                        </div>
                        <!--end::Body-->
                    </a>
                </div>
                <div class="col-xl-5">
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z"
                                                fill="currentColor"/>
                                            <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2"
                                                  fill="currentColor"/>
                                            <path
                                                d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z"
                                                fill="currentColor"/>
                                            <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3"
                                                  fill="currentColor"/>
                                            </svg>
										</span>
                            <!--end::Svg Icon-->
                            <div
                                class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getCountAllBeneficiaires($customer) }}</div>
                            <div class="fw-bold text-gray-400">Bénéficiaires</div>
                        </div>
                        <!--end::Body-->
                    </a>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Dernière transactions</h3>
                </div>
                <div class="card-body">
                    <table class="table border table-striped gx-5 gy-5">
                        <thead>
                        <tr>
                            <th>Libellé</th>
                            <th>Date de valeur</th>
                            <th>Montant</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customer->wallets()->where('type', '!=', 'pret')->get() as $wallet)
                            @foreach($wallet->transactions()->where('confirmed', true)->orderBy('confirmed_at', 'desc')->limit(5)->get() as $transaction)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-row align-items-center">
                                            {!! $transaction->getTypeSymbolAttribute('20px') !!}
                                            <span data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="right" data-bs-html="true" title="<i class='fa-solid fa-info-circle me-2'></i>Information" data-bs-content="{{ $transaction->designation }}">{{ $transaction->description }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $transaction->confirmed_at->format("d/m/Y") }}</td>
                                    <td>
                                        <span class="me-2">{{ $transaction->amount_format }}</span>
                                        @if($transaction->differed)
                                            <span
                                                class="iconify text-warning"
                                                data-icon="fe:difference"
                                                data-width="20"
                                                data-height="20"
                                                data-bs-toggle="popover"
                                                data-bs-trigger="hover"
                                                data-bs-placement="right"
                                                data-bs-html="true"
                                                title="Mouvement différé"
                                                data-bs-content="<div class='d-flex flex-column'><span class='fw-bolder'>Date de différé</span> {{ $transaction->differed_at->format('d/m/Y') }}</div>"></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="customer" role="tabpanel">
            <div class="accordion" id="accordion_customer">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordion_customer_header_1">
                        <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_customer_body_1" aria-expanded="true" aria-controls="accordion_customer_body_1">
                            <i class="fa-solid fa-house me-3"></i> Adresse Postal
                        </button>
                    </h2>
                    <div id="accordion_customer_body_1" class="accordion-collapse collapse" aria-labelledby="accordion_customer_header_1" data-bs-parent="#accordion_customer">
                        <div class="accordion-body">
                            <form action="{{ route('agent.customer.update', $customer->id) }}" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="control" value="address">
                                <x-form.input
                                    name="address"
                                    type="text"
                                    label="Adresse Postal"
                                    required="true"
                                    value="{{ $customer->info->address }}" />
                                <x-form.input
                                    name="addressbis"
                                    type="text"
                                    label="Complément d'adresse"
                                    value="{{ $customer->info->addressbis }}"/>

                                <div class="row">
                                    <div class="col-4">
                                        <x-form.input
                                            name="postal"
                                            type="text"
                                            label="Code Postal"
                                            required="true"
                                            value="{{ $customer->info->postal }}"/>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-10" id="divCity"></div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-10">
                                            <label for="country" class="required form-label">
                                                Pays de résidence
                                            </label>
                                            <select id="country" class="form-select form-select-solid" data-placeholder="Selectionnez un pays" name="country">
                                                <option value=""></option>
                                                @foreach(\App\Helper\GeoHelper::getAllCountries() as $data)
                                                    <option value="{{ $data->name }}" @if($customer->info->country == $data->name) selected @endif data-kt-select2-country="{{ $data->flag }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <x-form.button />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="kt_accordion_1_header_2">
                        <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="false" aria-controls="kt_accordion_1_body_2">
                            <i class="fa-solid fa-phone me-3"></i> Coordonnées
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <form action="{{ route('agent.customer.update', $customer->id) }}" method="post">
                                @csrf
                                @method("put")
                                <input type="hidden" name="control" value="coordonnee">
                                <x-form.input-group
                                    name="phone"
                                    label="Numéro de téléphone fixe"
                                    symbol="<i class='fa-solid fa-phone'></i>"
                                    placement="left"
                                    value="{{ $customer->info->phone }}" />

                                <x-form.input-group
                                    name="mobile"
                                    label="Numéro de téléphone Portable"
                                    symbol="<i class='fa-solid fa-mobile'></i>"
                                    placement="left"
                                    value="{{ $customer->info->mobile }}" />

                                <x-form.input-group
                                    name="email"
                                    label="Adresse Mail"
                                    symbol="<i class='fa-solid fa-envelope'></i>"
                                    placement="left"
                                    value="{{ $customer->user->email }}" />

                                <div class="d-flex justify-content-end">
                                    <x-form.button />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="kt_accordion_1_header_3">
                        <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_3" aria-expanded="false" aria-controls="kt_accordion_1_body_3">
                            <i class="fa-solid fa-user me-3"></i> Situation
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_3" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_3" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <form action="{{ route('agent.customer.update', $customer->id) }}" method="post">
                                @csrf
                                @method("put")
                                <input type="hidden" name="control" value="situation">

                                <x-base.underline title="Situation Personnel" size="3" sizeText="fs-1" color="bank" />
                                <div class="row">
                                    <div class="col-6">
                                        <x-form.select
                                            name="legal_capacity"
                                            :datas="\App\Helper\CustomerSituationHelper::dataLegalCapacity()"
                                            :value="['key' => $customer->situation->legal_capacity, 'value' => $customer->situation->legal_capacity]"
                                            label="Capacité Juridique" required="false"/>
                                    </div>
                                    <div class="col-6">
                                        <x-form.select
                                            name="family_situation"
                                            :datas="\App\Helper\CustomerSituationHelper::dataFamilySituation()"
                                            :value="['key' => $customer->situation->family_situation, 'value' => $customer->situation->family_situation]"
                                            label="Situation Familiale" required="false"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <x-form.select
                                            name="logement"
                                            :datas="\App\Helper\CustomerSituationHelper::dataLogement()"
                                            :value="['key' => $customer->situation->logement, 'value' => $customer->situation->logement]"
                                            label="Dans votre logement, vous êtes" required="false"/>
                                    </div>
                                    <div class="col-6">
                                        <x-form.input-date
                                            name="logement_at"
                                            type="text"
                                            label="Depuis le"
                                            value="{{ $customer->situation->logement_at }}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <x-form.input-dialer
                                            name="child"
                                            label="Nombre d'enfant"
                                            min="0"
                                            max="99"
                                            step="1"
                                            value="{{ $customer->situation->nb_child }}" />
                                    </div>
                                    <div class="col-6">
                                        <x-form.input-dialer
                                            name="person_charged"
                                            label="Nombre de personne à charge"
                                            min="0"
                                            max="99"
                                            step="1"
                                            value="{{ $customer->situation->person_charged }}" />
                                    </div>
                                </div>
                                <x-base.underline title="Situation Professionnel" size="3" sizeText="fs-1" color="bank" />
                                <x-form.select
                                    name="pro_category"
                                    :datas="\App\Helper\CustomerSituationHelper::dataProCategories()"
                                    :value="['key' => $customer->situation->pro_category, 'value' => $customer->situation->pro_category]"
                                    label="Catégorie sociaux Professionnel" />

                                <x-form.input
                                    name="pro_profession"
                                    type="text"
                                    label="Profession"
                                    value="{{ $customer->situation->pro_profession }}"/>

                                <x-base.underline title="Revenue" size="3" sizeText="fs-1" color="bank" />
                                <div class="row">
                                    <div class="col-6">
                                        <x-form.input-group
                                            name="pro_incoming"
                                            label="Revenue Professionnel"
                                            placement="left"
                                            symbol="€"
                                            value="{{ $customer->income->pro_incoming }}" />
                                    </div>
                                    <div class="col-6">
                                        <x-form.input-group
                                            name="patrimoine"
                                            label="Patrimoine"
                                            placement="left"
                                            symbol="€"
                                            value="{{ $customer->income->patrimoine }}" />
                                    </div>
                                </div>
                                <x-base.underline title="Charges" size="3" sizeText="fs-1" color="bank" />
                                <div class="row">
                                    <div class="col-6">
                                        <x-form.input-group
                                            name="rent"
                                            label="Loyer, mensualité crédit immobilier"
                                            placement="left"
                                            symbol="€"
                                            value="{{ $customer->charge->rent }}"/>
                                    </div>
                                    <div class="col-6">
                                        <x-form.input-group
                                            name="divers"
                                            label="Charges Divers (pension, etc...)"
                                            placement="left"
                                            symbol="€"
                                            value="{{ $customer->charge->divers }}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <x-form.input
                                            name="nb_credit"
                                            type="text"
                                            label="Nombre de crédit (Crédit Personnel, Renouvelable, etc...)"
                                            value="{{ $customer->charge->nb_credit }}"/>
                                    </div>
                                    <div class="col-6">
                                        <x-form.input-group
                                            name="credit"
                                            label="Mensualité de vos crédits"
                                            placement="left"
                                            symbol="€"
                                            value="{{ $customer->charge->credit }}"/>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <x-form.button />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="kt_accordion_1_header_4">
                        <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_4" aria-expanded="false" aria-controls="kt_accordion_1_body_3">
                            <i class="fa-solid fa-message me-3"></i> Communication
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_4" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_4" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <form action="{{ route('agent.customer.update', $customer->id) }}" method="post">
                                @csrf
                                @method("put")
                                <input type="hidden" name="control" value="communication">

                                <x-form.checkbox
                                    name="notif_sms"
                                    label="Notification commercial SMS"
                                    value="{{ $customer->setting->notif_sms }}"
                                    checked="{{ $customer->setting->notif_sms ?? false }}" />

                                <x-form.checkbox
                                    name="notif_app"
                                    label="Notification commercial Application"
                                    value="{{ $customer->setting->notif_app }}"
                                    checked="{{ $customer->setting->notif_app ?? false }}"
                                />

                                <x-form.checkbox
                                    name="notif_mail"
                                    label="Notification commercial EMAIL"
                                    value="{{ $customer->setting->notif_mail }}"
                                    checked="{{ $customer->setting->notif_mail ?? false }}"
                                />

                                <div class="d-flex justify-content-end">
                                    <x-form.button />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header " id="kt_accordion_1_header_5">
                        <button class="accordion-button bg-light-danger text-hover-danger text-active-danger fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_5" aria-expanded="false" aria-controls="kt_accordion_1_body_3">
                            <i class="fa-solid fa-user-shield me-3"></i> Sécurité
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_5" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_5" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <x-form.button id="btnPass" text="Réinitialiser le mot de passe" :dataset="[
                                            [
                                            'name' => 'customer',
                                            'value' => $customer->id,
                                            ]
                                        ]"/>
                            <x-form.button id="btnCode" text="Réinitialiser le code SECURIPASS" data-customer="{{ $customer->id }}" :dataset="[
                                            [
                                            'name' => 'customer',
                                            'value' => $customer->id,
                                            ]
                                        ]"/>
                            @isset($customer->user->two_factor_secret)
                                <x-form.button id="btnAuth" text="Réinitialiser l'authentification Double Facteur" data-customer="{{ $customer->id }}" :dataset="[
                                            [
                                            'name' => 'customer',
                                            'value' => $customer->id,
                                            ]
                                        ]"/>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="wallets" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Liste des comptes bancaires</h3>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center position-relative my-1 me-3">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <input type="text" data-kt-wallet-table-filter="search" class="form-control form-control-solid w-350px ps-15" placeholder="Rechercher..." />
                        </div>
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-wallet-table-toolbar="base">
                            <!--begin::Filter-->
                            <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                                    </svg>
                                </span>
                                Filtrer
                            </button>
                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-4 text-dark fw-bold">Option de filtre</div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Separator-->
                                <!--begin::Content-->
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fs-5 fw-semibold mb-3">Type de compte:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-wallet-table-filter="type" data-dropdown-parent="#kt-toolbar-filter">
                                            <option></option>
                                            <option value="compte">Compte Bancaire</option>
                                            <option value="epargne">Livret d'épargne</option>
                                            <option value="pret">Crédit</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fs-5 fw-semibold mb-3">Status:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-wallet-table-filter="status" data-dropdown-parent="#kt-toolbar-filter">
                                            <option></option>
                                            <option value="pending">En attente</option>
                                            <option value="active">Actif</option>
                                            <option value="suspended">Suspendue</option>
                                            <option value="closed">Clôturer</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-wallet-table-filter="reset">Effacer</button>
                                        <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-wallet-table-filter="filter">Appliquer</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Menu 1-->
                            <!--end::Filter-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                </div>
                <div class="card-body">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_wallet_table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Compte</th>
                                <th class="min-w-125px">Type de compte</th>
                                <th class="min-w-125px">Etat du compte</th>
                                <th class="min-w-125px">Balance</th>
                                <th class="text-end min-w-70px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                        @foreach($customer->wallets as $wallet)
                            <tr>
                                <!--begin::Name=-->
                                <td>
                                    {{ $wallet->number_account }}
                                </td>
                                <!--end::Name=-->
                                <!--begin::Email=-->
                                <td data-filter="{{ $wallet->type }}">
                                    {!! $wallet->type_text !!}
                                </td>

                                <td data-filter="{{ $wallet->status }}">
                                    {!! $wallet->status_label !!}
                                </td>

                                <td>
                                    <strong>Balance Actuel:</strong> {{ eur($wallet->balance_actual) }}<br>
                                    @if($wallet->balance_coming != 0)
                                        <strong class="text-muted">A venir:</strong> {{ eur($wallet->balance_coming) }}<br>
                                    @endif
                                </td>
                                <!--end::Email=-->
                                <!--begin::Action=-->
                                <td class="text-end">
                                    <a href="{{ route('agent.customer.wallet.show', $wallet->number_account) }}" class="btn btn-sm btn-circle btn-icon btn-bank" data-bs-toggle="tooltip" data-bs-placement="left" title="Détail"><i class="fa fa-desktop text-white"></i> </a>
                                </td>
                                <!--end::Action=-->
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="files" role="tabpanel">
            <div class="row">
                <div class="col-md-3 col-sm-12 mb-10">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                @foreach(\App\Models\Core\DocumentCategory::all() as $category)
                                    <a href="" class="d-flex flex-row align-items-center p-5 fs-2 showFiles" data-folder="{{ $category->id }}">
                                        <i class="fa-solid fa-folder me-2 text-primary fs-2"></i>
                                        <span class="fw-bold">{{ $category->name }} ({{ $customer->documents()->where('document_category_id', $category->id)->count() }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12 mb-10">
                    <div class="card shadow-sm" id="showFiles">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-stack folderPath"></div>
                            <table id="kt_file_manager_list" data-kt-filemanager-table="files" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                                <!--begin::Table head-->
                                <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-250px sorting_disabled" rowspan="1" colspan="1" style="width: 520.141px;">Name</th>
                                    <th class="min-w-10px sorting_disabled" rowspan="1" colspan="1" style="width: 117.594px;">Signature</th>
                                    <th class="w-125px sorting_disabled" rowspan="1" colspan="1" style="width: 125px;"></th>
                                </tr>
                                <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-semibold text-gray-600" id="table_files_content">

                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="subscriptions" role="tabpanel">
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Offre</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped gy-5 gx-5">
                                <tbody>
                                    <tr>
                                        <td class="fw-bolder">Offre</td>
                                        <td>{{ $customer->user->subscriptions()->where('subscribe_type', \App\Models\Core\Package::class)->first()->getSubAttribute()->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder">Montant</td>
                                        <td>{{ $customer->user->subscriptions()->where('subscribe_type', \App\Models\Core\Package::class)->first()->getSubAttribute()->price_format }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder">Modalité de souscription</td>
                                        <td>{{ $customer->user->subscriptions()->where('subscribe_type', \App\Models\Core\Package::class)->first()->getSubAttribute()->type_prlv_text }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder">Prochain Prélèvement</td>
                                        <td>{{ $customer->next_debit_package->format('d/m/Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Assurance</h3>
                            <div class="card-toolbar">
                                <!--<button type="button" class="btn btn-sm btn-light">
                                    Action
                                </button>-->
                            </div>
                        </div>
                        <div class="card-body">
                            @if($customer->insurances()->count() == 0)
                                <div class="d-flex flex-row justify-content-center align-items-center p-5 bg-gray-200 rounded-2">
                                    <i class="fa-solid fa-exclamation-triangle fs-1 text-warning me-2"></i>
                                    <span>Aucune assurance souscrite</span>
                                </div>
                            @else
                                <table class="table table-striped border">
                                    <thead>
                                    <tr>
                                        <th>Référence</th>
                                        <th>Désignation</th>
                                        <th>Etat</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customer->insurances()->orderBy('updated_at', 'desc')->limit(5)->get() as $insurance)
                                        <tr>
                                            <td>{{ $insurance->reference }}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div class="fw-bolder">{{ $insurance->package->name }}</div>
                                                    <div class="text-muted">Offre: {{ $insurance->form->name }} ({{ $insurance->form->typed_price_format }})</div>
                                                </div>
                                            </td>
                                            <td>{!! $insurance->status_label !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Mobilité Bancaire</h3>
                            <div class="card-toolbar">
                                <!--<button type="button" class="btn btn-sm btn-light">
                                    Action
                                </button>-->
                            </div>
                        </div>
                        <div class="card-body">
                            @if($customer->mobilities()->count() == 0)
                                <div class="d-flex flex-row justify-content-center align-items-center p-5 bg-gray-200 rounded-2">
                                    <i class="fa-solid fa-exclamation-triangle fs-1 text-warning me-2"></i>
                                    <span>Aucun dossier de mobilité bancaire ouvert</span>
                                </div>
                            @else
                                <table class="table table-striped border gy-5 gx-5">
                                    <thead>
                                    <tr>
                                        <th>Mandat</th>
                                        <th>Banque</th>
                                        <th>Etat</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customer->mobilities()->orderBy('updated_at', 'desc')->limit(5)->get() as $mobility)
                                        <tr>
                                            <td>{{ $mobility->mandate }}</td>
                                            <td>{!! $mobility->bank->bank_symbol !!}</td>
                                            <td>{{ $mobility->status_text }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Pret bancaire</h3>
                            <div class="card-toolbar">
                                <!--<button type="button" class="btn btn-sm btn-light">
                                    Action
                                </button>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped border gy-5 gx-5">
                                <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Type de pret</th>
                                    <th>Montant accordée</th>
                                    <th>Etat</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customer->prets()->orderBy('updated_at', 'desc')->limit(5)->get() as $pret)
                                    <tr>
                                        <td>{{ $pret->reference }}</td>
                                        <td>{{ $pret->plan->name }}</td>
                                        <td>{{ eur($pret->amount_loan) }}</td>
                                        <td>{!! $pret->status_label  !!}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($customer->info->type != 'part')
        <div class="tab-pane fade" id="business_plan" role="tabpanel">
            <div class="row">
                <div class="col-md-4 col-sm-12 mb-10">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Information structurel</h3>
                            <div class="card-toolbar">
                                <!--<button type="button" class="btn btn-sm btn-light">
                                    Action
                                </button>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="fw-bolder">Société</td>
                                        <td>{{ $customer->business->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder">Forme juridique</td>
                                        <td>{{ $customer->business->forme }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder">Possible demande de financement</td>
                                        <td>{{ $customer->business->financement }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Information Prévisionnel</h3>
                            <div class="card-toolbar">
                                <!--<button type="button" class="btn btn-sm btn-light">
                                    Action
                                </button>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped border gy-5 gx-5 mb-5">
                                <thead>
                                    <tr>
                                        <th>Libellé</th>
                                        <th>Montant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Chiffre d'affaire</td>
                                        <td>
                                            <input type="text" class="form-control form-control-solid" name="ca" value="{{ $customer->business->ca }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Achat</td>
                                        <td><input type="text" class="form-control form-control-solid" name="achat" value="{{ $customer->business->achat }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Frais Généraux</td>
                                        <td><input type="text" class="form-control form-control-solid" name="frais" value="{{ $customer->business->frais }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Salaires & Charges Sociales</td>
                                        <td><input type="text" class="form-control form-control-solid" name="salaire" value="{{ $customer->business->salaire }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Impôt</td>
                                        <td><input type="text" class="form-control form-control-solid" name="impot" value="{{ $customer->business->impot }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Autre Produit</td>
                                        <td><input type="text" class="form-control form-control-solid" name="other_product" value="{{ $customer->business->other_product }}"></td>
                                    </tr>
                                    <tr class="border-bottom-3">
                                        <td>Autre Charge</td>
                                        <td><input type="text" class="form-control form-control-solid" name="other_charge" value="{{ $customer->business->other_charge }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Apport Personnel (Capital, etc...)</td>
                                        <td><input type="text" class="form-control form-control-solid" name="apport_personnel" value="{{ $customer->business->apport_personnel }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Financement existant</td>
                                        <td><input type="text" class="form-control form-control-solid" name="finance" value="{{ $customer->business->finance }}"></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="fw-bolder text-end">Résultat</td>
                                        <td>
                                            <div class="text-end fs-3 business_resultat">{{ $customer->business->result_format }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder text-end">Financement</td>
                                        <td>
                                            <div class="text-end fs-3 business_finance">{{ $customer->business->result_finance_format }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder text-end">Indicateur</td>
                                        <td>
                                            <div class="text-end fs-3 business_indicator">{!! $customer->business->indicator_format !!}</div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="modal fade" tabindex="-1" id="updateStatus">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Mise à jour du status du compte client</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formUpdateStatus" action="{{ route('agent.customer.update', $customer->id) }}"
                      method="post">
                    @csrf
                    @method("put")
                    <input type="hidden" name="control" value="status">
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="status_open_account" class="form-label">Etat du compte</label>
                            <select id="status_open_account" name="status_open_account" class="form-control"
                                    data-control="select2">
                                <option value="open" @if($customer->status_open_account == 'open') selected @endif>
                                    Ouverture en cours
                                </option>
                                <option value="completed"
                                        @if($customer->status_open_account == 'completed') selected @endif>Dossier
                                    Complet
                                </option>
                                <option value="accepted"
                                        @if($customer->status_open_account == 'accepted') selected @endif>Dossier
                                    Accepter
                                </option>
                                <option value="declined"
                                        @if($customer->status_open_account == 'declined') selected @endif>Dossier
                                    Refuser
                                </option>
                                <option value="terminated"
                                        @if($customer->status_open_account == 'terminated') selected @endif>Compte actif
                                </option>
                                <option value="suspended"
                                        @if($customer->status_open_account == 'suspended') selected @endif>Compte
                                    suspendue
                                </option>
                                <option value="closed" @if($customer->status_open_account == 'closed') selected @endif>
                                    Compte clotûrer
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="updateAccount">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Changement de type de compte</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formUpdateAccount" action="{{ route('agent.customer.update', $customer->id) }}"
                      method="post">
                    @csrf
                    @method("put")
                    <input type="hidden" name="control" value="type">
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="package_id" class="form-label">Type de compte</label>
                            <select id="package_id" name="package_id" class="form-control" data-control="select2">
                                @foreach(\App\Models\Core\Package::where('type_cpt', $customer->info->type)->get() as $package)
                                    <option value="{{ $package->id }}"
                                            @if($customer->package_id == $package->id) selected @endif>{{ $package->name }}
                                        ({{ eur($package->price) }} / par mois)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="write-sms">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Ecrire un sms</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formWriteSms" action="/api/customer/{{ $customer->id }}/write-sms"
                      method="post">
                    @csrf
                    <div class="modal-body">
                        <x-form.textarea name="message" label="Message" required="true" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="write-mail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Ecrire un Email</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formWriteMail" action="/api/customer/{{ $customer->id }}/write-mail"
                      method="post">
                    @csrf
                    <div class="modal-body">
                        <x-form.textarea name="message" label="Message" required="true" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="createWallet">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Nouveau compte bancaire</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formCreateWallet" action="/api/customer/{{ $customer->id }}/wallet"
                      method="post">
                    @csrf
                    <input type="hidden" name="action" value="compte">
                    <div class="modal-body">
                        <div class="d-flex flex-column justify-content-center text-center">
                            <i class="fa-solid fa-info-circle fs-2tx text-primary"></i>
                            <div class="fs-2">Vous allez créer un nouveau compte bancaire pour le client: {{ $customer->info->full_name }}</div>
                            <div class="fs-2">Etes-vous sur ?</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="createEpargne">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Nouveau compte épargne</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formCreateEpargne" action="/api/customer/{{ $customer->id }}/wallet"
                      method="post">
                    @csrf
                    <input type="hidden" name="action" value="epargne">
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="epargne_plan_id" class="form-label">Plan du compte</label>
                            <select class="form-select form-select-solid" id="epargne_plan_id" name="epargne_plan_id" data-dropdown-parent="#createEpargne" data-control="select2" data-allow-clear="true" data-placeholder="Selectionner un plan d'épargne" onchange="getInfoEpargnePlan(this)">
                                <option value=""></option>
                                @foreach(\App\Models\Core\EpargnePlan::all() as $epargne)
                                    <option value="{{ $epargne->id }}">{{ $epargne->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="epargne_plan_info" class="bg-gray-300">
                            <table class="table gy-5 gs-5">
                                <tbody>
                                <tr>
                                    <td class="fw-bolder">Profit par mois %</td>
                                    <td class="profit_percent text-right"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bolder">Durée de blocage des fond</td>
                                    <td class="lock_days text-right"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bolder">Conditionnement</td>
                                    <td class="profit_days text-right"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bolder">Montant initial obligatoire</td>
                                    <td class="init text-right"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bolder">Limite du compte</td>
                                    <td class="limit text-right"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-10">
                            <label for="wallet_payment_id" class="form-label">Compte de retrait</label>
                            <select class="form-select form-select-solid" id="wallet_payment_id" name="wallet_payment_id" data-dropdown-parent="#createEpargne" data-control="select2" data-allow-clear="true" data-placeholder="Selectionner un compte à débiter">
                                <option value=""></option>
                                @foreach(\App\Models\Customer\CustomerWallet::where('customer_id', $customer->id)->where('type', 'compte')->where('status', 'active')->get() as $wallet)
                                    <option value="{{ $wallet->id }}">{{ $wallet->name_account }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form.input
                            name="initial_payment"
                            type="text"
                            label="Montant Initial"
                            placeholder="Montant initial à déposer sur le compte épargne"
                            required="true" />

                        <x-form.input
                            name="monthly_payment"
                            type="text"
                            label="Montant par mois"
                            placeholder="Montant à déposer sur le compte épargne tous les mois"
                            required="true" />

                        <x-form.input
                            name="monthly_days"
                            type="text"
                            label="Jour de prélèvement" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="createPret">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Nouveau pret bancaire</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formCreatePret" action="/api/customer/{{ $customer->id }}/wallet"
                      method="post">
                    @csrf
                    <input type="hidden" name="action" value="pret">
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="loan_plan_id" class="form-label">Type de Pret</label>
                            <select class="form-select form-select-solid" id="loan_plan_id" name="loan_plan_id" data-dropdown-parent="#createPret" data-control="select2" data-allow-clear="true" data-placeholder="Selectionner un type de pret" onchange="getInfoPretPlan(this)">
                                <option value=""></option>
                                @foreach(\App\Models\Core\LoanPlan::all() as $loan)
                                    <option value="{{ $loan->id }}">{{ $loan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="pret_plan_info" class="bg-gray-300">
                            <table class="table gy-5 gs-5">
                                <tbody>
                                <tr>
                                    <td class="fw-bolder">Montant Minimum</td>
                                    <td class="min text-right"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bolder">Montant Maximum</td>
                                    <td class="max text-right"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bolder">Durée Maximal de remboursement</td>
                                    <td class="duration text-right"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bolder">Interet débiteur</td>
                                    <td class="interest text-right"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bolder">Information supplémentaire</td>
                                    <td class="instruction text-right"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-10">
                            <label for="wallet_payment_id" class="form-label">Compte de payment</label>
                            <select class="form-select form-select-solid" id="wallet_payment_id" name="wallet_payment_id" data-dropdown-parent="#createPret" data-control="select2" data-allow-clear="true" data-placeholder="Selectionner un compte à débiter">
                                <option value=""></option>
                                @foreach(\App\Models\Customer\CustomerWallet::where('customer_id', $customer->id)->where('type', 'compte')->where('status', 'active')->get() as $wallet)
                                    <option value="{{ $wallet->id }}">{{ $wallet->name_account }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form.input
                            name="amount_loan"
                            type="text"
                            label="Montant du pret"
                            required="true" />

                        <x-form.input
                            name="duration"
                            type="text"
                            label="Durée du pret (Années)"
                            required="true" />

                        <x-form.input
                            name="prlv_day"
                            type="text"
                            label="Jour de prélèvement" />

                        <div class="mb-10">
                            <label for="assurance_type" class="form-label">Type d'assurance</label>
                            <select class="form-select form-select-solid" id="assurance_type" name="assurance_type" data-dropdown-parent="#createPret" data-control="select2" data-allow-clear="true" data-placeholder="Selectionner un type d'assurance">
                                <option value=""></option>
                                <option value="D">Décès</option>
                                <option value="DIM">Décès, Invalidité, Maladie</option>
                                <option value="DIMC">Décès, Invalidité, Maladie, Travail</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="content_file">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white"></h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex flex-row justify-content-between">
                            <div class="">
                                <button class="btn btn-sm btn-circle btn-icon btn-secondary" id="previous"><i class="fa-solid fa-arrow-left me-2"></i> </button>
                                <button class="btn btn-sm btn-circle btn-icon btn-secondary" id="next"><i class="fa-solid fa-arrow-right"></i> </button>
                            </div>
                            <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                        </div>
                        <div class="d-flex flex-center scroll h-650px">
                            <canvas id="contentPdf"></canvas>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnSignate" class="btn btn-circle btn-bank"><i class="fa-solid fa-signature me-2"></i> Signer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script src="/assets/plugins/custom/jstree/jstree.bundle.js"></script>
    @include("agent.scripts.customer.show")
@endsection

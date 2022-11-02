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
            <li class="breadcrumb-item text-dark">{{ $customer->user->identifiant }} - {{ $customer->info->full_name }}</li>
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
                                <a href="#">
                                    <i class="fa-solid fa-house-circle-check fs-3 {{ $customer->info->addressVerified ? 'text-success' : 'text-secondary' }}" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" title="{{ $customer->info->addressVerified ? "Adresse Postal Vérifié" : "Adresse Postal non vérifier" }}"></i>
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
                                        <a href="#" class="menu-link px-3">Changer l'état du compte client</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">Changer le type de compte</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                                        <a href="#" class="menu-link px-3">
                                            <span class="menu-title">Nouveau compte</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Compte Bancaire</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Compte Epargne</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Pret Bancaire</a>
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
                                <span class="fw-bold fs-6">{{ $customer->cotation * 10 }}%</span>
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
            <div class="row g-5 g-xl-8">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Dernière transactions</h3>
                        </div>
                        <div class="card-body">
                            <table class="table border table-striped gx-5 gy-5">
                                <thead>
                                    <tr>
                                        <th>Libellé</th>
                                        <th>Montant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->wallets()->where('type', '!=', 'pret')->get() as $wallet)
                                        @foreach($wallet->transactions()->where('confirmed', true)->orderBy('confirmed_at')->limit(5)->get() as $transaction)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-row align-items-center">
                                                        {!! $transaction->type_symbol('20px') !!}
                                                        <span data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="right" data-bs-html="true" title="<i class='fa-solid fa-info-circle me-2'></i>Information" data-bs-content="{{ $transaction->description }}">{{ $transaction->designation }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $transaction->amount }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    <tr>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.show")
@endsection

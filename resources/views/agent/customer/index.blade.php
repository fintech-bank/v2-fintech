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
            <li class="breadcrumb-item text-dark">Client</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>-->
    </div>
@endsection

@section("content")
    @if(\Jenssegers\Agent\Facades\Agent::isDesktop())
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
							<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
						</svg>
					</span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-350px ps-15" placeholder="Rechercher..." />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
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
                                    <label class="form-label fs-5 fw-semibold mb-3">Status d'ouverture de compte:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-customer-table-filter="status" data-dropdown-parent="#kt-toolbar-filter">
                                        <option></option>
                                        <option value="open">Dossier Ouvert</option>
                                        <option value="completed">Dossier Complet</option>
                                        <option value="accepted">Dossier Accepter</option>
                                        <option value="declined">Dossier Refuser</option>
                                        <option value="terminated">Compte Ouvert</option>
                                        <option value="suspended">Compte Suspendu</option>
                                        <option value="closed">Compte Clotûrer</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-semibold mb-3">Type de client:</label>
                                    <!--end::Label-->
                                    <!--begin::Options-->
                                    <div class="d-flex flex-column flex-wrap fw-semibold" data-kt-customer-table-filter="type">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                            <input class="form-check-input" type="radio" name="type" value="all" checked="checked" />
                                            <span class="form-check-label text-gray-600">Tous</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                            <input class="form-check-input" type="radio" name="type" value="part" />
                                            <span class="form-check-label text-gray-600">Particulier</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" name="type" value="pro" />
                                            <span class="form-check-label text-gray-600">Professionnel</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" name="type" value="orga" />
                                            <span class="form-check-label text-gray-600">Organisation / Public</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" name="type" value="assoc" />
                                            <span class="form-check-label text-gray-600">Association</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Options-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Effacer</button>
                                    <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter">Appliquer</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        <!--begin::Add customer-->
                        <a  href="{{ route('agent.customer.create.start') }}" class="btn btn-primary"><i class="fa-regular fa-plus fa-lg me-2"></i> Nouveau client</a>
                        <!--end::Add customer-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Identifiant</th>
                        <th class="min-w-125px">Identité</th>
                        <th class="min-w-125px">Coordonnées</th>
                        <th class="min-w-125px">Montant Disponible</th>
                        <th class="min-w-125px text-center">Etat</th>
                        <th class="text-end min-w-70px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-semibold text-gray-600">
                    @foreach($customers as $customer)
                        <tr>
                            <!--begin::Name=-->
                            <td>
                                {{ $customer->user->identifiant }}
                            </td>
                            <!--end::Name=-->
                            <!--begin::Email=-->
                            <td data-filter="{{ $customer->info->type }}">
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="d-flex flex-row">
                                        <div class="symbol symbol-50px me-5">
                                            {!! $customer->user->avatar_symbol !!}
                                        </div>
                                        <div class="d-flex flex-column align-items-center me-10">
                                            <div class="fw-bolder">{{ $customer->user->name }}</div>
                                            {!! $customer->info->type_label !!}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        {!! $customer->info->account_verified !!}
                                    </div>
                                </div>
                            </td>
                            <!--end::Email=-->
                            <!--begin::Company=-->
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row mb-2 align-items-center">
                                        <i class="fa-solid fa-phone me-2"></i>:
                                        <span class="me-3">{{ $customer->info->phone }}</span>
                                        {!! $customer->info->phone_verified !!}
                                    </div>
                                    <div class="d-flex flex-row mb-2 align-items-center">
                                        <i class="fa-solid fa-mobile me-2"></i>:
                                        <span class="me-3">{{ $customer->info->mobile }}</span>
                                        {!! $customer->info->mobile_verified !!}
                                    </div>
                                    <div class="d-flex flex-row mb-2 align-items-center">
                                        <i class="fa-solid fa-envelope me-2"></i>:
                                        <span class="me-3">{{ $customer->user->email }}</span>
                                        {!! $customer->user->email_verified !!}
                                    </div>
                                </div>
                            </td>
                            <!--end::Company=-->
                            <!--begin::Payment method=-->
                            <td>
                                <div class="d-flex flex-row justify-content-between">
                                    <strong>Compte bancaire:</strong>
                                    @if($customer->sum_account >= 0)
                                        <span class="text-success">+ {{ eur($customer->sum_account) }}</span>
                                    @else
                                        <span class="text-danger">{{ eur($customer->sum_account) }}</span>
                                    @endif
                                </div>

                                <div class="d-flex flex-row justify-content-between">
                                    <strong>Compte épargne:</strong>
                                    @if($customer->sum_epargne >= 0)
                                        <span class="text-success">+ {{ eur($customer->sum_epargne) }}</span>
                                    @else
                                        <span class="text-danger">{{ eur($customer->sum_epargne) }}</span>
                                    @endif
                                </div>
                            </td>
                            <!--end::Payment method=-->
                            <!--begin::Date=-->
                            <td class="text-center">{!! $customer->status_label !!}</td>
                            <!--end::Date=-->
                            <!--begin::Action=-->
                            <td class="text-end">
                                <a href="{{ route('agent.customer.show', $customer->id) }}" class="btn btn-sm btn-primary">Fiche client</a>
                            </td>
                            <!--end::Action=-->
                        </tr>
                    @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
    @else
        @foreach($customers as $customer)
            <div class="card shadow-sm mb-10">
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center">
                        <div class="symbol symbol-50px symbol-circle">
                            {!! $customer->user->avatar_symbol !!}
                        </div>
                        <div class="d-flex flex-column">
                            <div class="fw-bolder">{{ $customer->info->full_name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@section("script")
    @include("agent.scripts.customer.index")
@endsection

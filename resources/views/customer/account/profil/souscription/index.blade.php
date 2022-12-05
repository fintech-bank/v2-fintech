@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Pack {{ $customer->package->name }}</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid {{ $customer->package->icon }} text-{{ $customer->package->color }} me-3"></i> {{ $customer->package->name }}</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#UpdateSubscription">
                        Mettre à jour
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between">
                    <strong>Tarif</strong>
                    {{ $customer->package->price_format }} / par mois
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Type de Prélèvement</strong>
                    {{ $customer->package->type_prlv_text }}
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Carte Bancaire Visa Classic</strong>
                    @if($customer->package->visa_classic)
                        <i class="fa-regular fa-circle-check fs-1 text-success"></i>
                    @else
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Dépot de chèque</strong>
                    @if($customer->package->check_deposit)
                        <i class="fa-regular fa-circle-check fs-1 text-success"></i>
                    @else
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Paiement & Retrait par carte bancaire</strong>
                    @if($customer->package->payment_withdraw)
                        <i class="fa-regular fa-circle-check fs-1 text-success"></i>
                    @else
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Découvert bancaire</strong>
                    @if($customer->package->overdraft)
                        <i class="fa-regular fa-circle-check fs-1 text-success"></i>
                    @else
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Paiement à l'internationnal</strong>
                    @if($customer->package->payment_international)
                        <i class="fa-regular fa-circle-check fs-1 text-success"></i>
                    @else
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Retrait à l'internationnal</strong>
                    @if($customer->package->withdraw_international)
                        <i class="fa-regular fa-circle-check fs-1 text-success"></i>
                    @else
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Assurance sur les moyens de paiements</strong>
                    @if($customer->package->payment_insurance)
                        <i class="fa-regular fa-circle-check fs-1 text-success"></i>
                    @else
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Mise à disposition de chèque bancaire</strong>
                    @if($customer->package->check)
                        <i class="fa-regular fa-circle-check fs-1 text-success"></i>
                    @else
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Service cashback</strong>
                    @if($customer->package->cashback)
                        <i class="fa-regular fa-circle-check fs-1 text-success"></i>
                    @else
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Service Paystar</strong>
                    @if($customer->package->paystar)
                        <i class="fa-regular fa-circle-check fs-1 text-success"></i>
                    @else
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Nombre de carte physique</strong>
                    @if($wallet->cards()->where('type', 'physique')->count() <= $customer->package->nb_carte_physique)
                        <span class="badge badge-success">{{ $wallet->cards()->where('type', 'physique')->count() }} / {{ $customer->package->nb_carte_physique }}</span>
                    @else
                        <span class="badge badge-danger">{{ $wallet->cards()->where('type', 'physique')->count() }} / {{ $customer->package->nb_carte_physique }}</span>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Nombre de carte virtuel</strong>
                    @if($wallet->cards()->where('type', 'virtuel')->count() <= $customer->package->nb_carte_virtuel)
                        <span class="badge badge-success">{{ $wallet->cards()->where('type', 'virtuel')->count() }} / {{ $customer->package->nb_carte_virtuel }}</span>
                    @else
                        <span class="badge badge-danger">{{ $wallet->cards()->where('type', 'virtuel')->count() }} / {{ $customer->package->nb_carte_virtuel }}</span>
                    @endif
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-row justify-content-between">
                    <strong>Sous Compte</strong>
                    @if($customer->package->subaccount == 0)
                        <i class="fa-regular fa-circle-xmark fs-1 text-danger"></i>
                    @elseif($customer->wallets()->where('type', 'compte')->count()-1 <= $customer->package->subaccount)
                        <span class="badge badge-success">{{ $customer->wallets()->where('type', 'compte')->count()-1 }} / {{ $customer->package->subaccount }}</span>
                    @else
                        <span class="badge badge-danger">{{ $customer->wallets()->where('type', 'compte')->count()-1 }} / {{ $customer->package->subaccount }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="UpdateSubscription">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Mise à jour de la souscription</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formUpdateSubscription" action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row mt-10">
                            <!--begin::Col-->
                            <div class="col-lg-6 mb-10 mb-lg-0">
                                <!--begin::Tabs-->
                                <div class="nav flex-column" role="tablist">
                                    @foreach(\App\Models\Core\Package::where('type_cpt', $customer->info->type)->get() as $package)
                                        <label class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6 {{ $package->id == $customer->package->id ? 'active' : '' }}" data-bs-toggle="tab" data-bs_target="#package_{{ Str::slug($package->name) }}" role="tab">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
                                                    <input class="form-check-input" type="radio" name="package_id" @if($customer->package->id == $package->id) checked="checked" @endif value="{{ $package->id }}">
                                                </div>
                                                <!--end::Radio-->
                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center fs-2 fw-bold flex-wrap">{{ $package->name }}</div>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Description-->
                                            <!--begin::Price-->
                                            <div class="ms-5">
                                                <span class="mb-2">€</span>
                                                <span class="fs-3x fw-bold" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">{{ $package->price }}</span>
                                                <span class="fs-7 opacity-50">/
												<span data-kt-element="period">Par mois</span></span>
                                            </div>
                                            <!--end::Price-->
                                        </label>
                                    @endforeach
                                </div>
                                <!--end::Tabs-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <!--begin::Tab content-->
                                <div class="tab-content rounded h-100 bg-light p-10">
                                    @foreach(\App\Models\Core\Package::where('type_cpt', $customer->info->type)->get() as $package)
                                        <div class="tab-pane fade {{ $package->id == $customer->package->id ? 'show active' : '' }}" id="package_{{ Str::slug($package->name) }}" role="tabpanel">
                                            <div class="pb-5">
                                                <h2 class="fw-bold text-dark">What’s in Startup Plan?</h2>
                                                <div class="text-muted fw-semibold">Optimal for 10+ team size and new startup</div>
                                            </div>
                                            <!--begin::Body-->
                                            <div class="pt-1">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-7">
                                                    <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 10 Active Users</span>
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                                                    <span class="svg-icon svg-icon-1 svg-icon-success">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
															<path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor"></path>
														</svg>
													</span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-7">
                                                    <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 30 Project Integrations</span>
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                                                    <span class="svg-icon svg-icon-1 svg-icon-success">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
															<path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor"></path>
														</svg>
													</span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-7">
                                                    <span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics Module</span>
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                                                    <span class="svg-icon svg-icon-1 svg-icon-success">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
															<path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor"></path>
														</svg>
													</span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-7">
                                                    <span class="fw-semibold fs-5 text-muted flex-grow-1">Finance Module</span>
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen040.svg-->
                                                    <span class="svg-icon svg-icon-1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
															<rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"></rect>
															<rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"></rect>
														</svg>
													</span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-7">
                                                    <span class="fw-semibold fs-5 text-muted flex-grow-1">Accounting Module</span>
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen040.svg-->
                                                    <span class="svg-icon svg-icon-1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
															<rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"></rect>
															<rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"></rect>
														</svg>
													</span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-7">
                                                    <span class="fw-semibold fs-5 text-muted flex-grow-1">Network Platform</span>
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen040.svg-->
                                                    <span class="svg-icon svg-icon-1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
															<rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"></rect>
															<rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"></rect>
														</svg>
													</span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-semibold fs-5 text-muted flex-grow-1">Unlimited Cloud Space</span>
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen040.svg-->
                                                    <span class="svg-icon svg-icon-1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
															<rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"></rect>
															<rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"></rect>
														</svg>
													</span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                    @endforeach
                                </div>
                                <!--end::Tab content-->
                            </div>
                            <!--end::Col-->
                        </div>
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
    @include("customer.scripts.account.profil.paystar")
@endsection

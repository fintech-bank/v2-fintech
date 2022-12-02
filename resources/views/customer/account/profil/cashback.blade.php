@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Cashback {{ config('app.name') }}</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <p>Vous allez être rediriger vers le service Cashback By {{ config('app.name') }}, ce site regroupe tous avantages que {{ config('app.name') }} vous offre sur plusieurs magasins et marques en france.</p>
        <p>En accédant à ce service, vous autorisez {{ config('app.name') }} à transmettre certaine donnée personnelle au service Cashback By {{ config('app.name') }}.</p>
        <div class="d-flex flex-center flex-row justify-content-center">
            <button class="btn btn-circle btn-outline btn-outline-primary" data-bs-toggle="modal" data-bs-target="#RegisterCashback">J'accepte</button>
            <a href="{{ route('customer.account.profil.index') }}" class="btn btn-circle btn-outline btn-outline-dark">Annuler</a>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="RegisterCashback">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Création de votre compte Cashback By Fintech</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formRegisterCashback" action="/api/customer/{{ $customer->id }}/subscribe/cashback" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <x-form.input
                            type="email"
                            name="email"
                            label="Adresse Mail"
                            required="true" />

                        <div class="fv-row" data-kt-password-meter="true">
                            <!--begin::Wrapper-->
                            <div class="mb-1">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold fs-6 mb-2 required">
                                    Mot de passe
                                </label>
                                <!--end::Label-->

                                <!--begin::Input wrapper-->
                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-lg form-control-solid"
                                           type="password" placeholder="" name="password" autocomplete="off" />

                                    <!--begin::Visibility toggle-->
                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                          data-kt-password-meter-control="visibility">
                                        <i class="bi bi-eye-slash fs-2"></i>

                                        <i class="bi bi-eye fs-2 d-none"></i>
                                    </span>
                                    <!--end::Visibility toggle-->
                                </div>
                                <!--end::Input wrapper-->

                                <!--begin::Highlight meter-->
                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                </div>
                                <!--end::Highlight meter-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Hint-->
                            <div class="text-muted">
                                Utilisez 8 caractères ou plus avec un mélange de lettres, de chiffres et de symboles.
                            </div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Main wrapper-->

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
    @include("customer.scripts.account.profil.cashback")
@endsection

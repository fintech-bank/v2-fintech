@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Sécurité</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="text-center mb-10">
            <div class="fs-2tx uppercase">Profil de {{ $customer->info->full_name }}</div>
            <div class="fs-1">Gérez ici vos moyens de sécurité : code secret, numéro de téléphone sécurité et Pass Sécurité.</div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="fw-bolder fs-1 mb-3">Numéro de téléphone de sécurité</div>
                        <div class="d-flex flex-row border border-gray-300 p-8 align-items-center mb-5">
                            @if($customer->info->mobileVerified)
                                <i class="fa-regular fa-check-circle text-success fs-2tx me-5"></i>
                                <div class="d-flex flex-column">
                                    <span>Votre numéro de téléphone de sécurité est le:</span>
                                    <div class="fw-bolder fs-1">{{ $customer->info->getMobileNumber('obscure') }}</div>
                                </div>
                            @else
                                <i class="fa-regular fa-xmark-circle text-danger fs-2tx me-5"></i>
                                <div class="d-flex flex-column">
                                    <span>Votre numéro de téléphone de sécurité est le:</span>
                                    <div class="fw-bolder fs-1">Aucun numéro de téléphone définie</div>
                                </div>
                            @endif
                        </div>
                        <p>
                            Vous avez changé de numéro de téléphone ?<br>
                            Pensez à le modifier.
                        </p>
                        <button class="btn btn-circle btn-outline btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editMobile">Modifier le téléphone</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="fw-bolder fs-1 mb-3">Pass Sécurité</div>
                        <div class="d-flex flex-row border border-gray-300 p-8 align-items-center mb-5">
                            @if($customer->setting->securpass)
                                <i class="fa-regular fa-check-circle text-success fs-2tx me-5"></i>
                                <div class="d-flex flex-column">
                                    <span>Vous disposez du Pass Sécurité suivant:</span>
                                    <div class="fw-bolder fs-1">{{ $customer->setting->securpass_model }}</div>
                                </div>
                            @else
                                <i class="fa-regular fa-xmark-circle text-danger fs-2tx me-5"></i>
                                <div class="d-flex flex-column">
                                    <span>Vous disposez du Pass Sécurité suivant:</span>
                                    <div class="fw-bolder fs-1">Aucun Pass Sécurité définie</div>
                                </div>
                            @endif
                        </div>
                        <p>
                            En cas de perte ou de vol de votre smartphone, désactivez votre Pass Sécurité.
                        </p>
                        @if(Agent::isMobile())
                            @if($customer->setting->securpass)
                                <x-base.button
                                    class="btn-circle btn-outline btn-outline-danger btnLogoutPass"
                                    text="Désactiver" />
                            @else
                                <x-base.button
                                    class="btn-circle btn-outline btn-outline-success btnLoginPass"
                                    text="Activer"
                                    :datas="[['name' => 'agent', 'value' => Agent::device().'-'.Agent::platform().'-'.Agent::version(Agent::platform()).'-'.gethostname()]]" />

                            @endif
                        @else
                            <div class="d-flex flex-row bg-light-danger border border-danger p-5 rounded rounded-2">
                                <i class="fa-solid fa-xmark-circle fs-1 text-danger me-5"></i>
                                Uniquement sur Téléphone
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="fw-bolder fs-1 mb-3">Code secret</div>
                <p>Pour maintenir la sécurité de votre accès, nous vous invitons à modifier régulièrement votre code secret de banque à distance.</p>
                <button class="btn btn-circle btn-outline btn-outline-dark" data-bs-toggle="modal" data-bs-target="#EditPassword">Modifier le code</button>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="editMobile">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Modifier mon numéro de téléphone de sécurité</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="/api/user/verify/phone" class="stepper stepper-pills" id="stepper_edit_mobile">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="verify" value="phone">
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <div class="stepper-nav flex-center flex-wrap mb-10">
                            <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">1</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Saisie
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">2</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Vérification
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                        </div>

                        <div class="flex-column current" data-kt-stepper-element="content">
                            <x-form.input-mask
                                name="mobile"
                                label="Numéro de téléphone"
                                mask="+33999999999"
                                required="true" />
                        </div>
                        <div class="flex-column" data-kt-stepper-element="content">
                            <p class="helpEditMobileCode"></p>
                            <x-form.input
                                name="code"
                                label="Code de vérification reçu par sms"
                                required="true" />
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="d-flex flex-stack">
                            <!--begin::Wrapper-->
                            <div class="me-2">
                                <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                    Retour
                                </button>
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Wrapper-->
                            <div>
                                <button type="submit" class="btn btn-success" data-kt-stepper-action="submit">
                                    <span class="indicator-label">
                                        Valider
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>

                                <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                    Suivant
                                </button>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="EditPassword">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Changer le code secret</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formEditPassword" action="/api/user/verify/password" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="verify" value="updatePass">
                        <x-form.input
                            name="password"
                            label="Ancien mot de passe"
                            required="true"
                            type="password" />

                        <div class="fv-row mb-10" data-kt-password-meter="true">
                            <!--begin::Wrapper-->
                            <div class="mb-1">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold fs-6 mb-2 required">
                                    Nouveau mot de passe
                                </label>
                                <!--end::Label-->

                                <!--begin::Input wrapper-->
                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-lg form-control-solid"
                                           type="password" placeholder="" name="new_password" autocomplete="off" required/>

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

                        <x-form.input
                            name="new_password_confirm"
                            label="Confirmation du mot de passe"
                            required="true"
                            type="password" />
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
    @include("customer.scripts.account.profil.security.index")
@endsection

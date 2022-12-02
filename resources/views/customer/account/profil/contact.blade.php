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
        <x-base.underline
            title="Profil de {{ $customer->info->full_name }}"
            size="4"
            size-text="fs-2hx"
            color="bank"
            class="w-100 my-5 uppercase" />


        <x-base.underline
            title="Adresse e-mail"
            size="4"
            size-text="fs-1"
            color="secondary"
            class="w-100 my-5" />

        <p class="fw-bolder">Pour mieux vous accompagner au quotidien comme dans vos projets d’avenir, nous souhaitons recueillir votre adresse e-mail. Vous serez ainsi informé de nos actualités et de nos offres promotionnelles susceptibles de vous intéresser.</p>
        <div class="d-flex flex-row justify-content-around mb-10">
            <div class="">Adresse e-mail personnel</div>
            <div class="">{{ $customer->user->email }} {!! $customer->user->email_verified !!}</div>
        </div>
        <div class="d-flex flex-center justify-content-center w-50 mx-auto">
            <div class="alert bg-light-primary d-flex align-items-center p-5 mb-10">
                <i class="fa-solid fa-info-circle fs-2hx text-white me-4"></i>
                <div class="d-flex flex-column text-white">
                    <span>Une adresse e-mail à jour est nécessaire pour s’assurer de recevoir toutes nos communications. Nous vous invitons donc à la renseigner ou la modifier si nécessaire.</span>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap justify-content-end">
            <button class="btn btn-circle btn-lg btn-secondary" data-bs-toggle="modal" data-bs-target="#EditMail">Modifier</button>
        </div>
        <div class="separator separator-dashed border-gray-300 my-5"></div>
        <x-base.underline
            title="Téléphones"
            size="4"
            size-text="fs-1"
            color="secondary"
            class="w-100 mb-5" />

        <div class="d-flex flex-row justify-content-around mb-10">
            <div class="">Téléphone Sécurisé <i class="fa-solid fa-lock ms-3"></i></div>
            <div class="">{{ $customer->info->mobile }} {!! $customer->info->mobile_verify !!}</div>
        </div>
        <div class="d-flex flex-wrap justify-content-end mb-5">
            <a href="{{ route('customer.account.profil.security.index') }}" class="btn btn-circle btn-lg btn-secondary">Modifier</a>
        </div>

        <div class="d-flex flex-row justify-content-around">
            <div class="">Mobile</div>
            <div class="">{{ $customer->info->mobile }} {!! $customer->info->mobile_verify !!}</div>
        </div>
        <div class="my-3"></div>
        <div class="d-flex flex-row justify-content-around">
            <div class="">Domicile</div>
            <div class="">{{ $customer->info->phone }} {!! $customer->info->phone_verify !!}</div>
        </div>
        <div class="d-flex flex-wrap justify-content-end">
            <button class="btn btn-circle btn-lg btn-secondary" data-bs-toggle="modal" data-bs-target="#EditPhone">Modifier</button>
        </div>
        <div class="separator separator-dashed border-gray-300 my-5"></div>
        <x-base.underline
            title="Adresse {!! $customer->info->address_verify !!}"
            size="4"
            size-text="fs-1"
            color="secondary"
            class="w-100 mb-5" />

        <div class="d-flex flex-row">
            <div class="w-50">N° et Voie</div>
            <div class="w-50">{{ $customer->info->address }}</div>
        </div>
        <div class="my-3"></div>
        <div class="d-flex flex-row">
            <div class="w-50">Complément</div>
            <div class="">{{ $customer->info->addressbis }}</div>
        </div>
        <div class="my-3"></div>
        <div class="d-flex flex-row">
            <div class="w-50">Code Postal</div>
            <div class="">{{ $customer->info->postal }}</div>
        </div>
        <div class="my-3"></div>
        <div class="d-flex flex-row">
            <div class="w-50">Ville</div>
            <div class="">{{ $customer->info->city }}</div>
        </div>
        <div class="my-3"></div>
        <div class="d-flex flex-row">
            <div class="w-50">Pays</div>
            <div class="">{{ $customer->info->country }}</div>
        </div>
        <div class="d-flex flex-wrap justify-content-end">
            <button class="btn btn-circle btn-lg btn-secondary me-3" data-bs-toggle="modal" data-bs-target="#EditAddress">Modifier</button>
            @if(!$customer->info->addressVerified)
                <button class="btn btn-circle btn-lg btn-outline btn-outline-info">Vérifier mon adresse</button>
            @endif
        </div>
    </div>
    <div class="modal fade" id="EditMail" data-bs-focus="false">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Modifier mon adresse mail</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formEditMail" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="action" value="mail">
                        <x-form.input
                            type="email"
                            name="email"
                            label="Nouvelle adresse Mail"
                            required="true"
                            value="{{ $customer->user->email }}" />
                    </div>
                    <div class="modal-footer text-end">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EditPhone" data-bs-focus="false">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Modifier mes coordonnées Téléphonique</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formEditPhone" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="action" value="phone">

                        <x-form.input
                            name="phone"
                            label="Domicile"
                            required="true"
                            value="{{ $customer->info->phone }}" />

                        <x-form.input
                            name="mobile"
                            label="Portable"
                            required="true"
                            value="{{ $customer->info->mobile }}" />

                    </div>
                    <div class="modal-footer text-end">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EditAddress" data-bs-focus="false">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Modifier mon adresse postal</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formEditAddress" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="action" value="address">

                        <x-form.input
                            name="address"
                            label="N° et voie"
                            value="{{ $customer->info->address }}"
                            required="true" />

                        <x-form.input
                            name="addressbis"
                            label="Complément d'adresse"
                            value="{{ $customer->info->addressbis }}"
                            required="true" />

                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <x-form.input
                                    name="postal"
                                    label="Code postal"
                                    value="{{ $customer->info->postal }}"
                                    required="true" />
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <x-form.input
                                    name="city"
                                    label="Ville"
                                    value="{{ $customer->info->city }}"
                                    required="true" />
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-10">
                                    <label for="country" class="form-label required">Pays</label>
                                    <select class="form-control form-control-solid selectpicker" name="country">
                                        <option value="{{ $customer->info->country }}">{{ \App\Helper\CountryHelper::getCountryName($customer->info->country) }}</option>
                                        @foreach(\App\Helper\CountryHelper::getAll() as $country)
                                            <option value="{{ $country->cca2 }}">{{ $country->name->official }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
    @include("customer.scripts.account.profil.contact")
@endsection

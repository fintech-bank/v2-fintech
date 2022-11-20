@extends("agent.layouts.app")

@section("css")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
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
                <a href="{{ route('agent.customer.show', $wallet->customer->id) }}"
                   class="text-muted text-hover-primary">{{ $wallet->customer->user->identifiant }} - {{ $wallet->customer->info->full_name }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">{{ $wallet->type_text }} - N°{{ $wallet->loan->reference }}</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>-->
    </div>
@endsection

@section("content")
    <form action="{{ route('agent.customer.wallet.caution.post', $wallet->number_account) }}" method="post" enctype="multipart/form-data">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Ajout d'une caution au {{ $wallet->name_account_generic }}</h3>
                <div class="card-toolbar">
                    <!--<button type="button" class="btn btn-sm btn-light">
                        Action
                    </button>-->
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <x-form.select
                            name="type_caution"
                            :datas="\App\Models\Customer\CustomerPretCaution::getTypeCautionData()"
                            label="Type de caution"
                            required="true" />
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <x-form.select
                            name="type"
                            :datas="\App\Models\Customer\CustomerPretCaution::getTypeData()"
                            label="Type de personne"
                            required="true" />
                    </div>
                </div>
                <div id="physique">
                    <x-base.underline
                        title="Information sur la personne physique"
                        class="w-500px mt-5 mb-5"
                        size-text="fs-1"
                        size="3"
                        color="bank" />

                    <div class="row align-items-center">
                        <div class="col-md-3 col-sm-12">
                            <x-form.select
                                name="civility"
                                :datas="\App\Models\Customer\CustomerPretCaution::getCivilityData()"
                                label="Civilité" />
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <x-form.input
                                label="Nom de famille"
                                name="firstname" />
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <x-form.input
                                label="Prénom"
                                name="lastname" />
                        </div>
                        <div class="col-md-1 col-sm-2">
                            <x-form.checkbox
                                name="ficap"
                                value="1"
                                label="Accès FICAP" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <x-form.input-group
                                name="cni_number"
                                label="Numéro de carte d'identité"
                                symbol="<i class='fa-solid fa-id-card'></i>"
                                placement="left" />
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <x-form.input-date
                                name="date_naissance"
                                label="Date de naissance"
                                type="text" />

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12 selectCountry">
                            <div class="mb-10">
                                <label for="country_naissance" class="form-label">Pays de naissance</label>
                                <select id="country_naissance" name="country_naissance" class="form-control form-control-solid selectpicker" data-live-search="true" data-placeholder="Selectionner un pays de naissance">
                                    <option value=""></option>
                                    @foreach(\App\Helper\CountryHelper::getAll() as $country)
                                        <option value="{{ $country->name->common }}" data-content="<div class='d-flex flex-row'><div class='symbol symbol-20px'><img src='{{ $country->flags->png }}' alt=''/></div> {{ $country->name->common }}</div>">{{ $country->name->common }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 selectDep">
                            <div class="mb-10">
                                <label for="dep_naissance" class="form-label">Pays de naissance</label>
                                <select id="dep_naissance" name="dep_naissance" class="form-control form-control-solid" data-placeholder="Selectionner un département de naissance" onchange="stateBirthByCountry(this)">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 selectCity">
                            <div class="mb-10">
                                <label for="city_naissance" class="form-label">Ville de naissance</label>
                                <select id="city_naissance" name="city_naissance" data-live-search="true" class="form-control form-control-solid selectpicker" data-placeholder="Selectionner une ville de naissance">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="moral"></div>
            </div>
        </div>
    </form>
@endsection

@section("script")
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
    @include("agent.scripts.customer.wallet.caution")
@endsection

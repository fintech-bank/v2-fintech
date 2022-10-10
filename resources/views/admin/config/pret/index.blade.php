@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Type de prêt</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-muted text-hover-primary">Administration</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href=""
                   class="text-muted text-hover-primary">Configuration</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Type de prêt</li>
        </ul>
    </div>
    <!--<div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
    </div>-->
@endsection

@section("content")
<div class="card card-flush shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Liste des type de prêt</h3>
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#AddPret">
                <i class="fa-solid fa-plus me-2"></i> Nouveau type de pret
            </button>
        </div>
    </div>
    <div class="card-body py-5">
        <div class="d-flex align-items-center position-relative my-1">
            <i class="fa-solid fa-search fa-lg position-absolute ms-4"></i>
            <input type="text" data-kt-pret-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..." />
        </div>
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_pret_table" aria-describedby="Liste des banque">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px" scope="col">Designation</th>
                <th class="min-w-75px" scope="col"></th>
            </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
            @foreach($prets as $plan)
                <tr>
                    <td class="w-250px">{{ $plan->name }}</td>
                    <td>
                        <button class="btn btn-circle btn-icon btn-light btnShow" data-pret="{{ $plan->id }}"><i class="fa-solid fa-eye" data-pret="{{ $plan->id }}"></i> </button>
                        <button class="btn btn-circle btn-icon btn-primary btnEdit" data-pret="{{ $plan->id }}"><i class="fa-solid fa-edit" data-pret="{{ $plan->id }}"></i> </button>
                        <button class="btn btn-circle btn-icon btn-danger btnDelete" data-pret="{{ $plan->id }}"><i class="fa-solid fa-trash" data-pret="{{ $plan->id }}"></i> </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
    <div class="modal fade" tabindex="-1" id="ShowPret">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white" data-content="title"></h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="d-flex flex-column border-bottom border-gray-600 pb-5 my-5">
                        <div class="fw-bolder fs-3">Plafond</div>
                        <div class="d-flex flex-column fs-4">
                            <strong>Minimum:</strong> <span data-content="minimum"></span>
                            <strong>Maximum:</strong> <span data-content="maximum"></span>
                        </div>
                    </div>
                    <div class="d-flex flex-column border-bottom border-gray-600 pb-5 my-5">
                        <div class="fw-bolder fs-3">Durée du pret maximum</div>
                        <div class="d-flex flex-column fs-4">
                            <span data-content="duration"></span>
                        </div>
                    </div>
                    <div class="d-flex flex-column border-bottom border-gray-600 pb-5 my-5">
                        <span class="mb-2" data-content="report_echeance"></span>
                        <span class="mb-2" data-content="adapt_mensuality"></span>
                        <span class="mb-2" data-content="online_subscription"></span>
                    </div>
                    <div class="d-flex flex-column border-bottom border-gray-600 pb-5 my-5">
                        <div class="">
                            <strong>Nombre de report d'échéance max:</strong> <span data-content="report_echeance_max"></span>
                        </div>
                        <div class="">
                            <strong>Adaptabilité des mensualité :</strong> <span data-content="adapt_mensuality_month"></span>
                        </div>
                    </div>
                    <div class="d-flex flex-column border-bottom border-gray-600 pb-5 my-5">
                        <div class="">
                            <strong>Type de Taux:</strong> <span data-content="type_taux"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="AddPret">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Ajout d'un type de pret</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formAddPret" action="{{ route('admin.config.pret.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            type="text"
                            name="name"
                            label="Nom du Type de prêt"
                            required="true"
                            value="{{ old('name') }}" />

                        <div class="mb-10">
                            <label for="type_pret" class="form-label required">Type de pret</label>
                            <select name="type_pret" id="type_pret" class="form-control" data-control="select2" data-parent="#AddPret">
                                <option value="particulier">Particulier</option>
                                <option value="professionnel">Professionnel</option>
                                <option value="authority">Gouvernement / Public</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <x-form.input-group
                                    name="minimum"
                                    label="Montant Minimum"
                                    symbol="€"
                                    placement="right"
                                    required="true" />
                            </div>
                            <div class="col-4">
                                <x-form.input-group
                                    name="maximum"
                                    label="Montant Maximum"
                                    symbol="€"
                                    placement="right"
                                    required="true" />
                            </div>
                            <div class="col-4">
                                <x-form.input-group
                                    name="duration"
                                    label="Durée Maximal"
                                    symbol="mois"
                                    placement="right"
                                    required="true" />
                            </div>
                        </div>

                        <x-form.textarea
                            name="instruction"
                            label="Information supplémentaire" />

                        <x-base.underline
                            title="Avantage" />

                        <x-form.checkbox
                            name="adapt_mensuality"
                            value="1"
                            label="Adapter les mensualités" />

                        <x-form.checkbox
                            name="report_echeance"
                            value="1"
                            label="Report d'échéance" />

                        <x-form.checkbox
                            name="online_subscription"
                            value="1"
                            label="Souscription en ligne" />

                        <x-base.underline
                            title="Condition" />

                        <div class="row">
                            <div class="col">
                                <x-form.input-group
                                    name="adapt_mensuality_month"
                                    label="A partir de combien de mois ?"
                                    symbol="mois"
                                    placement="right"
                                    text="A Partir de combien de mois, la possibilité d'adapter mensualité"/>
                            </div>
                            <div class="col">
                                <x-form.input-group
                                    name="report_echeance_max"
                                    label="Nombre maximum de report"
                                    symbol="fois"
                                    placement="right"
                                    text="Nombre maximum de report d'échéance" />
                            </div>
                        </div>

                        <x-base.underline
                            title="Tarifications" />

                        <div class="mb-10">
                            <label for="type_taux" class="form-label">Type de taux</label>
                            <select id="type_taux" name="type_taux" class="form-control" data-control="select2" data-parent="#AddPret" data-placeholder="Selectionner le type de taux" onchange="selectTypeTaux(this)">
                                <option value=""></option>
                                <option value="fixe">Taux Fixe</option>
                                <option value="variable">Taux Variable</option>
                            </select>
                        </div>

                        <div id="tauxFixe">
                            <x-form.input-group
                                name="interest"
                                label="Taux d'interet"
                                symbol="%"
                                placement="right" />
                        </div>

                        <div id="tauxVariable">
                            <div class="row">
                                <div class="col">
                                    <x-form.input-group
                                        name="min_interest"
                                        label="Taux d'interet minimum"
                                        symbol="%"
                                        placement="right" />
                                </div>
                                <div class="col">
                                    <x-form.input-group
                                        name="max_interest"
                                        label="Taux d'interet maximum"
                                        symbol="%"
                                        placement="right" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="EditPret">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Edition d'un type de pret</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formEditPret" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            type="text"
                            name="name"
                            label="Nom du Type de prêt"
                            required="true"
                            value="{{ old('name') }}" />

                        <div class="mb-10">
                            <label for="type_pret" class="form-label required">Type de pret</label>
                            <select name="type_pret" id="type_pret" class="form-control" data-control="select2" data-parent="#EditPret">
                                <option value="particulier">Particulier</option>
                                <option value="professionnel">Professionnel</option>
                                <option value="authority">Gouvernement / Public</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <x-form.input-group
                                    name="minimum"
                                    label="Montant Minimum"
                                    symbol="€"
                                    placement="right"
                                    required="true" />
                            </div>
                            <div class="col-4">
                                <x-form.input-group
                                    name="maximum"
                                    label="Montant Maximum"
                                    symbol="€"
                                    placement="right"
                                    required="true" />
                            </div>
                            <div class="col-4">
                                <x-form.input-group
                                    name="duration"
                                    label="Durée Maximal"
                                    symbol="mois"
                                    placement="right"
                                    required="true" />
                            </div>
                        </div>

                        <x-form.textarea
                            name="instruction"
                            label="Information supplémentaire" />

                        <x-base.underline
                            title="Avantage" />

                        <x-form.checkbox
                            name="adapt_mensuality"
                            value="1"
                            label="Adapter les mensualités" />

                        <x-form.checkbox
                            name="report_echeance"
                            value="1"
                            label="Report d'échéance" />

                        <x-form.checkbox
                            name="online_subscription"
                            value="1"
                            label="Souscription en ligne" />

                        <x-base.underline
                            title="Condition" />

                        <div class="row">
                            <div class="col">
                                <x-form.input-group
                                    name="adapt_mensuality_month"
                                    label="A partir de combien de mois ?"
                                    symbol="mois"
                                    placement="right"
                                    text="A Partir de combien de mois, la possibilité d'adapter mensualité"/>
                            </div>
                            <div class="col">
                                <x-form.input-group
                                    name="report_echance_max"
                                    label="Nombre maximum de report"
                                    symbol="fois"
                                    placement="right"
                                    text="Nombre maximum de report d'échéance" />
                            </div>
                        </div>

                        <x-base.underline
                            title="Tarifications" />

                        <div class="mb-10">
                            <label for="type_taux" class="form-label">Type de taux</label>
                            <select id="type_taux" name="type_taux" class="form-control" data-control="select2" data-parent="#AddPret" data-placeholder="Selectionner le type de taux" onchange="selectTypeTaux(this)">
                                <option value=""></option>
                                <option value="fixe">Taux Fixe</option>
                                <option value="variable">Taux Variable</option>
                            </select>
                        </div>

                        <div id="tauxFixe">
                            <x-form.input-group
                                name="interest"
                                label="Taux d'interet"
                                symbol="%"
                                placement="right" />
                        </div>

                        <div id="tauxVariable">
                            <div class="row">
                                <div class="col">
                                    <x-form.input-group
                                        name="min_interest"
                                        label="Taux d'interet minimum"
                                        symbol="%"
                                        placement="right" />
                                </div>
                                <div class="col">
                                    <x-form.input-group
                                        name="max_interest"
                                        label="Taux d'interet maximum"
                                        symbol="%"
                                        placement="right" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("admin.scripts.config.pret.index")
@endsection

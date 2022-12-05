@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Transfert Agence simple</h1>
        <!--end::Title-->
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--begin::Secondary button-->
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#addTransferAgency">Nouvelle demande de transfert</a>
        <!--end::Secondary button-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        @if($customer->transfer)
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-spinner fa-spin-pulse fs-2 text-warning me-2"></i> Transfert d'agence en cours...</h3>
                    <div class="card-toolbar">
                        @if($customer->transfer->status == 'waiting')
                            <button class="btn btn-danger btn-sm"><i class="fa-solid fa-ban text-white me-3"></i> Annuler la demande de transfert</button>
                        @endif
                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        @endif
    </div>
    <div class="modal fade" tabindex="-1" id="AddTransferAgency">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Transfert Agence simple</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formAddTransferAgency" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <p class="fw-bolder">Dans le cas de prestations en compte-joint, la signature des deux titulaires est obligatoire ainsi que la copie des deux pièces d'identité.</p>
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td class="fw-bolder">Civilité</td>
                                    <td>{{ $customer->info->civility }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bolder">Nom</td>
                                    <td>{{ $customer->info->lastname }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bolder">Prénom</td>
                                    <td>{{ $customer->info->firstname }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="separator separator-dashed my-2 border-gray-500"></div>
                    <strong>Mon Agence Actuel:</strong> {{ $customer->agency->name }}<br>
                    <div class="mb-10">
                        <label for="agency_id" class="form-label required">Je souhaite transférer les comptes de cette agence vers :</label>
                        <select class="form-control form-control-solid selectpicker" name="agency_id" data-live-search="true">
                            <option value="" data-tokens=""></option>
                            @foreach(\App\Models\Core\Agency::all() as $agency)
                                <option value="{{ $agency->id }}" data-tokens="{{ $agency->postal }} {{ $agency->name }}">{{ $agency->postal }} - {{ $agency->name }}</option>
                            @endforeach
                        </select>
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
    @include("customer.scripts.account.profil.transfer.index")
@endsection

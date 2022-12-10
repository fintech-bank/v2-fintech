@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Nouvelle remise de chèque</h3>
            </div>
            <form id="" action="/api/customer/{{ $wallet->customer->id }}/wallet/{{ $wallet->number_account }}" method="POST" enctype="multipart/formdata">
                @csrf
                <input type="hidden" name="action" value="check_deposit">
                <div class="card-body">
                    <div id="chq_repeat">
                        <div class="form-group">
                            <div data-repeater-list="chq_repeat">
                                <div data-repeater-item>
                                    <div class="form-group row mb-5">
                                        <div class="col-md-2">
                                            <label for="number" class="form-label">Numéro du chèque</label>
                                            <input type="text" class="form-control form-control-solid" name="number" placeholder="Numéro du chèque">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="number" class="form-label">Montant</label>
                                            <input type="text" class="form-control form-control-solid" name="amount" placeholder="Montant du chèque">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="number" class="form-label">Nom du payeur</label>
                                            <input type="text" class="form-control form-control-solid" name="name_deposit" placeholder="Nom du payeur">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="number" class="form-label">Banque du payeur</label>
                                            <!--<input type="text" class="form-control form-control-solid" name="bank_deposit" placeholder="Banque du payeur">-->
                                            <select class="form-control form-control-solid" data-kt-repeater="select2" data-control="select2" name="bank_deposit" data-live-search="true" title="selectionner une banque">
                                                <option value=""></option>
                                                @foreach(\App\Models\Core\Bank::all() as $bank)
                                                    <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="number" class="form-label">Date de dépot</label>
                                            <input type="text" class="form-control form-control-solid" data-kt-repeater="datepicker" name="date_deposit" placeholder="Date du dépot">
                                        </div>
                                        <div class="col-md-2">
                                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                <i class="la la-trash-o"></i>Supprimer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                <i class="la la-plus"></i> Ajouter
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <x-form.button />
                </div>
            </form>
        </div>
    </div>
@endsection

@section("script")
    <script src="/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    @include("customer.scripts.compte.check_deposit")
@endsection

@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Service Transbank</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        @if($mobility->status == 'select_mvm_bank')
            <form id="formSelectMvmBank" action="/api/user/{{ $mobility->customer->user->id }}/mobility/{{ $mobility->ref_mandate }}">
                @csrf
                @method('PUT')
                <table class="table table-striped table-row-bordered border-bottom-1 gy-3 gx-3">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Type</th>
                        <th>Créditeur</th>
                        <th>Montant</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($mobility->mouvements()->where('valid', 0)->get() as $mouvement)
                            <tr>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="mvm_id[]" value="{{ $mouvement->id }}" id="mvm_id_{{ $mouvement->id }}"/>
                                    </div>
                                </td>
                                <td>{{ $mouvement->type_text }}</td>
                                <td>{{ $mouvement->creditor }}</td>
                                <td>{{ eur($mouvement->amount) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex flex-end">
                    <x-form.button />
                </div>
            </form>
        @endif
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.mobility.show")
@endsection

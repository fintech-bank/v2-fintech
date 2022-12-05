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
        <p class="fw-bolder fs-2">Transférez les virements et prélévements récurrents de votre ancien compte sur votre compte Société Générale</p>
        <div class="border border-2 rounded p-5 d-flex flex-column align-items-center mb-5">
            <ul class="list-unstyled">
                <li><strong>Une démarche simple:</strong> ous nous fournissez le RIB de votre ancien compte, formulez vos instructions en remplissant le formulaire ci-après et nous nous chargeons des formalités en votre nom.</li>
                <li><strong>Un suivi complet:</strong> à tout moment depuis votre Espace Clients, vous suivez la progression de votre mobilité bancaire</li>
            </ul>
        </div>
        <div class="d-flex flex-end mb-5">
            <button class="btn btn-circle btn-lg btn-outline btn-outline-dark" data-bs-toggle="modal" data-bs-target="#Subscribe">Souscrire un nouveau mandat</button>
        </div>
        <table class="table border table-row-bordered border-2 border-gray-300 table-striped gx-5 gy-5" id="tableMobilities">
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>Type de Transfer</th>
                    <th>Compte à compte</th>
                    <th>Etape</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($customer->mobilities as $mobility)
                    <tr>
                        <td>
                            <strong>{{ $mobility->name_mandate }}</strong><br>
                            <i>{{ $mobility->ref_mandate }}</i>
                        </td>
                        <td>{{ $mobility->type->name }}</td>
                        <td>
                            <div class="d-flex flex-row justify-content-center align-items-center">
                                <div class="d-flex flex-column">
                                    <strong>{{ $mobility->name_account }}</strong>
                                    <div class=""><strong>IBAN:</strong> {{ $mobility->iban }}</div>
                                    <div class=""><strong>BIC:</strong> {{ $mobility->bic }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{!! $mobility->status_label !!}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" tabindex="-1" id="Subscribe">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Création du mandat</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formSubscribe" action="/api/user/{{ $customer->user->id }}/mobility" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="d-flex flex-row justify-content-around">
                            @foreach(\App\Models\Core\MobilityType::all() as $type)
                                <x-form.radio-select
                                    name="mobility_type_id"
                                    label="{{ $type->name }}"
                                    label-content="{{ $type->description }}"
                                    value="{{ $type->id }}"
                                    icon="{{ \App\Helper\IconHelpers::getIcons()->random() }}"/>
                            @endforeach
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
    @include("customer.scripts.account.profil.mobility.index")
@endsection

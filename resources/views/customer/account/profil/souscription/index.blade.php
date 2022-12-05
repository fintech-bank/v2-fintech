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

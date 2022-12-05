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
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid {{ $customer->package->icon }} text-{{ $customer->package->color }} me-3"></i> {{ $customer->package->name }}</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-light">
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
                            @if($customer->wallets()->with('cards')->where('type', 'compte')->count('cards') <= $customer->package->nb_carte_physique)
                                <span class="badge badge-success">{{ $customer->wallets()->with('cards')->where('type', 'compte')->count('cards') }} / {{ $customer->package->nb_carte_physique }}</span>
                            @else
                                <span class="badge badge-danger">{{ $customer->wallets()->with('cards')->where('type', 'compte')->count('cards') }} / {{ $customer->package->nb_carte_physique }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.paystar")
@endsection

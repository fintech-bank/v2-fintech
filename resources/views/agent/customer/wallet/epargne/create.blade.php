@extends("agent.layouts.app")

@section("css")

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
                <a href="{{ route('agent.customer.show', $customer->id) }}"
                   class="text-muted text-hover-primary">{{ $customer->user->identifiant }} - {{ $customer->info->full_name }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Nouveau compte épargne</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>-->
    </div>
@endsection

@section("content")
    <form action="{{ route('api.epargne.create') }}" method="post">
        @csrf
        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="card shadow-sm mb-10">
                    <div class="card-header">
                        <h3 class="card-title">Client</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-gray-500 fw-semibold fs-5 mb-5">Client désigné pour le nouveau compte épargne:</div>
                        {!! $customer->customer_card !!}
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Simulation de l'épargne</h3>
                    </div>
                    <div class="card-body">
                        <x-form.select
                            name="epargne_plan_id"
                            label="Plan d'épargne"
                            required="true"
                            :datas="\App\Models\Core\EpargnePlan::toSelect(\App\Models\Core\EpargnePlan::where('type_customer', $customer->info->type)->get())" />

                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <x-form.input
                                    name="initial_payment"
                                    label="Montant Initial"
                                    required="true"
                                    help="true"
                                    help-text="Montant qui và vous êtes prélevé dès l'ouverture du compte épargne" />
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <x-form.input
                                    name="monthly_payment"
                                    label="Montant déposé tous les mois"
                                    required="true"
                                    help="true"
                                    help-text="Montant qui và vous êtes prélevé tous les mois de manière récursive" />
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <x-form.input
                                    name="monthly_day"
                                    label="Date de prélèvement" />
                            </div>
                        </div>

                        <x-form.select
                            name="wallet_payment_id"
                            label="Compte de retrait"
                            required="true"
                            :datas="\App\Models\Customer\CustomerWallet::toSelect(\App\Models\Customer\CustomerWallet::where('customer_id', $customer->id)->where('type', '!=', 'pret')->get(), true)" />

                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="card shadow-sm" data-kt-sticky="true" data-kt-sticky-name="epargne-summary"
                     data-kt-sticky-offset="{default: false, lg: '200px'}"
                     data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto"
                     data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                    <div class="card-header">
                        <h3 class="card-title">Récapitulatif de l'épargne</h3>
                        <div class="card-toolbar">
                            <!--<button type="button" class="btn btn-sm btn-light">
                                Action
                            </button>-->
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section("script")
    @include("agent.scripts.customer.wallet.createEpargne")
@endsection

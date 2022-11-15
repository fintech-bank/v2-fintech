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
                <a href="{{ route('agent.customer.show', $facelia->card->wallet->customer->id) }}"
                   class="text-muted text-hover-primary">{{ $facelia->card->wallet->customer->user->identifiant }} - {{ $facelia->card->wallet->customer->info->full_name }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.wallet.show', $facelia->card->wallet->number_account) }}"
                   class="text-muted text-hover-primary">{{ $facelia->card->wallet->type_text }} - N°{{ $facelia->card->wallet->number_account }}</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Carte Bancaire {{ $facelia->card->support->name }} - {{ $facelia->card->number_format }} / FACELIA</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="getInfoDashboard()">Rafraichir</button>-->
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-3 col-sm-12 mb-10">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-hand me-2"></i> Information sur le prêt affilié</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Type de prêt</div>
                        <div class="ps-5">{{ $facelia->pret->plan->name }}</div>
                    </div>
                    <div class="separator separator-dashed border-black border-3 my-3"></div>
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Référence</div>
                        <div class="ps-5"><a href="{{ route('agent.customer.wallet.show', $facelia->pret->wallet->number_account) }}">{{ $facelia->pret->reference }}</a></div>
                    </div>
                    <div class="separator separator-dashed border-black border-3 my-3"></div>
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Etat</div>
                        <div class="ps-5">{!! $facelia->pret->status_label !!}</div>
                        <div class="ps-5 fs-6"><i>{{ $facelia->pret->status_explanation }}</i></div>
                    </div>
                    <div class="separator separator-dashed border-black border-3 my-3"></div>
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Compte affilié</div>
                        <div class="ps-5">{{ $facelia->card->wallet->name_account }}</div>
                    </div>
                    <div class="separator separator-dashed border-black border-3 my-3"></div>
                    <div class="d-flex flex-column">
                        <div class="fw-bolder fs-2">Carte Affilié</div>
                        <div class="ps-5">{{ $facelia->card->number_format }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12"></div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.wallet.facelia")
@endsection

@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Nouveau client</h1>
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
                   class="text-muted text-hover-primary">Gestion clientèle</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Nouveau client</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <button href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" onclick="history.back()"><i class="fa-solid fa-arrow-left me-2"></i> Retour</button>
    </div>
@endsection

@section("content")
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between">
                <a href="" class="card shadow-lg bg-light-primary">
                    <div class="card-body">
                        <div class="d-flex flex-row align-items-center">
                            <i class="fa-solid fa-users-between-lines fa-2x me-5"></i>
                            <div class="d-flex flex-column">
                                <div class="fs-1">Particulier</div>
                                <div class="text-muted">Ouverture d'un compte pour particulier</div>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="" class="card shadow-lg bg-light-success">
                    <div class="card-body">
                        <div class="d-flex flex-row align-items-center">
                            <i class="fa-solid fa-building fa-2x me-5"></i>
                            <div class="d-flex flex-column">
                                <div class="fs-1">Professionnel</div>
                                <div class="text-muted">Ouverture d'un compte pour les Professionnelles et Entreprises</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.index")
@endsection

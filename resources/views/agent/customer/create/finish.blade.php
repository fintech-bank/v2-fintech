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
    <div class="rwo">
        <div class="col-md-8 col-sm-12">

        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Que faire ensuite ?</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-8">
                        <!--begin::Bullet-->
                        <span class="bullet bullet-vertical h-40px bg-success me-5"></span>
                        <!--end::Bullet-->
                        <!--begin::Description-->
                        <div class="flex-grow-1">
                            <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-6">Vérifier l'identité du client</a>
                        </div>
                        <!--end::Description-->
                        @if(!$customer->info->isVerified)
                        <a href="" class="btn btn-sm btn-primary startPersonnaCustomer">Vérifier</a>
                        @endif
                    </div>
                    <div class="d-flex align-items-center mb-8">
                        <!--begin::Bullet-->
                        <span class="bullet bullet-vertical h-40px bg-success me-5"></span>
                        <!--end::Bullet-->
                        <!--begin::Description-->
                        <div class="flex-grow-1">
                            <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-6">Vérifier l'adresse du client</a>
                        </div>
                        <!--end::Description-->
                        @if(!$customer->info->addressVerified)
                            <a href="" class="btn btn-sm btn-primary startPersonnaDomicile">Vérifier</a>
                        @endif
                    </div>
                    <div class="d-flex align-items-center mb-8">
                        <!--begin::Bullet-->
                        <span class="bullet bullet-vertical h-40px bg-success me-5"></span>
                        <!--end::Bullet-->
                        <!--begin::Description-->
                        <div class="flex-grow-1">
                            <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-6">Signer la convention de compte</a>
                        </div>
                        <!--end::Description-->
                        @if(!$customer->documents()->where('name', 'LIKE', "%Convention de compte%")->first()->signed_by_client)
                        <a href="" class="btn btn-sm btn-primary btnSignate" data-document="{{ $customer->documents()->where('name', 'LIKE', "%Convention de compte%")->first()->id }}">Signer</a>
                        @endif
                    </div>
                    <div class="d-flex align-items-center mb-8">
                        <!--begin::Bullet-->
                        <span class="bullet bullet-vertical h-40px bg-success me-5"></span>
                        <!--end::Bullet-->
                        <!--begin::Description-->
                        <div class="flex-grow-1">
                            <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-6">Activer 2FA (Authy)</a>
                        </div>
                        <!--end::Description-->
                        @if(!$customer->info->isVerified)
                            <a href="" class="btn btn-sm btn-primary startAuthyRegister">Vérifier</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.create")
@endsection

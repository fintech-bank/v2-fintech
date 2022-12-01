@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Sécurité</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="text-center mb-10">
            <div class="fs-2tx uppercase">Profil de {{ $customer->info->full_name }}</div>
            <div class="fs-1">Gérez ici vos moyens de sécurité : code secret, numéro de téléphone sécurité et Pass Sécurité.</div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="fw-bolder fs-1 mb-3">Numéro de téléphone de sécurité</div>
                        <div class="d-flex flex-row border border-gray-300 p-8 align-items-center mb-5">
                            @if($customer->info->mobileVerified)
                                <i class="fa-regular fa-check-circle text-success fs-2tx me-5"></i>
                                <div class="d-flex flex-column">
                                    <span>Votre numéro de téléphone de sécurité est le:</span>
                                    <div class="fw-bolder fs-1">{{ $customer->info->getMobileNumber('obscure') }}</div>
                                </div>
                            @else
                                <i class="fa-regular fa-xmark-circle text-danger fs-2tx me-5"></i>
                                <div class="d-flex flex-column">
                                    <span>Votre numéro de téléphone de sécurité est le:</span>
                                    <div class="fw-bolder fs-1">Aucun numéro de téléphone définie</div>
                                </div>
                            @endif
                        </div>
                        <p>
                            Vous avez changé de numéro de téléphone ?<br>
                            Pensez à le modifier.
                        </p>
                        <button class="btn btn-circle btn-outline btn-outline-dark">Modifier le téléphone</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Mon profil & Sécurité</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="text-center fw-bolder fs-2hx mb-5">Mes Données Personnelles</div>
        <div class="row mb-15">
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.security.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold">Sécurité</div>
                            <div>
                                <i class="fa-solid fa-desktop text-black fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-muted fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Gérez vos moyens de sécurité : code secret, numéro de téléphone sécurité et Pass Sécurité</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.identity.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold">Mon Identité</div>
                            <div>
                                <i class="fa-solid fa-desktop text-black fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-muted fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Ici, consultez les informations concernant votre identité : civilité / nom / prénom / profession</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.contact.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold">Mes Coordonnées</div>
                            <div>
                                <i class="fa-solid fa-desktop text-black fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-muted fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Accédez à vos coordonnées : numéro de téléphone / adresse postale / adresse e-mail</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.grpd.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded h-250px">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold w-50">Mes données personnelles</div>
                            <div>
                                <i class="fa-solid fa-desktop text-black fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-black fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Exprimez vos préférences concernant la gestion de vos données personnelles</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.security.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold">Code secret</div>
                            <div>
                                <i class="fa-solid fa-desktop text-muted fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-black fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Ici, modifiez votre code secret</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="text-center fw-bolder fs-2hx mb-5">Services & Avantages</div>
        <div class="row mb-15">
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.cashback.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold">Cashback</div>
                            <div>
                                <i class="fa-solid fa-desktop text-muted fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-muted fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Avec le Cashback Société Générale, vos dépenses deviennent des récompenses, à chaque achat chez nos partenaires, en ligne ou en magasin.</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.sponsorship.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold">Mon espace parrainage</div>
                            <div>
                                <i class="fa-solid fa-desktop text-muted fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-muted fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Parrainez vos proches et suivez vos invitations de parrainage.</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.mobility.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold">Service Transbank</div>
                            <div>
                                <i class="fa-solid fa-desktop text-black fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-muted fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Transférez vos virements et prélèvements sur votre compte</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.transfer.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold">Transfert d'Agence</div>
                            <div>
                                <i class="fa-solid fa-desktop text-black fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-muted fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Transférez vos comptes dans une nouvelle agence Société Générale</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.paystar.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold">Paystar</div>
                            <div>
                                <i class="fa-solid fa-desktop text-muted fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-black fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Gérez vos services Paystar</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-12 mb-5">
                <a href="{{ route('customer.account.profil.paystar.index') }}" class="text-dark">
                    <div class="bg-white shadow-lg p-10 rounded">
                        <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
                            <div class="fs-1 fw-bold">Paystar</div>
                            <div>
                                <i class="fa-solid fa-desktop text-muted fs-2x me-2"></i>
                                <i class="fa-solid fa-mobile text-black fs-2x me-2"></i>
                            </div>
                        </div>
                        <p>Gérez vos services Paystar</p>
                        <div class="text-end">
                            <i class="fa-solid fa-arrow-right-long text-hover-primary fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

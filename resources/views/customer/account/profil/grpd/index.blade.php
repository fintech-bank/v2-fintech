@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Gestion des données personnelles</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="text-center mb-10">
            <div class="fs-2tx">Maîtrisez le traitement de vos données personnelles et exercez vos droits</div>
            <div class="fs-1">{{ config('app.name') }} met cet espace à votre disposition pour vous permettre de garder la maîtrise de vos données personnelles et d’exercer vos droits concernant leur traitement.</div>
        </div>
        <div class="d-flex flex-center rounded border border-gray-300 py-10">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="fs-2hx fw-light">{{ $customer->grpd_demande()->count() }}</div>
                <div class="fs-5">Demande</div>
                <button class="btn btn-circle btn-lg btn-bank" {{ $customer->grpd_demande()->count() == 0 ? 'disabled' : '' }}>Voir mes demandes</button>
            </div>
        </div>

        <div class="separator separator-dotted separator-content border-dark my-15"><span class="h1">Vos préférences</span></div>

        <div class="row">
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200" data-bs-toggle="modal" data-bs-target="#GrpdConsent" style="cursor: pointer">
                    <div class="d-flex flex-row justify-content-between align-items-end">
                        <div class="text-black fs-2 w-75">Exprimer votre consentement à l’utilisation de certaines de vos données personnelles</div>
                        <i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200" data-bs-toggle="modal" data-bs-target="#GrpdRip" style="cursor: pointer">
                    <div class="d-flex flex-row justify-content-between align-items-end">
                        <div class="text-black fs-2 w-75">Personnaliser vos préférences de contact pour la réception d’offres commerciales</div>
                        <i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="GrpdConsent">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Dématérialisation et traitement de données</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formGrpdConsent" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="bg-gray-200 p-5 mb-10">
                            <div class="fw-bolder">e-Documents</div>
                            <p>Nous souhaitons recueillir votre consentement dans le cadre du service de dématérialisation des documents, e-Documents.</p>
                            <p>En donnant votre accord, vous recevrez vos relevés et vos documents éligibles liés à vos comptes et produits au format électronique dans votre espace client sécurisé.</p>
                            <p>Vous serez informé(e) sur votre adresse mail de la mise à disposition de nouveaux documents dans votre espace client.</p>
                            <p>Le code secret de carte bancaire fait partie des éléments éligibles au service de dématérialisation des documents.</p>
                            <p>En acceptant ce service, le code secret de votre carte sera consultable en ligne sur votre espace client sécurisé et ne sera plus envoyé par courrier.</p>
                            <p>Les conditions d'accès au code, ainsi qu'à la carte font l’objet de précisions dans les conditions générales de votre contrat de banque à distance.</p>
                        </div>
                        <div class="mb-5">
                            <p class="fw-bold">Je souhaite bénéficier de mes relevés et documents liés à mes comptes et produits au format électronique sur mon espace client sécurisé.</p>
                            <p>Je donne mon accord</p>
                            <div class="d-flex flex-row">
                                <x-form.radio
                                    name="edocument"
                                    value="1"
                                    label="Oui"
                                    for="edocument"
                                    checked="true" />

                                <x-form.radio
                                    name="edocument"
                                    value="0"
                                    label="Non"
                                    for="edocument" />


                            </div>
                        </div>
                        <div class="separator border-gray-300 my-5"></div>
                        <div class="bg-gray-200 p-5 mb-10">
                            <div class="fw-bolder">Utilisation de certaines de vos données personnelles </div>
                            <p>Vous pouvez personnaliser vos interactions avec Société Générale en consentant à l’utilisation de certaines catégories de données.</p>
                            <p>Vous pouvez modifier votre choix à tout moment.</p>
                        </div>
                        <div class="mb-5">
                            <p class="fw-bolder">Donnée : le contenu de nos échanges téléphoniques, mails et Tchat</p>
                            <p class="fw-bold">La lecture automatisée de nos échanges nous permet d’améliorer nos réponses.</p>
                            <p>Je donne mon accord</p>
                            <div class="d-flex flex-row">
                                <x-form.radio
                                    name="content_com"
                                    value="1"
                                    label="Oui"
                                    for="content_com"
                                    checked="true" />

                                <x-form.radio
                                    name="content_com"
                                    value="0"
                                    label="Non"
                                    for="content_com" />

                            </div>
                        </div>
                        <div class="separator border-gray-300 my-5"></div>
                        <div class="mb-5">
                            <p class="fw-bolder">Donnée : votre géo-localisation</p>
                            <p class="fw-bold">Nous pouvons géolocaliser vos paiements par carte bancaires ainsi que vos connexions à nos sites et applications sécurisées.</p>
                            <p>Je donne mon accord</p>
                            <div class="d-flex flex-row">
                                <x-form.radio
                                    name="content_geo"
                                    value="1"
                                    label="Oui"
                                    for="content_geo"
                                    checked="true" />

                                <x-form.radio
                                    name="content_geo"
                                    value="0"
                                    label="Non"
                                    for="content_geo" />

                            </div>
                        </div>
                        <div class="separator border-gray-300 my-5"></div>
                        <div class="mb-5">
                            <p class="fw-bolder">Donnée : le contenu de vos échanges avec Société Générale sur les réseaux sociaux</p>
                            <p class="fw-bold">Nous n’accédons pas à vos données et conversations privées sur les réseaux sociaux, mais proposons d’améliorer nos échanges à partir des informations que vous nous fournissez sur nos espaces d’échange avec Société Générale (par exemple @ SG_et vous sur Twitter, sur la page Société Générale et Vous sur Facebook).</p>
                            <p>Je donne mon accord</p>
                            <div class="d-flex flex-row">
                                <x-form.radio
                                    name="content_social"
                                    value="1"
                                    label="Oui"
                                    for="content_social"
                                    checked="true" />

                                <x-form.radio
                                    name="content_social"
                                    value="0"
                                    label="Non"
                                    for="content_social" />

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-end">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="GrpdRip">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Votre banque, comme vous l'entendez</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formGrpdRip" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <p>
                            Parce que nos communications doivent garder du sens pour vous, nous vous invitons à choisir les contenus que vous souhaitez recevoir et les moyens de vous contacter.<br>
                            Vous pouvez à tout moment modifier vos choix en fonction de vos besoins.
                        </p>

                        <x-base.alert
                            type="light"
                            color="primary"
                            icon="circle-info"
                            title=""
                            content="Ces choix ne concernent pas les communications de nature réglementaire ou liées à l’exécution de vos contrats." />

                        <div class="bg-gray-300 p-5">
                            <div class="fs-2x fw-bolder">Préférences de contenus</div>
                            <p>Les communications Société Générale sont divisées en 4 grandes catégories. Notre objectif ? Faire en sorte que vous ne ratiez aucune opportunité. À vous d'indiquer vos préférences.</p>
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
    @include("customer.scripts.account.profil.grpd.index")
@endsection

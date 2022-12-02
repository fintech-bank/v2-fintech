@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Gestion des
            données personnelles</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="text-center mb-10">
            <div class="fs-2tx">Maîtrisez le traitement de vos données personnelles et exercez vos droits</div>
            <div class="fs-1">{{ config('app.name') }} met cet espace à votre disposition pour vous permettre de garder
                la maîtrise de vos données personnelles et d’exercer vos droits concernant leur traitement.
            </div>
        </div>
        <div class="d-flex flex-center rounded border border-gray-300 py-10">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="fs-2hx fw-light">{{ $customer->grpd_demande()->count() }}</div>
                <div class="fs-5">Demande</div>
                <button
                    class="btn btn-circle btn-lg btn-bank" {{ $customer->grpd_demande()->count() == 0 ? 'disabled' : '' }} data-bs-toggle="modal" data-bs-target="#demandes">
                    Voir mes demandes
                </button>
            </div>
        </div>

        <div class="separator separator-dotted separator-content border-dark my-15"><span
                class="h1">Vos préférences</span></div>

        <div class="row">
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200" data-bs-toggle="modal" data-bs-target="#GrpdConsent"
                     style="cursor: pointer">
                    <div class="d-flex flex-row justify-content-between align-items-end">
                        <div class="text-black fs-2 w-75">Exprimer votre consentement à l’utilisation de certaines de
                            vos données personnelles
                        </div>
                        <i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200" data-bs-toggle="modal" data-bs-target="#GrpdRip"
                     style="cursor: pointer">
                    <div class="d-flex flex-row justify-content-between align-items-end">
                        <div class="text-black fs-2 w-75">Personnaliser vos préférences de contact pour la réception
                            d’offres commerciales
                        </div>
                        <i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="separator separator-dotted separator-content border-dark my-15"><span class="h1">Vos demandes</span>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200" data-bs-toggle="modal" data-bs-target="#DroitAcces"
                     style="cursor: pointer">
                    <div class="d-flex flex-row justify-content-between align-items-end">
                        <div class="text-black fs-2 w-75">Accéder à vos données personnelles traitées par Société
                            Générale
                        </div>
                        <i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200" data-bs-toggle="modal" data-bs-target="#Inacurate"
                     style="cursor: pointer">
                    <div class="d-flex flex-row justify-content-between align-items-end">
                        <div class="text-black fs-2 w-75">Rectifier vos données personnelles inexactes ou incomplètes
                        </div>
                        <i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200" data-bs-toggle="modal" data-bs-target="#ComProspecting"
                     style="cursor: pointer">
                    <div class="d-flex flex-row justify-content-between align-items-end">
                        <div class="text-black fs-2 w-75">Vous opposer à certaines utilisations de vos données
                            personnelles
                        </div>
                        <i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200" data-bs-toggle="modal" data-bs-target="#Erasure"
                     style="cursor: pointer">
                    <div class="d-flex flex-row justify-content-between align-items-end">
                        <div class="text-black fs-2 w-75">Demander l’effacement de certaines de vos données
                            personnelles
                        </div>
                        <i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200" data-bs-toggle="modal" data-bs-target="#Limit"
                     style="cursor: pointer">
                    <div class="d-flex flex-row justify-content-between align-items-end">
                        <div class="text-black fs-2 w-75">Limiter le traitement de vos données personnelles</div>
                        <i class="fa-solid fa-arrow-right-long fs-2 text-hover-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-5">
                <div class="border border-gray-400 p-5 bg-gray-200" data-bs-toggle="modal" data-bs-target="#Portability"
                     style="cursor: pointer">
                    <div class="d-flex flex-row justify-content-between align-items-end">
                        <div class="text-black fs-2 w-75">Exercer votre droit à la portabilité</div>
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
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formGrpdConsent" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="grpd_consent">
                    <div class="modal-body">
                        <div class="bg-gray-200 p-5 mb-10">
                            <div class="fw-bolder">e-Documents</div>
                            <p>Nous souhaitons recueillir votre consentement dans le cadre du service de
                                dématérialisation des documents, e-Documents.</p>
                            <p>En donnant votre accord, vous recevrez vos relevés et vos documents éligibles liés à vos
                                comptes et produits au format électronique dans votre espace client sécurisé.</p>
                            <p>Vous serez informé(e) sur votre adresse mail de la mise à disposition de nouveaux
                                documents dans votre espace client.</p>
                            <p>Le code secret de carte bancaire fait partie des éléments éligibles au service de
                                dématérialisation des documents.</p>
                            <p>En acceptant ce service, le code secret de votre carte sera consultable en ligne sur
                                votre espace client sécurisé et ne sera plus envoyé par courrier.</p>
                            <p>Les conditions d'accès au code, ainsi qu'à la carte font l’objet de précisions dans les
                                conditions générales de votre contrat de banque à distance.</p>
                        </div>
                        <div class="mb-5">
                            <p class="fw-bold">Je souhaite bénéficier de mes relevés et documents liés à mes comptes et
                                produits au format électronique sur mon espace client sécurisé.</p>
                            <p>Je donne mon accord</p>
                            <div class="d-flex flex-row">
                                <x-form.radio
                                    name="edocument"
                                    value="1"
                                    label="Oui"
                                    for="edocument"
                                    checked="true"/>

                                <x-form.radio
                                    name="edocument"
                                    value="0"
                                    label="Non"
                                    for="edocument"/>


                            </div>
                        </div>
                        <div class="separator border-gray-300 my-5"></div>
                        <div class="bg-gray-200 p-5 mb-10">
                            <div class="fw-bolder">Utilisation de certaines de vos données personnelles</div>
                            <p>Vous pouvez personnaliser vos interactions avec Société Générale en consentant à
                                l’utilisation de certaines catégories de données.</p>
                            <p>Vous pouvez modifier votre choix à tout moment.</p>
                        </div>
                        <div class="mb-5">
                            <p class="fw-bolder">Donnée : le contenu de nos échanges téléphoniques, mails et Tchat</p>
                            <p class="fw-bold">La lecture automatisée de nos échanges nous permet d’améliorer nos
                                réponses.</p>
                            <p>Je donne mon accord</p>
                            <div class="d-flex flex-row">
                                <x-form.radio
                                    name="content_com"
                                    value="1"
                                    label="Oui"
                                    for="content_com"
                                    checked="true"/>

                                <x-form.radio
                                    name="content_com"
                                    value="0"
                                    label="Non"
                                    for="content_com"/>

                            </div>
                        </div>
                        <div class="separator border-gray-300 my-5"></div>
                        <div class="mb-5">
                            <p class="fw-bolder">Donnée : votre géo-localisation</p>
                            <p class="fw-bold">Nous pouvons géolocaliser vos paiements par carte bancaires ainsi que vos
                                connexions à nos sites et applications sécurisées.</p>
                            <p>Je donne mon accord</p>
                            <div class="d-flex flex-row">
                                <x-form.radio
                                    name="content_geo"
                                    value="1"
                                    label="Oui"
                                    for="content_geo"
                                    checked="true"/>

                                <x-form.radio
                                    name="content_geo"
                                    value="0"
                                    label="Non"
                                    for="content_geo"/>

                            </div>
                        </div>
                        <div class="separator border-gray-300 my-5"></div>
                        <div class="mb-5">
                            <p class="fw-bolder">Donnée : le contenu de vos échanges avec Société Générale sur les
                                réseaux sociaux</p>
                            <p class="fw-bold">Nous n’accédons pas à vos données et conversations privées sur les
                                réseaux sociaux, mais proposons d’améliorer nos échanges à partir des informations que
                                vous nous fournissez sur nos espaces d’échange avec Société Générale (par exemple @
                                SG_et vous sur Twitter, sur la page Société Générale et Vous sur Facebook).</p>
                            <p>Je donne mon accord</p>
                            <div class="d-flex flex-row">
                                <x-form.radio
                                    name="content_social"
                                    value="1"
                                    label="Oui"
                                    for="content_social"
                                    checked="true"/>

                                <x-form.radio
                                    name="content_social"
                                    value="0"
                                    label="Non"
                                    for="content_social"/>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-end">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="GrpdRip">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Votre banque, comme vous l'entendez</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formGrpdRip" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="grpd_rip">
                    <div class="modal-body">
                        <p>
                            Parce que nos communications doivent garder du sens pour vous, nous vous invitons à choisir
                            les contenus que vous souhaitez recevoir et les moyens de vous contacter.<br>
                            Vous pouvez à tout moment modifier vos choix en fonction de vos besoins.
                        </p>

                        <x-base.alert
                            type="light"
                            color="primary"
                            icon="circle-info"
                            title=""
                            content="Ces choix ne concernent pas les communications de nature réglementaire ou liées à l’exécution de vos contrats."/>

                        <div class="bg-gray-300 p-5">
                            <div class="fs-2x fw-bolder">Préférences de contenus</div>
                            <p>Les communications Société Générale sont divisées en 4 grandes catégories. Notre objectif
                                ? Faire en sorte que vous ne ratiez aucune opportunité. À vous d'indiquer vos
                                préférences.</p>

                            <div class="d-flex flex-center flex-column bg-white rounded shadow-sm mx-auto p-5 w-75">
                                <div class="d-flex flex-row align-items-center mb-10">
                                    <i class="fa-regular fa-newspaper fs-4hx text-bank me-5"></i>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-2x mb-5">Newsletters Société Générale</div>
                                        <div class="text-muted fs-2x mb-5">Pour suivre l'actualité...</div>
                                        <p>Financement, patrimoine, gestion des comptes, sécurité... ces communications
                                            à caractère informatif et pédagogique évoquent des thématiques qui
                                            pourraient vous intéresser et également des articles pratiques pour en
                                            savoir plus sur les solutions bancaires proposées par Société Générale.</p>
                                        <x-form.checkbox
                                            name="rip_newsletter"
                                            value="1"
                                            label="Je m'oppose à recevoir les newsletters de {{ config('app.name') }}"/>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-row align-items-center mb-10">
                                    <i class="fa-regular fa-handshake fs-4hx text-bank me-5"></i>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-2x mb-5">Offres commerciales</div>
                                        <div class="text-muted fs-2x mb-5">Pour vous accompagner</div>
                                        <p>Votre carte doit évoluer pour s'adapter à vos besoins, vous souhaitez
                                            financer un projet, vous devenez parent, vous approchez du départ à la
                                            retraite... ces communications visent à vous accompagner et vous conseiller
                                            au quotidien. Et cela tout en vous faisant bénéficier de nos meilleures
                                            offres à des conditions tarifaires avantageuses.</p>
                                        <x-form.checkbox
                                            name="rip_commercial"
                                            value="1"
                                            label="Je m'oppose à recevoir les offres commerciales"/>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-row align-items-center mb-10">
                                    <i class="fa-regular fa-thumbs-up fs-4hx text-bank me-5"></i>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-2x mb-5">Votre opinion</div>
                                        <div class="text-muted fs-2x mb-5">Pour mieux vous satisfaire</div>
                                        <p>Ces communications visent à recueillir votre avis ou à mesurer votre
                                            satisfaction en vue d'améliorer notre offre et nos services. Au-delà de la
                                            satisfaction que nous vous devons, ces envois sont pour nous le marqueur de
                                            confiance d'une relation privilégiée.</p>
                                        <x-form.checkbox
                                            name="rip_survey"
                                            value="1"
                                            label="Je m'oppose à recevoir les enquêtes de satisfaction"/>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-row align-items-center mb-10">
                                    <i class="fa-regular fa-thumbs-up fs-4hx text-bank me-5"></i>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-2x mb-5">Offres de parrainage</div>
                                        <div class="text-muted fs-2x mb-5">Pour vous remercier</div>
                                        <p>Ces communications visent à récompenser votre fidélité en vous faisant
                                            bénéficier d'une prime dans le cadre d'un parrainage. Vos filleuls :
                                            proches, amis, collègues... recevront également une prime de bienvenue.</p>
                                        <x-form.checkbox
                                            name="rip_sponsorship"
                                            value="1"
                                            label="Je m'oppose à recevoir les offres de parrainages"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="fs-2x fw-bolder">Préférences de canal</div>
                                <p>Choisissez les moyens de contact qui vous conviennent pour recevoir ces
                                    communications</p>
                                <!--begin::Input group-->
                                <div class="d-flex flex-center mx-auto w-75">
                                    <div class="d-flex flex-stack w-lg-50 shadow-sm p-5 me-5">
                                        <!--begin::Label-->
                                        <div class="me-5">
                                            <label class="fs-6 fw-semibold form-label">Par Mail</label>
                                            <div class="fs-7 fw-semibold text-muted">{{ $customer->user->email }}</div>
                                        </div>
                                        <!--end::Label-->

                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="rip_canal_mail"
                                                   value="1" checked="checked"/>
                                            <span class="form-check-label fw-semibold text-muted">

                                        </span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                    <div class="d-flex flex-stack w-lg-50 shadow-sm p-5">
                                        <!--begin::Label-->
                                        <div class="me-5">
                                            <label class="fs-6 fw-semibold form-label">Par Téléphone</label>
                                            <div
                                                class="fs-7 fw-semibold text-muted">{{ $customer->info->getPhoneNumber('obscure') }}</div>
                                        </div>
                                        <!--end::Label-->

                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="rip_canal_sms"
                                                   value="1" checked="checked"/>
                                            <span class="form-check-label fw-semibold text-muted"></span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer text-end">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="DroitAcces">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Accéder à vos données personnelles traitées par Société
                        Générale</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formDroitAcces" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="droit_acces">
                    <div class="modal-body">
                        <p>Vous pouvez demander à accéder aux données personnelles vous concernant traitées dans le
                            cadre de votre relation avec Société Générale.</p>
                        <p>La mise à disposition est immédiate pour :</p>
                        <ul>
                            <li>Vos données d’identification et de situation personnelle (Identité, situation familiale
                                et professionnelle, coordonnées, relation Société Générale…),
                            </li>
                            <li>Vos données sur les produits et prestations détenues.</li>
                        </ul>
                        <p>
                            <span
                                class="fw-bolder">Pour vos autres demandes, veuillez préciser votre attente.</span><br>
                            Depuis la <a href="{{ route('customer.dashboard') }}">synthèse de vos comptes</a> vous avez
                            accès aux données relatives à vos opérations bancaires et moyens de paiement.
                        </p>

                        <div class="mb-10">
                            <label for="type" class="form-label required">Votre demande concerne</label>
                            <select name="type" id="type" class="form-control form-control-solid selectpicker"
                                    onchange="selectDroitAccesType(this)">
                                <option value=""></option>
                                <option value="identity">Données d'identification et de situation personnelle</option>
                                <option value="subscription">Données sur les produits et les contrats détenues</option>
                                <option value="other">Autres données détenues</option>
                            </select>
                        </div>

                        <div class="other d-none">
                            <x-form.input
                                name="object_comment"
                                label="Objet"/>

                            <x-form.textarea
                                name="comment"
                                label="Votre Message"/>

                        </div>
                    </div>
                    <div class="modal-footer text-end">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="Inacurate">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Rectifier vos données personnelles inexactes ou incomplètes</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formInacturate" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="inacurate">
                    <div class="modal-body">
                        <p>Vous pouvez demander ici la rectification de vos données inexactes ou incomplètes.</p>
                        <p>
                            Pour l’accompagnement de vos moments de vie (Changement de nom, mariage, naissance…), qui
                            nécessitent un traitement complémentaire, veuillez prendre rendez-vous avec votre conseiller
                            en
                            <a href="{{ route('customer.account.agenda.index') }}">cliquant ici</a>.
                        </p>

                        <div class="d-flex flex-row mb-5">
                            <div class="rounded border border-2 w-50 p-10">
                                <div class="fw-bolder">Rectifiez vos coordonnées :</div>
                                <p>Numéro de téléphone / Adresse Postale / Adresse Email</p>
                                <div class="text-center">
                                    <a href="" class="btn btn-sm btn-circle btn-outline btn-outline-dark">Rectifier vos données</a>
                                </div>
                            </div>
                            <div class="rounded border border-2 w-50 p-10">
                                <div class="fw-bolder">Rectifiez vos éléments d’ identité : :</div>
                                <p>Enfants à charge ou situation professionnelle</p>
                                <div class="text-center">
                                    <a href="{{ route('customer.account.profil.identity.index') }}" class="btn btn-sm btn-circle btn-outline btn-outline-dark">Rectifier vos données</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap w-50 mx-auto align-items-center">
                            <p class="fw-bolder mb-5">
                                Pour rectifier vos autres données :<br>
                                Veuillez préciser la nature des données que vous jugez inexactes ou incomplètes et pourquoi vous souhaitez leur rectification.
                            </p>
                            <div class="d-flex flex-center flex-column">
                                <x-form.input
                                    type-input="float"
                                    name="object"
                                    label="Objet" />

                                <x-form.textarea
                                    name="comment"
                                    label="Votre message" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-end">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="ComProspecting">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">S'opposer à certaines utilisations de vos données personnelles</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formComProspecting" action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="action" value="com_prospecting">
                        <p>Vous pouvez ici vous opposer à ce que vos données personnelles soient utilisées par Société Générale pour un objectif spécifique.</p>
                        <x-base.alert
                            type="light"
                            color="primary"
                            icon="circle-info"
                            title=""
                            content="
                            <p>Pour vous opposer à ce que vos données soient utilisées pour des raisons tenant à votre situation particulière, veuillez préciser et justifier ces raisons grâce au formulaire ci-dessous.</p>
                            <p class='fw-bolder'>Si votre demande d’opposition ne concerne pas la prospection, Société Générale ne pourra donner suite à votre demande si :</p>
                            <ul>
                                <li>il existe des motifs légitimes et impérieux à traiter ces données ou que celles-ci sont nécessaires à la constatation, exercice ou défense de droits en justice ;</li>
                                <li>vous avez consenti au traitement de vos données ;</li>
                                <li>un contrat s’y afférant vous lie avec Société Générale ;</li>
                                <li>une obligation légale impose de traiter vos données ;</li>
                                <li>le traitement est nécessaire à la sauvegarde de vos intérêts vitaux ou d'une autre personne physique.</li>
                            </ul>
                            " />

                        <div class="d-flex flex-wrap w-50 mx-auto align-items-center">
                            <div class="d-flex flex-center flex-column">
                                <x-form.input
                                    type-input="float"
                                    name="object"
                                    label="Objet" />

                                <x-form.textarea
                                    name="comment"
                                    label="Votre message" />
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
    <div class="modal fade" tabindex="-1" id="Erasure">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Demander l’effacement de certaines de vos données personnelles</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formErasure" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="action" value="erasure">
                        <p>Vous pouvez ici demander l’effacement de certaines de vos données à caractère personnel dans les conditions prévues par la réglementation.</p>
                        <x-base.alert
                            type="light"
                            color="primary"
                            icon="circle-info"
                            title=""
                            content="
                            <p>Pour permettre le traitement de votre demande, veuillez en préciser les raisons grâce au formulaire ci-dessous.</p>
                            <p class='fw-bolder'>Société Générale ne pourra donner suite à votre demande si :</p>
                            <ul>
                                <li>il existe des motifs légitimes et impérieux à traiter ces données ou que celles-ci sont nécessaires à la constatation, exercice ou défense de droits en justice ;</li>
                                <li>vous avez consenti au traitement de vos données ;</li>
                                <li>un contrat s’y afférant vous lie avec Société Générale ;</li>
                                <li>une obligation légale impose de traiter vos données ;</li>
                                <li>un contrat vous liant à Société Générale impose que ces données soient conservées.</li>
                            </ul>
                            " />
                        <div class="d-flex flex-wrap w-50 mx-auto align-items-center">
                            <div class="d-flex flex-center flex-column">
                                <x-form.input
                                    type-input="float"
                                    name="object"
                                    label="Objet" />

                                <x-form.textarea
                                    name="comment"
                                    label="Votre message" />
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
    <div class="modal fade" tabindex="-1" id="Limit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Limiter l’utilisation de vos données personnelles</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formLimit" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="action" value="limit">
                        <p>Vous pouvez ici demander de geler temporairement l’utilisation de certaines de vos données personnelles. Société Générale ne pourra donner suite à votre demande que dans les cas prévus par la réglementation.</p>
                        <p>Veuillez préciser dans le formulaire ci-dessous :</p>
                        <ul>
                            <li>les données dont vous souhaitez limiter l’utilisation</li>
                            <li>la motivation de votre demande.</li>
                        </ul>
                        <div class="d-flex flex-wrap w-50 mx-auto align-items-center">
                            <div class="d-flex flex-center flex-column">
                                <x-form.input
                                    type-input="float"
                                    name="object"
                                    label="Objet" />

                                <x-form.textarea
                                    name="comment"
                                    label="Votre message" />
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
    <div class="modal fade" tabindex="-1" id="Portability">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Exercer votre droit à la portabilité</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formPortability" action="/api/user/{{ $customer->user->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="action" value="portability">
                        <p>Le droit à la portabilité vous offre la possibilité de télécharger certaines de vos données détenues par Société Générale, que vous avez fournies avec votre consentement ou pour les besoins de vos contrats, dans un format ouvert et lisible par machine.</p>
                        <p class="fw-bolder">Bon à savoir</p>
                        <p>Si votre demande porte sur un transfert des virements et prélèvements d’un compte détenu dans une autre banque, consultez le dispositif dédié ici</p>
                        <div class="d-flex flex-wrap w-50 mx-auto align-items-center">
                            <div class="d-flex flex-center flex-column">
                                <p class="fw-bolder">
                                    Souhaitez-vous générer la création d’un document rassemblant certaines des données personnelles que vous avez fournies avec votre consentement ou pour les besoins de vos contrats?
                                </p>
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
    <div class="modal fade" tabindex="-1" id="demandes">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Liste de vos demandes relatives GRPD</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-regular fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <table class="table table-bordered gy-5 gx-5">
                        <thead>
                            <tr>
                                <th>Sujet</th>
                                <th>Commentaire</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer->grpd_demande as $demande)
                                <tr>
                                    <td>{{ $demande->object }}</td>
                                    <td>{!! $demande->comment !!}</td>
                                    <td>{{ $demande->type_text }}</td>
                                    <td>{!! $demande->status_label !!}</td>
                                    <td>
                                        @if($demande->status == 'pending')
                                            <button class="btn btn-xs btn-icon btn-danger"><i class="fa-solid fa-ban text-white"></i> </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.grpd.index")
@endsection

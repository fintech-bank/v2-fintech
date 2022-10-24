@extends("front.layouts.app")

@section("content")
    <div class="d-flex flex-row w-100 min-h-350px min-h-lg-500px bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg" style="background-image: url(/assets/media/svg/illustrations/landing.svg)">
        <img src="https://particuliers.societegenerale.fr/static/Particuliers/assets/img/campagnes/2022/09/credit-expresso/pause_780x580-x1.webp" alt="" class="img-fluid h-100">
        <div class="d-flex flex-column ">
            <div class="d-flex flex-row p-20 align-items-center">
                <div class="badge badge-lg badge-info me-10">Crédit Facelia</div>
                <div class="text-info uppercase ">Vos avantages</div>
            </div>
            <div class="fs-2tx fw-bolder text-white uppercase px-20 underline mb-20">C'est facile avec le crédit facélia*</div>
            <div class="d-flex flex-row justify-content-start align-items-center px-20">
                <i class="fa-regular fa-circle-pause text-white fa-5x me-10"></i>
                <p class="text-white fs-2x l-1-5">Reportez et modulez vos échéances simplement. On
                    vous accompagne dans toutes les étapes du financement
                    de votre projet.</p>
            </div>
            <div class="w-100 px-20 mt-10">
                <a href="" class="btn btn-circle btn-lg btn-light w-300px text-bank fw-bolder">En savoir plus</a>
            </div>
        </div>
    </div>
    <div class="d-flex flex-center w-100 my-10">
        <div class="d-flex">
            <div class="d-flex flex-row">
                <div class="card card-flush shadow-sm w-450px rounded me-10">
                    <img src="https://particuliers.societegenerale.fr/static/Particuliers/Bannieres-Revive/Content/2022/04/fil-rouge-Paylib-entre-amis/carte-hp-1x.webp" alt="">

                    <div class="card-body py-5 bg-white h-200px">
                        <div class="mb-5">
                            <div class="badge badge-info badge-lg">Virement</div>
                        </div>
                        <div class="fs-1 text-bank fw-bolder mb-10">SAFEPAY entre amis</div>
                        <div class="text-muted">Envoyez de l’argent instantanément vers un numéro de mobile. Voir conditions sur le site.</div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="" class="btn btn-link text-bank fw-bolder">Je découvre <i class="fa-solid fa-arrow-right"></i> </a>
                    </div>
                </div>
                <div class="card card-flush shadow-sm w-450px rounded me-10">
                    <img src="https://particuliers.societegenerale.fr/static/Particuliers/Bannieres-Revive/Content/2022/03/complement-sante/ComplSante_Card_Client-1x.webp" alt="">

                    <div class="card-body py-5 bg-white h-200px">
                        <div class="mb-5">
                            <div class="badge badge-light badge-lg">Assurance santé</div>
                        </div>
                        <div class="fs-1 text-bank fw-bolder mb-10 l-1-5">Votre Complémentaire Santé à partir de 15,12€ par mois</div>
                        <div class="text-muted">Vous protéger, c'est aussi notre métier</div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="" class="btn btn-link text-bank fw-bolder">Découvrir notre offre <i class="fa-solid fa-arrow-right"></i> </a>
                    </div>
                </div>
                <div class="card card-flush shadow-sm w-450px rounded me-10">
                    <img src="https://particuliers.societegenerale.fr/static/Particuliers/assets/img/fraude/card-fraude-D.jpg" alt="">

                    <div class="card-body py-5 bg-white h-200px">
                        <div class="mb-5">
                            <div class="badge badge-light badge-lg">En vidéo</div>
                        </div>
                        <div class="fs-1 text-bank fw-bolder mb-10 l-1-5">Fraude en ligne</div>
                        <div class="text-muted">Apprenez à les repérer et à vous en protéger. Explications avec notre expert Gregory.</div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="" class="btn btn-link text-bank fw-bolder">Voir la vidéo <i class="fa-solid fa-arrow-right"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends("front.layouts.app")

@section("content")
    <div class="d-flex flex-row w-100 min-h-350px min-h-lg-500px bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg" style="background-image: url('/assets/media/svg/illustrations/landing.svg')">
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
@endsection

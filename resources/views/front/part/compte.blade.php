@extends("front.layouts.app")

@section("content")
    <div class="d-flex flex-row w-100 min-h-350px min-h-lg-500px bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg" style="background-image: url('/assets/media/svg/illustrations/landing.svg')">
        <div class="d-flex flex-column w-75">
            <div class="d-flex flex-row p-20 align-items-center">
                <div class="badge badge-lg badge-info me-10">Exclusivité</div>
                <div class="text-info uppercase ">Jusqu'au 30 décembre 2022 inclus</div>
            </div>
            <div class="fs-2tx fw-bolder text-white uppercase px-20 underline mb-20">OFFRES SURPRISES JUSQU’À 160 € OFFERTS</div>
            <div class="d-flex flex-row justify-content-start align-items-center px-20">
                <p class="text-white fs-2x l-1-5">
                    <strong>On vous offre 80 € pour l’ouverture de votre compte et 80€ supplémentaires</strong> en cas de mobilité bancaire avec notre service Bienvenue.<br>
                    <strong>Vous n’avez pas encore de carte chez nous ?</strong> La première année est gratuite*.
                </p>
            </div>
            <div class="w-100 px-20 mt-10">
                <a href="{{ route('auth.register.firstStep') }}" class="btn btn-circle btn-lg btn-light w-300px text-bank fw-bolder">En profiter dès maintenant</a>
            </div>
        </div>
        <img src="https://particuliers.societegenerale.fr/static/Particuliers/assets/img/campagnes/2022/11/black-friday/black-friday-D.webp" alt="" class="img-fluid h-100">
    </div>
@endsection

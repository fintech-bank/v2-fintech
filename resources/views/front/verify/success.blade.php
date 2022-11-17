@extends("front.layouts.app")

@section("content")
    @if($sector == 'identity')
        <!--begin::Alert-->
        <div class="alert alert-dismissible bg-light-success d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
            <!--begin::Icon-->
            <i class="fa-solid fa-check-circle fs-5tx text-success mb-5"></i>
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="text-center">
                <!--begin::Title-->
                <h1 class="fw-bold mb-5">Identité Validé</h1>
                <!--end::Title-->

                <!--begin::Separator-->
                <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                <!--end::Separator-->

                <!--begin::Content-->
                <div class="mb-9 text-dark">
                    Votre identité à été validé et nous en remercions
                </div>
                <!--end::Content-->

                <!--begin::Buttons-->
                <div class="d-flex flex-center flex-wrap">
                    <a href="#" class="btn btn-success m-2" onclick="window.close()">Fermer l'onglet</a>
                </div>
                <!--end::Buttons-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
    @elseif($sector == 'address')
        <!--begin::Alert-->
        <div class="alert alert-dismissible bg-light-success d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
            <!--begin::Icon-->
            <i class="fa-solid fa-check-circle fs-5tx text-success mb-5"></i>
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="text-center">
                <!--begin::Title-->
                <h1 class="fw-bold mb-5">Adresse postal Validé</h1>
                <!--end::Title-->

                <!--begin::Separator-->
                <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                <!--end::Separator-->

                <!--begin::Content-->
                <div class="mb-9 text-dark">
                    Votre adresse postal à été validé et nous en remercions
                </div>
                <!--end::Content-->

                <!--begin::Buttons-->
                <div class="d-flex flex-center flex-wrap">
                    <a href="#" class="btn btn-success m-2" onclick="window.close()">Fermer l'onglet</a>
                </div>
                <!--end::Buttons-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
    @else
        <!--begin::Alert-->
        <div class="alert alert-dismissible bg-light-success d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
            <!--begin::Icon-->
            <i class="fa-solid fa-check-circle fs-5tx text-success mb-5"></i>
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="text-center">
                <!--begin::Title-->
                <h1 class="fw-bold mb-5">Information de revenue Validé</h1>
                <!--end::Title-->

                <!--begin::Separator-->
                <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                <!--end::Separator-->

                <!--begin::Content-->
                <div class="mb-9 text-dark">
                    Vos informations de revenue ont été validée et nous en remercions
                </div>
                <!--end::Content-->

                <!--begin::Buttons-->
                <div class="d-flex flex-center flex-wrap">
                    <a href="#" class="btn btn-success m-2" onclick="window.close()">Fermer l'onglet</a>
                </div>
                <!--end::Buttons-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
    @endif
@endsection

@section("scripts")
@endsection

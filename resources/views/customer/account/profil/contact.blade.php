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
        <x-base.underline
            title="Profil de {{ $customer->info->full_name }}"
            size="4"
            size-text="fs-2hx"
            color="bank"
            class="w-100 my-5 uppercase" />


        <x-base.underline
            title="Adresse e-mail"
            size="4"
            size-text="fs-1"
            color="secondary"
            class="w-100 my-5" />

        <p class="fw-bolder">Pour mieux vous accompagner au quotidien comme dans vos projets d’avenir, nous souhaitons recueillir votre adresse e-mail. Vous serez ainsi informé de nos actualités et de nos offres promotionnelles susceptibles de vous intéresser.</p>
        <div class="d-flex flex-row justify-content-around">
            <div class="">Adresse e-mail personnel</div>
            <div class="">{{ $customer->user->email }}</div>
        </div>
        <div class="d-flex flex-center w-50">
            <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>
															<path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"></path>
														</svg>
													</span>
                <!--end::Svg Icon-->
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-primary">This is an alert</h4>
                    <span>The alert component can be used to highlight certain parts of your page for higher content visibility.</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection

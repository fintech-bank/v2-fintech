@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="d-flex flex-center w-100">
            <x-base.underline
                title="<i class='fa-solid fa-calendar fs-2x text-bank me-4'></i> Mes rendez-vous"
                color="bank"
                size="4"
                size-text="fs-2x"
                class="w-auto my-5"/>
        </div>
        <div class="d-flex flex-center w-50 bg-gray-300 rounded p-5 mx-auto">
            @if($events->count() == 0)
                <div class="d-flex flex-center w-100">
                    <i class="fa-solid fa-exclamation-circle text-warning opacity-15 me-5"></i> Vous n'avez aucun rendez-vous programmé
                </div>
            @else
                @foreach($events as $event)
                    <a href="{{ route('customer.account.agenda.show', $event->id) }}" class="d-flex flex-row justify-content-between bg-white align-items-center shadow rounded h-75px mb-10 hover-zoom text-black w-100">
                        <div class="d-flex flex-row align-items-center">
                            <div class="p-0 w-8px bg-bank h-75px rounded-start me-5">&nbsp;</div>
                            <div class="d-flex flex-column">
                                <span class="fs-2 fw-bold">M. MOCKELYN Maxime</span>
                                <div class="fs-5">{{ formatDateFrench(\Carbon\Carbon::createFromTimestamp(strtotime("2022-12-01 10:00:00")), true) }} ({{ \Carbon\Carbon::createFromTimestamp(strtotime("2022-12-01 10:00:00"))->longAbsoluteDiffForHumans(\Carbon\Carbon::createFromTimestamp(strtotime("2022-12-01 11:00:00"))) }})</div>
                                <div class="fs-5 text-muted">Par téléphone</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
        <div class="d-flex flex-center w-50 p-5 mx-auto">
            <button class="btn btn-lg btn-circle btn-bank" data-bs-toggle="modal" data-bs-target="#newEvent">Prendre un rendez-vous</button>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="newEvent">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Prendre rendez-vous</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <!--begin::Stepper-->
                    <div class="stepper stepper-pills" id="stepper_rdv">
                        <!--begin::Nav-->
                        <div class="stepper-nav flex-center flex-wrap mb-10">
                            <!--begin::Step 1-->
                            <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">1</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Votre conseiller
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 1-->

                            <!--begin::Step 2-->
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">2</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Votre motif
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 2-->

                            <!--begin::Step 3-->
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">3</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Type de RDV
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 3-->

                            <!--begin::Step 4-->
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">4</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Votre disponibilité
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 4-->
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">5</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Confirmation
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                        </div>
                        <!--end::Nav-->

                        <form class="form w-lg-500px mx-auto" action="/api/calendar" novalidate="novalidate" id="kt_stepper_example_basic_form" method="post">
                            <div class="mb-5">
                                <div class="flex-column current" data-kt-stepper-element="content">
                                    <div class="d-flex flex-center">
                                        <x-base.underline
                                            title="Vous souhaitez échanger avec"
                                            color="bank"
                                            size="2"
                                            size-text="fs-1" class="w-auto mb-10"/>
                                    </div>
                                    @foreach(\App\Models\User::where('agent', 1)->where('agency_id', auth()->user()->customers->agency->id)->get() as $agent)
                                        <div class="mb-2">
                                            <!--begin::Option-->
                                            <input type="radio" class="btn-check" name="agent_id" value="{{ $agent->id }}"  id="agent_{{ $agent->id }}"/>
                                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="agent_{{ $agent->id }}">
                                                    <span class="d-block fw-semibold text-start">
                                                        <span class="text-dark fw-bold d-block fs-3">{{ $agent->name }}</span>
                                                        <span class="text-muted fw-semibold fs-6">Conseiller de clientèle</span>
                                                    </span>
                                            </label>
                                            <!--end::Option-->
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex-column " data-kt-stepper-element="content">
                                    <div class="d-flex flex-center">
                                        <x-base.underline
                                            title="Votre besoin concerne"
                                            color="bank"
                                            size="2"
                                            size-text="fs-1" class="w-auto mb-10"/>
                                    </div>
                                    <div class="m-0" id="inputReason">
                                        @foreach(\App\Models\Core\Event::getDataReason() as $reason)
                                            <div class="d-flex flex-row justify-content-between w-100">
                                                <input type="radio" class="btn-check" name="reason" value="{{ $reason['name'] }}" checked="checked"  id="{{ Str::slug($reason['name']) }}"/>
                                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="{{ Str::slug($reason['name']) }}">
                                                    <span class="d-block fw-semibold text-start">
                                                        <span class="text-dark fw-bold d-block fs-3">{{ $reason['name'] }}</span>
                                                    </span>
                                                    <i class="fa-solid fa-chevron-right fs-4x ms-4"></i>
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <!--end::Group-->

                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                        Back
                                    </button>
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Wrapper-->
                                <div>
                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="submit">
                                        <span class="indicator-label">
                                            Submit
                                        </span>
                                        <span class="indicator-progress">
                                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>

                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                        Suivant
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Stepper-->
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.agenda.index")
@endsection

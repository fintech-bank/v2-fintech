@extends("customer.layouts.app")

@section("css")
@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app">
        <div class="row">
            <div class="col-md-3 col-sm-12 mb-5">
                <div class="card shadow-sm mb-10">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-user text-black me-2"></i> Agent</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row align-items-center">
                            <div class="symbol symbol-50px symbol-circle me-5">
                                {!! $event->agent->user->avatar_symbol !!}
                            </div>
                            <div class="d-flex flex-column">
                                <strong>{{ $event->agent->full_name }}</strong>
                                <div class="text-muted"><i>{{ $event->agent->poste }}</i></div>
                            </div>
                        </div>
                        <div class="separator separator-dotted border-gray-200 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div class="d-flex flex-row">
                                <div class="symbol symbol-50px symbol-circle me-5">
                                    <div class="symbol-label fs-2 fw-semibold text-success"><i class="fa-solid fa-phone"></i></div>
                                </div>
                                <div class="d-flex flex-column">
                                    <strong>Contact téléphonique</strong>
                                    <div class="text-muted"><i>{{ $event->agent->phone }}</i></div>
                                </div>
                            </div>
                            <a href="tel:{{ $event->agent->phone }}" class="btn btn-sm btn-success btn-icon"><i class="fa-solid fa-phone"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <div class="fs-6">Votre rendez-vous est dans:</div>
                        <div class="fs-2x fw-bolder text-info">{{ $event->start_at->longAbsoluteDiffForHumans() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Information sur votre rendez-vous</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-ban text-white me-2"></i> Annuler
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bolder">Votre besoin concerne</div>
                            </div>
                            <div class="col">
                                {{ $event->reason }}
                            </div>
                        </div>
                        <div class="separator separator-dashed border-gray-200 my-3"></div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bolder">Et plus particulièrement</div>
                            </div>
                            <div class="col">
                                {{ $event->subreason }}
                            </div>
                        </div>
                        <div class="separator separator-dashed border-gray-200 my-3"></div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bolder">Sur quoi va porter ce rendez-vous ?</div>
                            </div>
                            <div class="col">
                                {{ $event->question }}
                            </div>
                        </div>
                        <div class="separator separator-dashed border-gray-200 my-3"></div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bolder">Canal de contact</div>
                            </div>
                            <div class="col">
                                @if($event->canal == 'phone')
                                    <i class="fa-solid {{ $event->getCanal('icon') }} text-black me-2"></i> {{ $event->getCanal('text') }}
                                @else
                                    <i class="fa-solid {{ $event->getCanal('icon') }} text-black me-2"></i> {{ $event->getCanal('text') }}
                                    {{ $event->agent->agency->address_line }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12 mb-5">
                <div class="card" id="kt_chat_messenger">
                    <!--begin::Card header-->
                    <div class="card-header" id="kt_chat_messenger_header">
                        <!--begin::Title-->
                        <div class="card-title">
                            <!--begin::User-->
                            <div class="d-flex justify-content-center flex-column me-3">
                                <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{ $event->agent->full_name }} <i class="text-muted">{{ $event->agent->poste }}</i></a>
                                <!--begin::Info-->
                                @if($event->agent->user->is_online)
                                    <div class="mb-0 lh-1">
                                        <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                                        <span class="fs-7 fw-semibold text-muted">Disponible</span>
                                    </div>
                                @else
                                    <div class="mb-0 lh-1">
                                        <span class="badge badge-secondary badge-circle w-10px h-10px me-1"></span>
                                        <span class="fs-7 fw-semibold text-muted">Indisponible</span>
                                    </div>
                                @endif

                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body" id="kt_chat_messenger_body">
                        <!--begin::Messages-->
                        <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px" style="max-height: 372px;">
                            @foreach($event->messages as $message)
                                <div class="d-flex {{ $message->agent_id != null ? 'justify-content-start' : 'justify-content-end' }} mb-10">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column {{ $message->agent_id != null ? 'align-items-start' : 'align-items-end' }}">
                                        <!--begin::User-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                {!! $message->agent_id != null ? $message->agent->user->avatar_symbol : $message->user->avatar_symbol !!}
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-3">
                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{ $message->agent_id != null ? $message->agent->full_name : "Vous" }}</a>
                                                <span class="text-muted fs-7 mb-1">{{ $message->created_at->shortAbsoluteDiffForHumans() }}</span>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::Text-->
                                        <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">
                                            {{ $message->message }}
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                            @endforeach
                            <!--begin::Message(in)-->
                            <div class="d-flex justify-content-start mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-start">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="/metronic8/demo1/assets/media/avatars/300-25.jpg">
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Details-->
                                        <div class="ms-3">
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                            <span class="text-muted fs-7 mb-1">2 mins</span>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">How likely are you to recommend our company to your friends and family ?</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(in)-->
                            <!--begin::Message(out)-->
                            <div class="d-flex justify-content-end mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-end">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Details-->
                                        <div class="me-3">
                                            <span class="text-muted fs-7 mb-1">5 mins</span>
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="/metronic8/demo1/assets/media/avatars/300-1.jpg">
                                        </div>
                                        <!--end::Avatar-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(out)-->
                            <!--begin::Message(in)-->
                            <div class="d-flex justify-content-start mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-start">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="/metronic8/demo1/assets/media/avatars/300-25.jpg">
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Details-->
                                        <div class="ms-3">
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                            <span class="text-muted fs-7 mb-1">1 Hour</span>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Ok, Understood!</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(in)-->
                            <!--begin::Message(out)-->
                            <div class="d-flex justify-content-end mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-end">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Details-->
                                        <div class="me-3">
                                            <span class="text-muted fs-7 mb-1">2 Hours</span>
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="/metronic8/demo1/assets/media/avatars/300-1.jpg">
                                        </div>
                                        <!--end::Avatar-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text">You’ll receive notifications for all issues, pull requests!</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(out)-->
                            <!--begin::Message(in)-->
                            <div class="d-flex justify-content-start mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-start">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="/metronic8/demo1/assets/media/avatars/300-25.jpg">
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Details-->
                                        <div class="ms-3">
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                            <span class="text-muted fs-7 mb-1">3 Hours</span>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">You can unwatch this repository immediately by clicking here:
                                        <a href="https://keenthemes.com">Keenthemes.com</a></div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(in)-->
                            <!--begin::Message(out)-->
                            <div class="d-flex justify-content-end mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-end">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Details-->
                                        <div class="me-3">
                                            <span class="text-muted fs-7 mb-1">4 Hours</span>
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="/metronic8/demo1/assets/media/avatars/300-1.jpg">
                                        </div>
                                        <!--end::Avatar-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text">Most purchased Business courses during this sale!</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(out)-->
                            <!--begin::Message(in)-->
                            <div class="d-flex justify-content-start mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-start">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="/metronic8/demo1/assets/media/avatars/300-25.jpg">
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Details-->
                                        <div class="ms-3">
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                            <span class="text-muted fs-7 mb-1">5 Hours</span>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Company BBQ to celebrate the last quater achievements and goals. Food and drinks provided</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(in)-->
                            <!--begin::Message(template for out)-->
                            <div class="d-flex justify-content-end mb-10 d-none" data-kt-element="template-out">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-end">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Details-->
                                        <div class="me-3">
                                            <span class="text-muted fs-7 mb-1">Just now</span>
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="/metronic8/demo1/assets/media/avatars/300-1.jpg">
                                        </div>
                                        <!--end::Avatar-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text"></div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(template for out)-->
                            <!--begin::Message(template for in)-->
                            <div class="d-flex justify-content-start mb-10 d-none" data-kt-element="template-in">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-start">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="/metronic8/demo1/assets/media/avatars/300-25.jpg">
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Details-->
                                        <div class="ms-3">
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                            <span class="text-muted fs-7 mb-1">Just now</span>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Right before vacation season we have the next Big Deal for you.</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(template for in)-->
                        </div>
                        <!--end::Messages-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer pt-4" id="kt_chat_messenger_footer" data-dashlane-rid="a924d13f23dd502b" data-form-type="">
                        <!--begin::Input-->
                        <textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message" data-dashlane-rid="10dc993e7b8789b9" data-form-type=""></textarea>
                        <!--end::Input-->
                        <!--begin:Toolbar-->
                        <div class="d-flex flex-stack">
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center me-2">
                                <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" aria-label="Coming soon" data-bs-original-title="Coming soon" data-kt-initialized="1" data-dashlane-rid="ef3016055d9bcf69" data-dashlane-label="true" data-form-type="">
                                    <i class="bi bi-paperclip fs-3"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" aria-label="Coming soon" data-bs-original-title="Coming soon" data-kt-initialized="1" data-dashlane-rid="e62a89fb1c9b060a" data-dashlane-label="true" data-form-type="">
                                    <i class="bi bi-upload fs-3"></i>
                                </button>
                            </div>
                            <!--end::Actions-->
                            <!--begin::Send-->
                            <button class="btn btn-primary" type="button" data-kt-element="send" data-dashlane-rid="cc15ad53c943e58d" data-dashlane-label="true" data-form-type="">Send</button>
                            <!--end::Send-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card footer-->
                </div>
            </div>
        </div>


    </div>
@endsection

@section("script")
    @include("customer.scripts.account.agenda.show")
@endsection

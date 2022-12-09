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
                            <x-base.button
                                class="btn-sm btn-danger btnCancelRdv"
                                text="<i class='fa-solid fa-ban text-white me-2'></i> Annuler"
                                :datas="[['name' => 'event', 'value' => $event->id]]" />

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
                    <div class="card-header" id="kt_chat_messenger_header">
                        <div class="card-title">
                            <div class="d-flex justify-content-center flex-column me-3">
                                <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{ $event->agent->full_name }} <i class="text-muted">{{ $event->agent->poste }}</i></a>
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
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="kt_chat_messenger_body">
                        <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px" style="max-height: 372px;">
                            @foreach($event->messages as $message)
                                <div class="d-flex {{ $message->agent_id != null ? 'justify-content-start' : 'justify-content-end' }} mb-10">
                                    <div class="d-flex flex-column {{ $message->agent_id != null ? 'align-items-start' : 'align-items-end' }}">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="symbol symbol-35px symbol-circle">
                                                @if($message->agent_id !== null)
                                                    {!! $message->agent->user->avatar_symbol !!}
                                                @else
                                                    {!! Gravatar::get('nomail@mail.com') !!}
                                                @endif
                                            </div>
                                            <div class="ms-3">
                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{ $message->agent_id != null ? $message->agent->full_name : "Vous" }}</a>
                                                <span class="text-muted fs-7 mb-1">{{ $message->created_at->shortAbsoluteDiffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">
                                            {{ $message->message }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                        <form id="formPostEventMessage" action="/api/calendar/{{ $event->id }}/message" method="post">
                            @csrf
                            <input type="hidden" name="provider" value="customer">
                            <input type="hidden" name="provider_id" value="{{ $event->user->id }}">
                            <textarea class="form-control form-control-flush mb-3" rows="1" name="message" data-kt-element="input" placeholder="Taper votre message"></textarea>
                            <div class="d-flex flex-stack">
                                <x-form.button text="Envoyer" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section("script")
    @include("customer.scripts.account.agenda.show")
@endsection

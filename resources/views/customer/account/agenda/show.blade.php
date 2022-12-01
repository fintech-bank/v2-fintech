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
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.agenda.show")
@endsection

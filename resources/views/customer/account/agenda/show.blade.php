@extends("customer.layouts.app")

@section("css")
@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="row">
            <div class="col-md-4 col-sm-12 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-user text-black me-2"></i> Agent</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="symbol symbol-50px symbol-circle">
                                {!! $event->agent->user->avatar_symbol !!}
                            </div>
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

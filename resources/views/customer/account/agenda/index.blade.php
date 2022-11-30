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
            <button class="btn btn-lg btn-circle btn-bank">Prendre un rendez-vous</button>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.agenda.index")
@endsection

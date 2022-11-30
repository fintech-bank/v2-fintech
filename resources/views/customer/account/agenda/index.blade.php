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
            <div class="d-flex flex-row justify-content-between bg-white align-items-center shadow rounded h-75px mb-10 hover-zoom text-black w-100">
                <div class="d-flex flex-row align-items-center">
                    <div class="p-0 w-8px bg-bank h-75px rounded-start me-5">&nbsp;</div>
                    <div class="d-flex flex-column">
                        <span class="fs-2 fw-bold">M. MOCKELYN Maxime</span>
                        <div class="fs-4">{{ formatDateFrench("2022-12-01 10:00:00", true) }}</div>
                    </div>
                </div>
            </div>
            @foreach($events as $event)
                <div class="d-flex flex-row justify-content-between align-items-center shadow rounded h-75px mb-10 hover-zoom text-black">
                    <div class="d-flex flex-row align-items-center">
                        <div class="p-0 w-8px bg-bank h-75px rounded-start me-5">&nbsp;</div>
                        <div class="d-flex flex-column">
                            <span class="fs-2 fw-bold">{{ $event->reason }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.agenda.index")
@endsection

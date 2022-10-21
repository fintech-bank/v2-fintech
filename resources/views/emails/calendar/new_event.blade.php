@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-400 p-5 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Nouveau rendez-vous en agence</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
    <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ $attendee->user->name }}</span>
            <p>Un rendez-vous à été programmer, voici les informations sur ce rendez-vous.</p>
            <ul class="mb-5">
                <li>Vous avez rendez-vous le <strong>{{ $event->start_at->format('d/m/Y à H:i') }}</strong></li>
                <li>Ce rendez-vous à pour objectif: <em>{{ $event->description ?? 'Aucun objectif particulier' }}</em></li>
                <li>Ce rendez-vous durera <strong>{{ $event->start_at->diffForHumans($event->end_at) }}</strong></li>
                @if($event->lieu)
                    <li>Ce rendez-vous aura lieu: <strong>{{ $event->lieu }}</strong></li>
                @endif
            </ul>

            <div class="d-flex flex-center"><a href="#" class="btn btn-bank"><i class="fa-solid fa-calendar me-2"></i> Mon rendez-vous</a></div>

        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection


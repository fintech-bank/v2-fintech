@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        @foreach($cards as $card)
            <a href="{{ route('customer.compte.card.show', $card->id) }}" class="d-flex flex-row justify-content-between align-items-center p-5 rounded border border-2 bg-gray-300 text-black hover-zoom">
                <span class="d-flex flex-row fs-2 align-items-center">
                    <span class="symbol symbol-30px symbol-2by3">
                        <img src="/storage/card/{{ $card->support->slug }}.png" alt="">
                    </span>
                    <span class="fw-bolder">CB Visa </span>
                    <span class="text-muted">{{ $card->number_card_oscure }}</span>
                </span>
            </a>
        @endforeach
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.index")
@endsection

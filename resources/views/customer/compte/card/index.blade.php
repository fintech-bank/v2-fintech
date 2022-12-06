@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        @foreach($wallets as $wallet)
            @foreach($wallet->cards as $card)
                <a href="{{ route('customer.compte.card.show', [$wallet->id, $card->id]) }}" class="d-flex flex-row justify-content-between align-items-center p-5 rounded border border-2 bg-gray-300 text-black hover-zoom">
                    <span class="d-flex flex-row align-items-center">
                        <span class="symbol symbol-30px symbol-2by3">
                            <img src="/storage/card/{{ $card->support->slug }}.png" alt="">
                        </span>
                        <span class="fw-bolder me-5">CB Visa </span>
                        <span class="text-muted">{{ $card->number_card_oscure }}</span>
                    </span>
                    {!! $card->status_label !!}
                </a>
            @endforeach
        @endforeach
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.index")
@endsection

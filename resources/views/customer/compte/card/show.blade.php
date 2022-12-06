@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="d-flex flex-center w-75 rounded rounded-2 bg-white p-5">
            <div class="d-flex flex-row">
                <div class="w-50">
                    <img src="/storage/card/{{ $card->slug }}.png" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.index")
@endsection

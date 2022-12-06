@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="d-flex flex-wrap align-items-center w-75 rounded rounded-2 bg-white p-5">
            <div class="d-flex flex-row">
                <div class="w-50  m-0 p-0">
                    <img src="/storage/card/{{ $card->support->slug }}.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.index")
@endsection

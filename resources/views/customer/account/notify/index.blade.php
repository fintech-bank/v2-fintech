@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Fil de notification</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="card shadow-sm">
            <div class="card-body bg-gray-300">
                @foreach($notifications as $notification)
                    {{$notification}}
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.notify.index")
@endsection

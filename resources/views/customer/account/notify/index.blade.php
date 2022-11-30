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
    <div id="app" class="rounded container">
        <div class="card shadow-sm rounded">
            <div class="card-body bg-gray-300 rounded">
                @foreach($notifications as $notification)
                    <a href="" class="card shadow-sm mb-10 text-black">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa-solid {{ $notification->data['icon'] }} me-5"></i> {{ $notification->data['category'] }}</h3>
                            <div class="card-toolbar text-muted">
                                {{ \Carbon\Carbon::createFromTimestamp(strtotime($notification->data['time']))->format("d/m/Y") }}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between">
                                <div class="text-muted fs-1">{{ $notification->data['title'] }}</div>
                                <!--<a href="" class="btn-link btn-icon btn-active-primary"><i class="fa-solid fa-arrow-left"></i> </a>-->
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.notify.index")
@endsection

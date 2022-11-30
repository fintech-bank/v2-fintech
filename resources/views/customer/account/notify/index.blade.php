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
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa-solid {{ $notification->data['icon'] }} me-5"></i> </h3>
                            <div class="card-toolbar">
                                <!--<button type="button" class="btn btn-sm btn-light">
                                    Action
                                </button>-->
                            </div>
                        </div>
                        <div class="card-body">
                            
                        </div>   
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.notify.index")
@endsection

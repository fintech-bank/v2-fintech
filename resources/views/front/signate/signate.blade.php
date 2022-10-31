@extends("front.layouts.app")

@section("content")
    <div class="d-flex flex-row justify-content-between align-items-center w-100 bg-white p-5 shadow-lg">
        <div class="fw-bolder fs-2tx">{{ $document->name }}</div>
        <div class="">
            <x-base.button
                text="<i class='fa-solid fa-check-circle'></i> Accepter"
                class="btn btn-success"
            />
            <x-base.button
                text="<i class='fa-solid fa-xmark-circle'></i> Refuser"
                class="btn btn-danger"
            />
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <button class="btn btn-rounded btn-light btn-sm"><i class="fa-solid fa-arrow-left"></i> </button>
                <button class="btn btn-rounded btn-light btn-sm"><i class="fa-solid fa-arrow-right"></i> </button>
            </div>
            <div class="card-toolbar">
                <!--<button type="button" class="btn btn-sm btn-light">
                    Action
                </button>-->
            </div>
        </div>
        <div class="card-body">

        </div>
    </div>
@endsection

@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Demandes & Documents</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="d-flex flex-center w-100">
            <div class="btn-group btn-group-lg">
                @foreach(\App\Models\Core\DocumentCategory::with('documents')->get() as $category)
                    <a href="{{ route('customer.account.documents.category', $category->id) }}" class="btn btn-lg {{ Route::is('customer.account.documents.category') ? 'btn-primary' : 'btn-secondary' }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.notify.index")
@endsection

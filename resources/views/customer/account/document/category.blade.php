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
        <div class="d-flex flex-center w-100 mb-20">
            <div class="btn-group btn-group-lg">
                @foreach(\App\Models\Core\DocumentCategory::with('documents')->get() as $category)
                    <a href="{{ route('customer.account.documents.category', $category->id) }}" class="btn btn-lg {{ Route::is('customer.account.documents.category') && $category->id == $cat->id ? 'btn-primary' : 'btn-secondary' }}">{{ $category->name }}</a>
                @endforeach
                <a href="{{ route('customer.account.documents.externe.index') }}" class="btn btn-lg {{ Route::is('customer.account.documents.externe.index') ? 'btn-primary' : 'btn-secondary' }}">Autres Documents</a>
                <a href="{{ route('customer.account.documents.request.index') }}" class="btn btn-lg {{ Route::is('customer.account.documents.request.index') ? 'btn-primary' : 'btn-secondary' }}">Mes Requêtes</a>
            </div>
        </div>

        @foreach($documents as $document)
            <a href="" class="d-flex flex-row justify-content-between align-items-center shadow rounded h-75px mb-10 hover-zoom">
                <div class="d-flex flex-row align-items-center">
                    <div class="p-0 w-8px bg-primary h-75px rounded-start me-5">&nbsp;</div>
                    <span class="fs-2 fw-bold">{{ $document->name }}</span>
                </div>
                <i class="fa-solid fa-download fs-2"></i>
            </a>
        @endforeach
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.notify.index")
@endsection

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
            <div class="btn-group btn-group-lg mb-10">
                @foreach(\App\Models\Core\DocumentCategory::with('documents')->get() as $category)
                    <a href="{{ route('customer.account.documents.category', $category->id) }}" class="btn btn-lg {{ Route::is('customer.account.documents.category') ? 'btn-primary' : 'btn-secondary' }}">{{ $category->name }}</a>
                @endforeach
                <a href="{{ route('customer.account.documents.externe.index') }}" class="btn btn-lg {{ Route::is('customer.account.documents.externe.index') ? 'btn-primary' : 'btn-secondary' }}">Autres Documents</a>
                <a href="{{ route('customer.account.documents.request.index') }}" class="btn btn-lg {{ Route::has(['customer.account.documents.request.index', 'customer.account.documents.request.show']) ? 'btn-primary' : 'btn-secondary' }}">Mes Requêtes</a>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">{{ $request->reference }} - {{ $request->sujet }}</h3>
                <div class="card-toolbar">
                    <div class="d-flex flex-column">
                        {!! $request->status_label !!}
                        {{ $request->updated_at->format("d/m/Y") }}
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! $request->commentaire !!}
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.notify.index")
@endsection

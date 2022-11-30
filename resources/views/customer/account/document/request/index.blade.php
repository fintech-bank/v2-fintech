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
                <a href="{{ route('customer.account.documents.request.index') }}" class="btn btn-lg {{ Route::is('customer.account.documents.request.index') ? 'btn-primary' : 'btn-secondary' }}">Mes Requêtes</a>
            </div>
        </div>
        <div class="mb-10">
            <x-base.underline
                title="Mes demandes en attente"
                class="w-100 my-5 "
                size="4"
                size-text="fs-1"
                color="warning" />

            @if($requests->where('status', 'progress')->count() != 0)
                @foreach($requests->where('status', 'waiting')->get() as $request)
                    <a href="{{ route('customer.account.documents.request.show', $request->reference) }}" class="d-flex flex-row justify-content-between align-items-center shadow rounded h-75px mb-10 hover-zoom text-black" target="_blank">
                        <div class="d-flex flex-row align-items-center">
                            <div class="p-0 w-8px bg-{{ $request->getStatus('color') }} h-75px rounded-start me-5">&nbsp;</div>
                            <div class="d-flex flex-column">
                                <span class="fs-2 fw-bold">{{ $request->sujet }}</span>
                                <div class="text-muted fs-6">{{ $request->updated_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <span class="d-flex flex-row">
                        <span class="">{{ $request->model_data }}</span>
                        <span class="vr mx-2 "></span>
                        <i class="fa-solid fa-arrow-right-long fs-2 me-5"></i>
                    </span>
                    </a>
                @endforeach
            @else
                <div class="d-flex flex-center w-100 p-5">
                    Aucune requête en attente pour le moment !
                </div>
            @endif

            <div class="separator border-gray-300 my-10"></div>

            <x-base.underline
                class="w-100 my-5 "
                size="4"
                size-text="fs-1"
                color="warning"
                title="Mes demandes en traitement" />

            @if($requests->where('status', 'progress')->count() != 0)
                @foreach($requests->where('status', 'progress')->get() as $request)
                    <a href="{{ route('customer.account.documents.request.show', $request->reference) }}" class="d-flex flex-row justify-content-between align-items-center shadow rounded h-75px mb-10 hover-zoom text-black" target="_blank">
                        <div class="d-flex flex-row align-items-center">
                            <div class="p-0 w-8px bg-{{ $request->getStatus('color') }} h-75px rounded-start me-5">&nbsp;</div>
                            <div class="d-flex flex-column">
                                <span class="fs-2 fw-bold">{{ $request->sujet }}</span>
                                <div class="text-muted fs-6">{{ $request->updated_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <span class="d-flex flex-row">
                        <span class="">{{ $request->model_data }}</span>
                        <span class="vr mx-2 "></span>
                        <i class="fa-solid fa-arrow-right-long fs-2 me-5"></i>
                    </span>
                    </a>
                @endforeach
            @else
                <div class="d-flex flex-center w-100 p-5">
                    Aucune requête en traitement pour le moment !
                </div>
            @endif

            <div class="separator border-gray-300 my-10"></div>

            <x-base.underline
                class="w-100 my-5 "
                size="4"
                size-text="fs-1"
                color="success"
                title="Mes demandes traités" />

            @if($requests->where('status', 'terminated')->count() != 0)
                @foreach($requests->where('status', 'terminated')->get() as $request)
                    <a href="{{ route('customer.account.documents.request.show', $request->reference) }}" class="d-flex flex-row justify-content-between align-items-center shadow rounded h-75px mb-10 hover-zoom text-black" target="_blank">
                        <div class="d-flex flex-row align-items-center">
                            <div class="p-0 w-8px bg-{{ $request->getStatus('color') }} h-75px rounded-start me-5">&nbsp;</div>
                            <div class="d-flex flex-column">
                                <span class="fs-2 fw-bold">{{ $request->sujet }}</span>
                                <div class="text-muted fs-6">{{ $request->updated_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <span class="d-flex flex-row">
                        <span class="">{{ $request->model_data }}</span>
                        <span class="vr mx-2 "></span>
                        <i class="fa-solid fa-arrow-right-long fs-2 me-5"></i>
                    </span>
                    </a>
                @endforeach
            @else
                <div class="d-flex flex-center w-100 p-5">
                    Aucune requête terminée pour le moment !
                </div>
            @endif
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.notify.index")
@endsection

@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Mes Notifications</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-muted text-hover-primary">Administration</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Mes Notifications</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="{{ route('admin.account.notify.index') }}" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary"><i class="fa-solid fa-cirlce-left"></i> Retour</a>
    </div>
@endsection

@section("content")
    <div class="card card-flush shadow-sm">
        <div class="card-header bg-light-{{ $notify['data']['color'] }}">
            <h3 class="card-title text-{{ $notify['data']['color'] }}"><i class="fa-solid fa-{{ $notify['data']['icon'] }} fa-lg me-3 text-{{ $notify['data']['color'] }}"></i> {{ $notify['data']['title'] }}</h3>
            <div class="card-toolbar">
                <div class="">{{ $notify->created_at->format('d/m/Y') }}</div>
            </div>
        </div>
        <div class="card-body py-5">
            <div class="fs-3 fw-bolder">{{ $notify['data']['text'] }}</div>
            {!! $notify->content !!}
        </div>
    </div>
@endsection

@section("script")

@endsection

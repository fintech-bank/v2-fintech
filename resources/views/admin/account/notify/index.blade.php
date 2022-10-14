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
    <!--<div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
    </div>-->
@endsection

@section("content")
    @for($i = 0; $i <= 365; $i++)
        @if($user->notifications()->whereBetween('created_at', [now()->subDays($i)->startOfDay(), now()->subDays($i)->endOfDay()])->count() != 0)
            <div class="fs-4 fw-bolder mb-6">{{ now()->subDays($i)->startOfDay()->format('d/m/Y') }}</div>
            @foreach($user->notifications()->whereBetween('created_at', [now()->subDays($i)->startOfDay(), now()->subDays($i)->endOfDay()])->get() as $notify)
                <div class="card card-flush shadow-sm mb-5">
                    <div class="card-header bg-light-{{ $notify['data']['color'] }}">
                        <h3 class="card-title text-{{ $notify['data']['color'] }}"><i class="fa-solid fa-{{ $notify['data']['icon'] }} fa-lg me-3 text-{{ $notify['data']['color'] }}"></i> {{ $notify['data']['title'] }}</h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="d-flex flex-row justify-content-between">
                            <div class="fs-3">{!! $notify['data']['text'] !!}</div>
                            <div class="text-end">
                                <a href="{{ route('admin.account.notify.show', $notify->id) }}" class="text-{{ $notify['data']['color'] }}"><span class="fa-regular fa-circle-right fa-2x"></span> </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endfor
@endsection

@section("script")

@endsection

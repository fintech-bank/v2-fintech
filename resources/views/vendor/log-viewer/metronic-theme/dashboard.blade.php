@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">@lang('Dashboard')</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-muted text-hover-primary">Administration</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-muted text-hover-primary">Log Système</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">@lang('Dashboard')</li>
        </ul>
    </div>
    <!--<div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
    </div>-->
@endsection

@section("content")
    <div class="d-flex flex-center justify-content-around align-items-center w-300px border border-2 rounded-2 border-gray-800  p-5 mb-10">
        <a href="{{ route('log-viewer::dashboard') }}" class="btn btn-link {{ Route::is('log-viewer::dashboard') ? 'btn-color-primary' : 'btn-color-muted' }} btn-active-color-primary me-5 mb-2"><i class="fa-solid fa-desktop me-2"></i> @lang('Dashboard')</a>
        <a href="{{ route('log-viewer::logs.list') }}" class="btn btn-link {{ Route::is('log-viewer::logs.list') ? 'btn-color-primary' : 'btn-color-muted' }} btn-active-color-primary me-5 mb-2"><i class="fa-solid fa-archive me-2"></i> @lang('Logs')</a>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-12"></div>
        <div class="col-md-8 col-sm-12">
            <div class="row">
                @foreach($percents as $level => $item)
                    <div class="col-md-3 col-sm-12">
                        <div class="d-flex flex-row align-items-center rounded rounded-2 p-5 mb-5 level-{{ $level }}">
                            <div class="symbol symbol-50px p-0 me-4">
                                <div class="symbol-label fs-2tx fw-semibold level-{{ $level }}-light">{!! log_styler()->icon($level) !!}</div>
                            </div>
                            <div class="d-flex flex-column p-5">
                                <div class="fw-bolder">{{ $item['name'] }}</div>
                                <div class="text-muted">{{ $item['count'] }} @lang('entries') - {!! $item['percent'] !!} %</div>
                                <div class="progress" style="height: 3px;">
                                    <div class="progress-bar" style="width: {{ $item['percent'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section("script")

@endsection

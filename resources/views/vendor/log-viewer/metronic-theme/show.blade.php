@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">@lang('Log') [{{ $log->date }}]</h1>
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
            <li class="breadcrumb-item text-dark">@lang('Log') [{{ $log->date }}]</li>
        </ul>
    </div>
    <!--<div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
    </div>-->
@endsection

@section("content")
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-flag me-3"></i> @lang('Levels')</h3>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills nav-pills-custom flex-row flex-md-column" role="tablist">
                        @foreach($log->menu() as $levelKey => $item)
                            @if($item['count'] == 0)
                                <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                    <!--begin::Link-->
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-row justify-content-start align-items-center overflow-hidden w-100 h-85px pt-5 pb-2 disabled" disabled id="kt_stats_widget_16_tab_link_1" data-bs-toggle="pill" href="" aria-selected="true" role="tab">
                                        <!--begin::Icon-->
                                        <div class="nav-icon mb-3 me-3">
                                            {!! $item['icon'] !!}
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">{{ $item['name'] }}</span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px"></span>
                                        <!--end::Bullet-->
                                    </a>
                                    <!--end::Link-->
                                </li>
                            @else
                                <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                    <!--begin::Link-->
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-row justify-content-start align-items-center overflow-hidden w-100 h-50px pt-5 pb-2" id="kt_stats_widget_16_tab_link_1" data-bs-toggle="pill" href="{{ $item['url'] }}" aria-selected="true" role="tab">
                                        <!--begin::Icon-->
                                        <div class="nav-icon mb-3 me-3">
                                            {!! $item['icon'] !!}
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">{{ $item['name'] }}</span>

                                        <span class="d-flex flex-end justify-content-end">
                                            <span class="badge badge-{{ $levelKey }}"></span>
                                        </span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px level-{{ $levelKey }}"></span>
                                        <!--end::Bullet-->
                                    </a>
                                    <!--end::Link-->
                                </li>
                            @endif
                        @endforeach
                        <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                            <!--begin::Link-->
                            <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-row justify-content-start align-items-center overflow-hidden w-100 h-50px pt-5 pb-2 active" id="kt_stats_widget_16_tab_link_1" data-bs-toggle="pill" href="#kt_stats_widget_16_tab_1" aria-selected="true" role="tab">
                                <!--begin::Icon-->
                                <div class="nav-icon mb-3 me-3">
                                    <i class="fonticon-drive fs-1 p-0"></i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Title-->
                                <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">SaaS</span>
                                <!--end::Title-->
                                <!--begin::Bullet-->
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                <!--end::Bullet-->
                            </a>
                            <!--end::Link-->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@lang('Log info') :</h3>
                    <div class="card-toolbar">
                        <div class="btn-group">
                            <a href="{{ route('log-viewer::logs.download', [$log->date]) }}" class="btn btn-sm btn-success">
                                <i class="fa fa-download"></i> @lang('Download')
                            </a>
                            <a href="#delete-log-modal" class="btn btn-sm btn-danger" data-toggle="modal">
                                <i class="fa fa-trash-o"></i> @lang('Delete')
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-row border border-bottom-3 pb-5 mb-5">
                        <div class="fw-bolder">@lang('File path') :</div>
                        <span>{{ $log->getPath() }}</span>
                    </div>
                    <div class="d-flex flex-row border border-bottom-3 pb-5 mb-5">
                        <div class="fw-bolder">@lang('Log entries') :</div>
                        <span class="badge badge-primary">{{ $entries->total() }}</span>
                    </div>
                    <div class="d-flex flex-row border border-bottom-3 pb-5 mb-5">
                        <div class="fw-bolder">@lang('Size') :</div>
                        <span class="badge badge-primary">{{ $entries->size() }}</span>
                    </div>
                    <div class="d-flex flex-row border border-bottom-3 pb-5 mb-5">
                        <div class="fw-bolder">@lang('Created at') :</div>
                        <span class="badge badge-primary">{{ $entries->createdAt() }}</span>
                    </div>
                    <div class="d-flex flex-row border border-bottom-3 pb-5 mb-5">
                        <div class="fw-bolder">@lang('Updated at') :</div>
                        <span class="badge badge-primary">{{ $entries->updatedAt() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")

@endsection

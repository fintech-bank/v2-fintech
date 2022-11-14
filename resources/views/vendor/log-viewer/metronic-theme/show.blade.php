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
        <div class="col-md-3 col-sm-12">
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
        <div class="col-md-9 col-sm-12">
            <div class="card shadow-sm mb-10">
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
                    <div class="d-flex flex-row justify-content-between">
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-row border-bottom-3 p-5">
                                <div class="fw-bolder me-5">@lang('File path') :</div>
                                <span class="me-5">{{ $log->getPath() }}</span>
                            </div>
                            <div class="d-flex flex-row border-bottom-3 p-5">
                                <div class="fw-bolder me-5">@lang('Log entries') :</div>
                                <span class="badge badge-primary">{{ $entries->total() }}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-row border-bottom-3 p-5">
                                <div class="fw-bolder me-5">@lang('Size') :</div>
                                <span class="badge badge-primary">{{ $log->size() }}</span>
                            </div>
                            <div class="d-flex flex-row border-bottom-3 p-5">
                                <div class="fw-bolder me-5">@lang('Created at') :</div>
                                <span class="badge badge-primary">{{ $log->createdAt() }}</span>
                            </div>
                            <div class="d-flex flex-row border-bottom-3 p-5">
                                <div class="fw-bolder me-5">@lang('Updated at') :</div>
                                <span class="badge badge-primary">{{ $log->updatedAt() }}</span>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <form action="{{ route('log-viewer::logs.search', [$log->date, $level]) }}" method="GET">
                            <div class="input-group mb-5">
                                <input id="query" name="query" class="form-control" value="{{ $query }}" placeholder="@lang('Type here to search')">
                                <div class="input-group-append">
                                    @unless (is_null($query))
                                        <a href="{{ route('log-viewer::logs.show', [$log->date]) }}" class="btn btn-secondary">
                                            (@lang(':count results', ['count' => $entries->count()])) <i class="fa-solid fa-xmark"></i>
                                        </a>
                                    @endunless
                                    <button id="search-btn" class="btn btn-light">
                                        <span class="fa-solid fa-search"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-toolbar">
                        @if ($entries->hasPages())
                            <span class="badge badge-info float-right">
                                {{ __('Page :current of :last', ['current' => $entries->currentPage(), 'last' => $entries->lastPage()]) }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table border table-row-bordered gy-5 gx-5" id="entries">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800">
                                <th>@lang('ENV')</th>
                                <th style="width: 120px;">@lang('Level')</th>
                                <th style="width: 65px;">@lang('Time')</th>
                                <th>@lang('Header')</th>
                                <th class="text-end">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($entries as $key => $entry)
                            <tr>
                                <td>
                                    <span class="badge badge-env">{{ $entry->env }}</span>
                                </td>
                                <td>
                                        <span class="badge badge-level-{{ $entry->level }}">
                                            {!! $entry->level() !!}
                                        </span>
                                </td>
                                <td>
                                        <span class="badge badge-secondary">
                                            {{ $entry->datetime->format('H:i:s') }}
                                        </span>
                                </td>
                                <td>
                                    {{ $entry->header }}
                                </td>
                                <td class="text-right">
                                    @if ($entry->hasStack())
                                        <a class="btn btn-sm btn-light" role="button" data-toggle="collapse"
                                           href="#log-stack-{{ $key }}" aria-expanded="false" aria-controls="log-stack-{{ $key }}">
                                            <i class="fa fa-toggle-on"></i> @lang('Stack')
                                        </a>
                                    @endif

                                    @if ($entry->hasContext())
                                        <a class="btn btn-sm btn-light" role="button" data-toggle="collapse"
                                           href="#log-context-{{ $key }}" aria-expanded="false" aria-controls="log-context-{{ $key }}">
                                            <i class="fa fa-toggle-on"></i> @lang('Context')
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @if ($entry->hasStack() || $entry->hasContext())
                                <tr>
                                    <td colspan="5" class="stack py-0">
                                        @if ($entry->hasStack())
                                            <div class="stack-content collapse" id="log-stack-{{ $key }}">
                                                {!! $entry->stack() !!}
                                            </div>
                                        @endif

                                        @if ($entry->hasContext())
                                            <div class="stack-content collapse" id="log-context-{{ $key }}">
                                                <pre>{{ $entry->context() }}</pre>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <span class="badge badge-secondary">@lang('The list of logs is empty!')</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")

@endsection

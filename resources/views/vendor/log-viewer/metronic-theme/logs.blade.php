@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">@lang('Logs')</h1>
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
            <li class="breadcrumb-item text-dark">@lang('Logs')</li>
        </ul>
    </div>
    <!--<div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
    </div>-->
@endsection

@section("content")
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">@lang('Logs')</h3>
        </div>
        <div class="card-body">
            <table class="table table-row-bordered border rounded-2 gy-3 gx-3" id="liste_logs">
                <thead>
                    <tr>
                        @foreach($headers as $key => $header)
                            <th scope="col" class="{{ $key == 'date' ? 'text-start' : 'text-center' }}">
                                @if ($key == 'date')
                                    <span class="badge badge-info">{{ $header }}</span>
                                @else
                                    <div class="d-flex flex-row align-items-center">
                                        {{ log_styler()->icon($key) }} <span class="ms-2">{{ $header }}</span>
                                    </div>
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section("script")
    <script type="text/javascript">

    </script>
@endsection

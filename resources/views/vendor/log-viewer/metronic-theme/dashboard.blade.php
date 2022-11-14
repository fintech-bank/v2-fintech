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
        <div class="col-md-4 col-sm-12">
            <div id="stats-doughnut-chart" height="300" class="mb-3"></div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="row">
                @foreach($percents as $level => $item)
                    <div class="col-md-3 col-sm-12">
                        <div class="d-flex flex-row align-items-center rounded rounded-2 p-5 mb-5 level-{{ $level }} text-white">
                            <div class="symbol symbol-50px p-0 me-4">
                                <div class="symbol-label fw-semibold level-{{ $level }}-light">{!! log_styler()->icon($level) !!}</div>
                            </div>
                            <div class="d-flex flex-column p-5">
                                <div class="fw-bolder">{{ $item['name'] }}</div>
                                <div class="fs-8">{{ $item['count'] }} @lang('entries') - {!! $item['percent'] !!} %</div>
                                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                    <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $item['percent'] }}%;" aria-valuenow="{{ $item['percent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
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
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script type="text/javascript">
        am5.ready(() => {
            let root = am5.Root.new('stats-doughnut-chart')
            root.setTheme([
                am5themes_Animated.new(root)
            ])

            let chart = root.container.children.push(am5radar.RadarChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "panX",
                wheelY: "zoomX",
                innerRadius: am5.percent(20),
                startAngle: -90,
                endAngle: 180
            }))

            let data = [{
                category: "Urgence",
                value: 80,
                full: 100,
                columnSettings: {
                    fill: chart.get("colors").getIndex(0)
                }
            }];

            let cursor = chart.set("cursor", am5radar.RadarCursor.new(root, {
                behavior: "zoomX"
            }));

            cursor.lineY.set("visible", false);

            let xRenderer = am5radar.AxisRendererCircular.new(root, {
                //minGridDistance: 50
            });

            xRenderer.labels.template.setAll({
                radius: 10
            });

            xRenderer.grid.template.setAll({
                forceHidden: true
            });

            let xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                renderer: xRenderer,
                min: 0,
                max: 100,
                strictMinMax: true,
                numberFormat: "#'%'",
                tooltip: am5.Tooltip.new(root, {})
            }));

            let yRenderer = am5radar.AxisRendererRadial.new(root, {
                minGridDistance: 20
            });

            yRenderer.labels.template.setAll({
                centerX: am5.p100,
                fontWeight: "500",
                fontSize: 18,
                templateField: "columnSettings"
            });

            yRenderer.grid.template.setAll({
                forceHidden: true
            });

            let yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
                categoryField: "category",
                renderer: yRenderer
            }));

            yAxis.data.setAll(data);

            var series1 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
                xAxis: xAxis,
                yAxis: yAxis,
                clustered: false,
                valueXField: "full",
                categoryYField: "category",
                fill: root.interfaceColors.get("alternativeBackground")
            }));

            series1.columns.template.setAll({
                width: am5.p100,
                fillOpacity: 0.08,
                strokeOpacity: 0,
                cornerRadius: 20
            });

            series1.data.setAll(data);

            series1.appear(1000);
            chart.appear(1000, 100);
        })
    </script>
@endsection

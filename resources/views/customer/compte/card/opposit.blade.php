@extends("customer.layouts.app")

@section("css")
    <link src="https://cssscript.com/demo/step-flow-bootstrap/bootstrap-steps.min.css" type="text/css" />
@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Carte Bancaire {{ $card->full_info }} - Opposition sur la carte</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex flex-column">
                                <div class="fs-2 fw-bolder uppercase">Référence</div>
                                <div class="">{{ $card->opposition->reference }}</div>
                            </div>
                        </div>
                        <div class="separator separator-dotted border-gray-600 my-5"></div>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex flex-column">
                                <div class="fs-2 fw-bolder uppercase">Type d'opposition</div>
                                <div class="">{{ Str::ucfirst($card->opposition->type) }}</div>
                            </div>
                        </div>
                        <div class="separator separator-dotted border-gray-600 my-5"></div>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex flex-column">
                                <div class="fs-2 fw-bolder uppercase">Type d'opposition</div>
                                <div class="">{{ Str::ucfirst($card->opposition->type) }}</div>
                            </div>
                        </div>
                        <ul class="steps">
                            <li class="step step-success">
                                <div class="step-content">
                                    <span class="step-circle">1</span>
                                    <span class="step-text">Step 1</span>
                                </div>
                            </li>
                            <li class="step step-active">
                                <div class="step-content">
                                    <span class="step-circle">2</span>
                                    <span class="step-text">Step 2</span>
                                </div>
                            </li>
                            <li class="step">
                                <div class="step-content">
                                    <span class="step-circle">3</span>
                                    <span class="step-text">Step 3</span>
                                </div>
                            </li>
                            <li class="step">
                                <div class="step-content">
                                    <span class="step-circle">4</span>
                                    <span class="step-text">Step 4</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.card.opposit")
@endsection

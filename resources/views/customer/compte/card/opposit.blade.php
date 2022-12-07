@extends("customer.layouts.app")

@section("css")
    <link rel="stylesheet" href="https://codyhouse.co/demo/breadcrumbs-multi-steps-indicator/css/style.css">
@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="card shadow-sm mb-10">
            <div class="card-body">
                <nav>
                    <ol class="cd-multi-steps text-center custom-icons">
                        <li {{ $card->opposition->status == 'submit' ? 'class=current' : 'class=visited' }}><em>Soumission</em></li>
                        <li {{ $card->opposition->status == 'progress' ? 'class=current' : ($card->opposition->status == 'terminate' ? 'class=visited' : '') }}><em>Etude en cours</em></li>
                        <li {{ $card->opposition->status == 'terminated' ? 'class=current' : '' }}><em>Terminer</em></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Carte Bancaire {{ $card->full_info }} - Opposition sur la carte</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
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
                        @if($card->opposition->type == 'fraude')
                            <div class="separator separator-dotted border-gray-600 my-5"></div>
                            <div class="d-flex flex-row justify-content-between">
                                <div class="d-flex flex-column">
                                    <div class="fs-2 fw-bolder uppercase">Vérification de la fraude</div>
                                    <div class="">{{ $card->opposition->verif_fraude ? 'Oui' : 'Non' }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="vr"></div>
                    <div class="col-md-8 col-sm-12">
                        <div class="border border-gray-600 rounded p-5 mb-10">
                            <div class="fw-bolder fs-2">Description de l'opposition</div>
                            <blockquote>{!! $card->opposition->description !!}</blockquote>
                        </div>
                        <form action="{{ route('customer.card.piece', $card->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if($card->opposition->status == 'submit')
                                <p>
                                    Votre demande d'opposition est actuellement en <strong>Soumission</strong>.<br>
                                    Afin de traiter au mieux votre requete, veuillez nous faire parvenir les justificatifs suivants:
                                </p>
                                <ul class="mb-5">
                                    <li><strong>Vol:</strong> Dépot de plainte effectuer auprès de votre commissariat.</li>
                                    <li><strong>Perte:</strong> Déclaration de perte effectuer auprès de votre commissariat.</li>
                                    <li><strong>Fraude:</strong> Dépot de plainte effectuer auprès de votre commissariat ainsi qu'une capture d'écran des mouvements frauduleux.</li>
                                </ul>

                                <x-form.input-file
                                    name="file"
                                    label="Document à fournir"
                                    required="true" />

                                <div class="d-flex flex-wrap justify-content-end">
                                    <x-form.button />
                                </div>
                            @endif
                            @if($card->opposition->status == 'progress')
                                <p>Votre dossier est en étude, votre conseiller vous contactera si des informations complémentaires sont requise.</p>
                            @endif
                            @if($card->opposition->status == 'terminate')
                                <p>Votre dossier est clotûrer, si votre opposition concerne une fraude, veuillez nous restituer votre carte bancaire afin de la détruire.</p>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.card.opposit")
@endsection

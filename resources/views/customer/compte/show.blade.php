@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="d-flex flex-center flex-column">
                    <div class="uppercase fs-2">Solde au {{ $wallet->transactions()->orderBy('updated_at', 'desc')->first() ? $wallet->transactions()->orderBy('updated_at', 'desc')->first()->updated_at->format('d/m/Y') : now() }}</div>
                    <div class="fw-bolder fs-2hx">{{ $wallet->solde_remaining >= 0 ? "+ ".eur($wallet->solde_remaining) : eur($wallet->solde_remaining)}}</div>
                </div>

                <x-base.underline
                    title="Opération à venir:"
                    size="4"
                    size-text="fs-1"
                    class="uppercase w-100 my-5" />


                <div class="mb-10">
                    @foreach($wallet->transactions()->where('confirmed', 0)->where('differed', 0)->orderBy('updated_at', 'desc')->get() as $transaction)
                        <div class="mb-5">
                            <a class="d-flex flex-row h-50px p-5 justify-content-between align-items-center rounded bg-white mb-0"
                               data-bs-toggle="collapse" href="#{{ $transaction->type }}_{{ $transaction->id }}">
                                <div class="d-flex flex-row align-items-center text-black">
                                    {!! $transaction->getTypeSymbolAttribute() !!}
                                    <div class="d-flex flex-column">
                                        {{ $transaction->designation }}<br>
                                        <div class="text-muted">
                                            {{ $transaction->confirmed ? $transaction->confirmed_at->format('d/m/Y') : ($transaction->differed ? $transaction->differed_at->format('d/m/Y') : $transaction->updated_at->format('d/m/Y')) }}
                                        </div>
                                    </div>
                                </div>
                                @if ($transaction->amount < 0)
                                    <span class="text-danger fs-2 fw-bolder">{{ $transaction->amount_format }}</span>
                                @else
                                    <span class="text-success fs-2 fw-bolder">+ {{ $transaction->amount_format }}</span>
                                @endif
                            </a>
                            <div class="collapse" id="{{ $transaction->type }}_{{ $transaction->id }}">
                                <div class="card card-body">
                                    <div class="ps-5 text-muted mb-5">{{ $transaction->type_text }}</div>
                                    <div class="mb-5">
                                        <x-base.underline title="Détails de l'opération" class="mb-2" size-text="fs-3"
                                                          size="3" color="{{ $transaction->type_color }}" />
                                        <div class="d-flex flex-row justify-content-around">
                                            <div>Transaction effectuée le: {{ $transaction->updated_at->format('d/m/Y') }}
                                            </div>
                                            <div>Comptabilisé à la date du:
                                                {{ $transaction->confirmed ? $transaction->confirmed_at->format('d/m/Y') : ($transaction->differed ? $transaction->differed_at->format('d/m/Y') : $transaction->updated_at->format('d/m/Y')) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <x-base.underline title="Libellé complet" class="mb-2" size-text="fs-3"
                                                          size="3" color="{{ $transaction->type_color }}" />
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold">{{ $transaction->designation }}</div>
                                            <div>{{ $transaction->description }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <x-base.underline
                    title="OPÉRATIONS COMPTABILISÉES :"
                    size="4"
                    size-text="fs-1"
                    class="uppercase w-100 my-5" />

                <div class="fw-bolder ms-5">{{ formatDateFrench(now()) }}</div>
                @foreach($wallet->transactions()->where('confirmed', 1)->whereBetween('confirmed_at', [now()->startOfDay(), now()->endOfDay()])->orderBy('confirmed_at', 'desc')->get() as $transaction)
                    <div class="mb-5">
                        <a class="d-flex flex-row h-50px p-5 justify-content-between align-items-center rounded bg-white mb-0"
                           data-bs-toggle="collapse" href="#{{ $transaction->type }}_{{ $transaction->id }}">
                            <div class="d-flex flex-row align-items-center text-black">
                                {!! $transaction->getTypeSymbolAttribute() !!}
                                <div class="d-flex flex-column">
                                    {{ $transaction->designation }}<br>
                                    <div class="text-muted">
                                        {{ $transaction->confirmed ? $transaction->confirmed_at->format('d/m/Y') : ($transaction->differed ? $transaction->differed_at->format('d/m/Y') : $transaction->updated_at->format('d/m/Y')) }}
                                    </div>
                                </div>
                            </div>
                            @if ($transaction->amount < 0)
                                <span class="text-danger fs-2 fw-bolder">{{ $transaction->amount_format }}</span>
                            @else
                                <span class="text-success fs-2 fw-bolder">+ {{ $transaction->amount_format }}</span>
                            @endif
                        </a>
                        <div class="collapse" id="{{ $transaction->type }}_{{ $transaction->id }}">
                            <div class="card card-body">
                                <div class="ps-5 text-muted mb-5">{{ $transaction->type_text }}</div>
                                <div class="mb-5">
                                    <x-base.underline title="Détails de l'opération" class="mb-2" size-text="fs-3"
                                                      size="3" color="{{ $transaction->type_color }}" />
                                    <div class="d-flex flex-row justify-content-around">
                                        <div>Transaction effectuée le: {{ $transaction->updated_at->format('d/m/Y') }}
                                        </div>
                                        <div>Comptabilisé à la date du:
                                            {{ $transaction->confirmed ? $transaction->confirmed_at->format('d/m/Y') : ($transaction->differed ? $transaction->differed_at->format('d/m/Y') : $transaction->updated_at->format('d/m/Y')) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <x-base.underline title="Libellé complet" class="mb-2" size-text="fs-3"
                                                      size="3" color="{{ $transaction->type_color }}" />
                                    <div class="d-flex flex-column">
                                        <div class="fw-bold">{{ $transaction->designation }}</div>
                                        <div>{{ $transaction->description }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @for($i=1; $i <= 30; $i++)
                    @if($wallet->transactions()->where('confirmed', 1)->whereBetween('confirmed_at', [now()->subDays($i)->startOfDay(), now()->subDays($i)->endOfDay()])->orderBy('confirmed_at', 'desc')->count() != 0)
                        <div class="fw-bolder ms-5 lozad">{{ formatDateFrench(now()->subDays($i)) }}</div>
                        @foreach($wallet->transactions()->where('confirmed', 1)->whereBetween('confirmed_at', [now()->subDays($i)->startOfDay(), now()->subDays($i)->endOfDay()])->orderBy('confirmed_at', 'desc')->get() as $transaction)
                            <div class="mb-5 lozad">
                                <a class="d-flex flex-row h-50px p-5 justify-content-between align-items-center rounded bg-white mb-0"
                                   data-bs-toggle="collapse" href="#{{ $transaction->type }}_{{ $transaction->id }}">
                                    <div class="d-flex flex-row align-items-center text-black">
                                        {!! $transaction->getTypeSymbolAttribute() !!}
                                        <div class="d-flex flex-column">
                                            {{ $transaction->designation }}<br>
                                            <div class="text-muted">
                                                {{ $transaction->confirmed ? $transaction->confirmed_at->format('d/m/Y') : ($transaction->differed ? $transaction->differed_at->format('d/m/Y') : $transaction->updated_at->format('d/m/Y')) }}
                                            </div>
                                        </div>
                                    </div>
                                    @if ($transaction->amount < 0)
                                        <span class="text-danger fs-2 fw-bolder">{{ $transaction->amount_format }}</span>
                                    @else
                                        <span class="text-success fs-2 fw-bolder">+ {{ $transaction->amount_format }}</span>
                                    @endif
                                </a>
                                <div class="collapse" id="{{ $transaction->type }}_{{ $transaction->id }}">
                                    <div class="card card-body">
                                        <div class="ps-5 text-muted mb-5">{{ $transaction->type_text }}</div>
                                        <div class="mb-5">
                                            <x-base.underline title="Détails de l'opération" class="mb-2" size-text="fs-3"
                                                              size="3" color="{{ $transaction->type_color }}" />
                                            <div class="d-flex flex-row justify-content-around">
                                                <div>Transaction effectuée le: {{ $transaction->updated_at->format('d/m/Y') }}
                                                </div>
                                                <div>Comptabilisé à la date du:
                                                    {{ $transaction->confirmed ? $transaction->confirmed_at->format('d/m/Y') : ($transaction->differed ? $transaction->differed_at->format('d/m/Y') : $transaction->updated_at->format('d/m/Y')) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-5">
                                            <x-base.underline title="Libellé complet" class="mb-2" size-text="fs-3"
                                                              size="3" color="{{ $transaction->type_color }}" />
                                            <div class="d-flex flex-column">
                                                <div class="fw-bold">{{ $transaction->designation }}</div>
                                                <div>{{ $transaction->description }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endfor

            </div>
            <div class="col-md-3 col-sm-12 mt-10">
                <a href="" class="d-flex flex-row align-items-center text-dark hover-zoom">
                    <span class="iconify fs-2tx me-2" data-icon="fa6-solid:money-bill-transfer"></span>
                    <span class="fs-1">Effectuer un virement</span>
                </a>
                <div class="separator separator-dotted border-gray-400 my-10"></div>
                <a href="" class="d-flex flex-row align-items-center text-dark hover-zoom">
                    <span class="iconify fs-2tx me-2" data-icon="icon-park-twotone:bank-card-two"></span>
                    <span class="fs-1">Télécharger mon rib</span>
                </a>
                <div class="separator separator-dotted border-gray-400 my-10"></div>
                <a href="" class="d-flex flex-row align-items-center text-dark hover-zoom">
                    <span class="iconify fs-2tx me-2" data-icon="ph:files"></span>
                    <span class="fs-1">Voir mes relevés</span>
                </a>
                <div class="separator separator-dotted border-gray-400 my-10"></div>
                <a href="" class="d-flex flex-row align-items-center text-dark hover-zoom" data-bs-toggle="modal" data-bs-target="#features">
                    <span class="iconify fs-2tx me-2" data-icon="jam:cogs-f"></span>
                    <span class="fs-1">Caractéristique</span>
                </a>
                <div class="separator separator-dotted border-gray-400 my-10"></div>
                <a href="{{ route('customer.card.index') }}" class="d-flex flex-row align-items-center text-dark hover-zoom">
                    <span class="iconify fs-2tx me-2" data-icon="pixelarticons:credit-card-multiple"></span>
                    <span class="fs-1">Mes cartes</span>
                </a>
                @if($wallet->customer->package->check_deposit)
                    <div class="separator separator-dotted border-gray-400 my-10"></div>
                    <a href="{{ route('customer.card.index') }}" class="d-flex flex-row align-items-center text-dark hover-zoom">
                        <!--<i class="fa-solid fa-credit-card fs-2hx me-2"></i>-->
                        <span class="iconify fs-2tx me-2" data-icon="circum:money-check-1"></span>
                        <span class="fs-1">Déposer une remise de chèque</span>
                    </a>
                @endif
                <div class="separator separator-dotted border-gray-400 my-10"></div>
                {!! $chart->container() !!}
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="features">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">{{ $wallet->name_account_generic }}</h3>
    
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">                   
                        <i class="fa-regular fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
    
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
    @include("customer.scripts.compte.show")
@endsection

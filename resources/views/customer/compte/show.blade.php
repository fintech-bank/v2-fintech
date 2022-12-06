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
                    <div class="fw-bolder fs-2hx">{{ $wallet->solde_remaining >= 0 ? "+ ".eur($wallet->solde_remaining) : "- ".eur($wallet->solde_remaining)}}</div>
                </div>

                <x-base.underline
                    title="Opération à venir:"
                    size="4"
                    size-text="fs-1"
                    class="uppercase w-100 my-5" />

                @foreach($wallet->transactions()->where('confirmed', 0)->orderBy('updated_at', 'desc')->get() as $transaction)

                @endforeach
                <div class="accordion" id="opsAtt">
                    @foreach($wallet->transactions()->where('confirmed', 0)->orderBy('updated_at', 'desc')->get() as $transaction)
                        <div class="accordion-item mb-5">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{ $transaction->uuid }}" aria-expanded="false" aria-controls="flush-{{ $transaction->uuid }}">
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-5">
                                        <div class="d-flex flex-column">
                                            {!! $transaction->getTypeSymbolAttribute(30) !!}
                                        </div>
                                        <div class="fs-3">{{ $transaction->designation }}</div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-end align-items-center mb-2">
                                        {{ $transaction->amount_format }}
                                    </div>
                                </button>
                            </h2>
                            <div id="flush-{{ $transaction->uuid }}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#opsAtt">
                                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.index")
@endsection

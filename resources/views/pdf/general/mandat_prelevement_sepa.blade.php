@extends('pdf.layouts.app')

@section("content")
    <div class="border border-2 rounded p-1">
        <div class="text-center">
            <div class="fw-bolder fs-4">Mandat de prélèvement SEPA</div>
            <div class="fs-2">Référence Unique de Mandat : XP{{ generateReference(15) }}</div>
        </div>
    </div>
@endsection

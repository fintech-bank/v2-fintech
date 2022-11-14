@extends('pdf.layouts.app')

@section("content")
    <div class="d-flex flex-column justify-content-center">
        <div class="fw-bolder fs-1">CONTRAT CARTE BANCAIRE {{ Str::upper($data['card']->support->name) }} À AUTORISATION QUASI-SYSTÉMATIQUE</div>
    </div>
@endsection

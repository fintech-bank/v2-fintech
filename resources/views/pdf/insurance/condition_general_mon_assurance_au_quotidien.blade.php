@extends('pdf.layouts.app')

@section("content")
    <div class="text-center">
        <div class="fs-5 fw-bolder">MON ASSURANCE AU QUOTIDIEN</div>
        <div class="fs-4">NOTICE D'INFORMATION</div>
        <div class="text-muted">REF.{{ random_numeric(3) }} {{ random_numeric(3) }} {{ random_string_alpha_upper(1) }}</div>
    </div>
@endsection

@extends('pdf.layouts.app')

@section("content")
    <div class="text-center mb-5">
        <div class="fs-5 fw-bolder">MON ASSURANCE AU QUOTIDIEN</div>
        <div class="fs-4">NOTICE D'INFORMATION</div>
        <div class="text-muted">REF.{{ random_numeric(3) }} {{ random_numeric(3) }} {{ random_string_alpha_upper(1) }}</div>
    </div>

    <div class="fs-4 fw-bolder">LES CARACTÉRISTIQUES DU CONTRAT ET DÉFINITIONS</div>
    <p>
        MON ASSURANCE AU QUOTIDIEN, contrat d'assurance collective sur la vie à
        adhésion facultative, est souscrit par SOCIÉTÉ GÉNÉRALE, 29
        boulevard Haussmann, 75009 Paris, et ses filiales cocontractantes
        auprès de SOGÉCAP.
    </p>
    <p>
        L'objet du contrat est de verser un montant en fonction du problème de l'ordre du quotidien annexé au contrat.
    </p>
@endsection

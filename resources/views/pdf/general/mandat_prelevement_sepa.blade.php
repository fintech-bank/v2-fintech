@extends('pdf.layouts.app')

@section("content")
    <div class="border border-2 rounded p-1 mb-3">
        <div class="text-center">
            <div class="fw-bolder fs-4">Mandat de prélèvement SEPA</div>
            <div class="fs-2">Référence Unique de Mandat : XP{{ generateReference(15) }}</div>
        </div>
    </div>
    <table class="table table-bordered gx-5 gy-5">
        <tbody>
            <tr>
                <td>
                    <p>
                        En signant ce formulaire de mandat, vous autorisez le créancier à envoyer des instructions à votre banque pour débiter votre compte, et votre banque à débiter votre compte
                        conformément aux instructions du créancier.
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
@endsection

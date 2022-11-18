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
            <tr class="border-bottom border-gray-600">
                <td class="fs-2">
                    <p>
                        En signant ce formulaire de mandat, vous autorisez le créancier à envoyer des instructions à votre banque pour débiter votre compte, et votre banque à débiter votre compte
                        conformément aux instructions du créancier.
                    </p>
                    <p>Le créancier vous informera de tout prélèvement au plus tard 3 jours calendaires avant sa date d'échéance et par tout moyen.</p>
                    <p>Vous bénéficiez du droit d'être remboursé par votre banque selon les conditions décrites dans la convention que vous avez passée avec elle. Une demande de remboursement doit
                        être présentée :</p>
                    <ul>
                        <li>dans les 8 semaines suivant la date de débit de votre compte pour un prélèvement autorisé,</li>
                        <li>sans tarder et au plus tard dans les 13 mois en cas de prélèvement non autorisé.</li>
                    </ul>
                </td>
            </tr>
            <tr class="border-bottom border-gray-600">
                <td class="fs-2">
                    <div class="fw-bolder mb-2">Vos Informations</div>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fs-2">Nom - Prénom</td>
                                <td class="fs-2">{{ $customer->info->firstname }} {{ $customer->info->lastname }}</td>
                                <td class="fs-2">Adresse</td>
                                <td class="fs-2">{{ $customer->info->address }}</td>
                            </tr>
                            <tr>
                                <td class="fs-2">Code postal</td>
                                <td class="fs-2">{{ $customer->info->postal }}</td>
                                <td class="fs-2">Ville</td>
                                <td class="fs-2">{{ $customer->info->city }}</td>
                            </tr>
                            <tr>
                                <td class="fs-2">Pays</td>
                                <td class="fs-2" colspan="2">{{ \App\Helper\CountryHelper::getCountryName($customer->info->country) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@endsection

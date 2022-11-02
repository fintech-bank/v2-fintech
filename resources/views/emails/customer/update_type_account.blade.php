@extends("emails.layouts.template")

@section("content")
    <div class="d-flex flex-column bg-gray-400 p-5 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <tr>
            <td align="left" style="padding:0;Margin:0">
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;margin-bottom:11px;color:#333333;font-size:14px">
                    Votre compte est passé à l'offre suivante:
                </p>
                <div class="d-flex flex-row shadow-lg rounded border align-items-center">
                    <div class="symbol symbol-80px">
                        @switch($type->name)
                            @case('Cristal')
                                <div class="symbol-label fs-3tx fw-semibold text-secondary"><i class="fa-solid fa-gem"></i> </div>
                            @break
                            @case('Gold')
                                <div class="symbol-label fs-3tx fw-semibold text-warning"><i class="fa-solid fa-gem"></i> </div>
                                @break
                            @case('Platine')
                                <div class="symbol-label fs-3tx fw-semibold text-black"><i class="fa-solid fa-gem"></i> </div>
                                @break
                            @case('Pro Metal')
                                <div class="symbol-label fs-3tx fw-semibold text-secondary"><i class="fa-solid fa-ring"></i> </div>
                                @break
                            @case('Pro Gold')
                                <div class="symbol-label fs-3tx fw-semibold text-warning"><i class="fa-solid fa-ring"></i> </div>
                                @break
                        @endswitch
                        <div class="d-flex flex-row ms-2 mb-2">
                            <div class="fs-2 fw-bolder">{{ $type->name }}</div>
                        </div>
                            <div class="d-flex flex-row mb-2">
                                <div class="fs-2 fw-bolder">Tarif:</div>
                                <div class="">{{ $type->price_format }}</div>
                            </div>
                    </div>
                </div>

            </td>
        </tr>
    </div>
@endsection

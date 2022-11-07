@extends("emails.layouts.template")

@section("content")
    <div class="d-flex flex-column bg-gray-400 p-5 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <tr>
            <td align="left" style="padding:0;Margin:0">
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;margin-bottom:11px;color:#333333;font-size:14px">
                    {!! $message !!}
                </p>
            </td>
        </tr>
    </div>
@endsection

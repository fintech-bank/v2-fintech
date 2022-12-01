@extends("emails.layouts.template")

@section("content")
    <tr>
        <td align="left" style="padding:0;Margin:0">
            <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;margin-bottom:11px;color:#333333;font-size:14px">
                {!! $content !!}
            </p>
        </td>
    </tr>
@endsection

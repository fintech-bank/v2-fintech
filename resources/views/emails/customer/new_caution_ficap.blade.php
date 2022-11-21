<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head><base href="../../"/>
    <title>Metronic - the world's #1 selling Bootstrap Admin Theme Ecosystem for HTML, Vue, React, Angular & Laravel by Keenthemes</title>
    <meta charset="utf-8" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ config('app.url') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ config('app.url') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank app-blank">
<!--begin::Theme mode setup on page load-->
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Email template-->
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                    <tr>
                        <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                            <!--begin:Email content-->
                            <div style="text-align:center; margin:0 15px 34px 15px">
                                <!--begin:Logo-->
                                <div style="margin-bottom: 10px">
                                    <a href="{{ config('app.url') }}" rel="noopener" target="_blank">
                                        <img alt="Logo" src="{{ config('app.url') }}/storage/logo/logo_long.png" style="height: 35px" />
                                    </a>
                                </div>
                                <!--end:Logo-->
                                <!--begin:Media-->
                                <div style="margin-bottom: 15px">
                                    <img alt="Logo" src="{{ config('app.url') }}/assets/media/email/icon-positive-vote-1.svg" />
                                </div>
                                <!--end:Media-->
                                <!--begin:Text-->
                                <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                    @if($customer->type == 'physique')
                                    <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Bonjour, {{ $customer->civility }}. {{ $customer->firstname }} {{ $customer->lastname }}</p>
                                    @else
                                        <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Bonjour, {{ $customer->company }}</p>
                                    @endif
                                    {!! $content !!}
                                </div>
                                <!--end:Text-->
                                <!--begin:Action-->
                                <a href='https://ficap.fintech.ovh' target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">Me connecter</a>
                                <!--begin:Action-->
                            </div>
                            <!--end:Email content-->
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Email template-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Root-->
</body>
<!--end::Body-->
</html>

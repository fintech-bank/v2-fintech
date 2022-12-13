<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="mylead-verification" content="52167ad03c9c22fd4c684f73031498c4">
        <title>{{ config('app.name') }} - Particulier</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
        <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/front.css">
        @yield("styles")
    </head>
    <body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
          data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
          data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
          data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default mx-10">
        <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>

        <div id="kt_app_wrapper" data-user="{{ auth()->check() ? auth()->user()->id : 0 }}">
            @include("front.layouts.includes.header")
            @yield("content")
            @include("front.layouts.includes.footer")
        </div>
    </body>
    <script>var hostUrl = "/assets/";</script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <script src="https://cdn.withpersona.com/dist/persona-v4.2.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.0.279/pdf.min.js"></script>
    <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/js/app.js"></script>
    <script>
        function initFreshChat() {
            window.fcWidget.init({
                WEB_CHAT_PAYLOAD
            });
        }
        function initialize(i,t){var e;i.getElementById(t)?
            initFreshChat():((e=i.createElement("script")).id=t,e.async=!0,
                e.src="https://fintech-bank.freshchat.com/js/widget.js",e.onload=initFreshChat,i.head.appendChild(e))}
        function initiateCall(){initialize(document,"Freshchat-js-sdk")}
        window.addEventListener?window.addEventListener("load",initiateCall,!1):
            window.attachEvent("load",initiateCall,!1);
    </script>
    <!-- Begin TradeTracker SuperTag Code -->
    <script type="text/javascript">

        var _TradeTrackerTagOptions = {
            t: 'a',
            s: '438110',
            chk: '9f471d5184bf8bedddca4e0ab07386a8',
            overrideOptions: {}
        };

        (function() {var tt = document.createElement('script'), s = document.getElementsByTagName('script')[0]; tt.setAttribute('type', 'text/javascript'); tt.setAttribute('src', (document.location.protocol == 'https:' ? 'https' : 'http') + '://tm.tradetracker.net/tag?t=' + _TradeTrackerTagOptions.t + '&amp;s=' + _TradeTrackerTagOptions.s + '&amp;chk=' + _TradeTrackerTagOptions.chk); s.parentNode.insertBefore(tt, s);})();
    </script>
    <!-- End TradeTracker SuperTag Code -->
    @yield("scripts")
</html>

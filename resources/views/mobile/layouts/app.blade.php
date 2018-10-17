<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Your app title -->
    <title>@if(isset($webname)){{ $webname }} @else @if(isset(cache('system_base')->website)){{ cache('system_base')->website }} @else JapanXav @endif @endif</title>
    <!-- Path to Framework7 iOS CSS theme styles-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/framework7-icons@0.9.1/css/framework7-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/framework7@3.4.2/css/framework7.min.css" integrity="sha256-aphTxMH03jZWTVggWEwfgBUT0FRW4kK6jBnc/HHSqwM=" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/mobile/style.css?v0.01022988877229">
    @yield('style')
    <script>
        let website = "@if(isset(cache('system_base')->website)){{ cache('system_base')->website }} @else JapanXav @endif";

        function browserRedirect() {
            var sUserAgent = navigator.userAgent.toLowerCase();
            var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
            var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
            var bIsMidp = sUserAgent.match(/midp/i) == "midp";
            var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
            var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
            var bIsAndroid = sUserAgent.match(/android/i) == "android";
            var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
            var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";

            if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
                return true;
            } else {
                return false;
            }
        }

        if(browserRedirect() == false){
            window.location.href = '/';
        }

    </script>
</head>
<body>
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<div class="statusbar-overlay"></div>
<!-- Views -->
<div class="views">
    <!-- Your main view, should have "view-main" class -->
    <div class="view view-main">
        <!-- Top Navbar-->
        <div class="navbar bg-color-blue">
            <div class="navbar-inner text-color-white">
                <div class="left">
                    @if(isset($webname))
                        <a class="link back text-color-white" href="javascript:history.go(-1)">
                            <i class="f7-icons">chevron_left</i>
                            <span class="ios-only">後退</span>
                        </a>
                    @endif
                </div>
                <div class="center" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">@if(isset($webname)){{ $webname }} @else @if(isset(cache('system_base')->website)){{ cache('system_base')->website }} @else JapanXav @endif @endif</div>
                <div class="right">

                </div>
            </div>
        </div>
        <!-- Pages container, because we use fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages">
            <div class="page" data-page="home">
                <div class="page-content">

                    @yield('content')

                </div>
            </div>
        </div>
        <!-- Bottom Toolbar-->
        <div class="toolbar tabbar tabbar-labels bg-color-blue">
            <div class="toolbar-inner">
                <a href="/mobile/index" class="tab-link active text-color-white external">
                    <i class="f7-icons size-50">home_fill</i>
                    <span class="tabbar-label">首頁</span>
                </a>
                <a href="#" data-popover=".popover-links" class="tab-link text-color-white popover-open">
                    <i class="f7-icons size-50 ">film_fill</i>
                    <span class="tabbar-label">視頻</span>
                </a>
                <a href="/mobile/islogin" class="tab-link text-color-white external">
                    <i class="f7-icons size-50">person_fill</i>
                    <span class="tabbar-label">個人</span>
                </a>
            </div>
        </div>
        @if(isset(cache('menu')[0]))
        <div class="popover popover-links">
            <div class="popover-inner">
                <div class="list">
                    <ul>
                        @foreach(cache('menu')[0]['child'] as $val)
                        <li><a class="list-button item-link external" href="/mobile/list/{{ $val['id'] }}">{{ $val['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Path to Framework7 Library JS-->
<script src="https://cdn.jsdelivr.net/npm/framework7@3.4.2/js/framework7.min.js" integrity="sha256-gHaD2KoH9eWXATHYXr47H2veWtzzDVV6jKi/WOL56P4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/mobile/public.js?v0.16764564567"></script>
@yield('script')
@if(isset(cache('system_base')->count)){!!  cache('system_base')->count !!}@endif
</body>
</html>
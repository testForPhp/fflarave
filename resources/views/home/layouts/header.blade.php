<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha256-LA89z+k9fjgMKQ/kq4OO2Mrf8VltYml/VES+Rg0fh20=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/open-iconic@1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha256-BJ/G+e+y7bQdrYkS2RBTyNfBHpA9IuGaPmf9htub5MQ=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.2/dist/sweetalert2.min.css" integrity="sha256-1mciy4fJXvhqkSOwLvtpsTeBJ02AgAcmNYTzRMrzloU=" crossorigin="anonymous">
    <title>@if(isset(cache('system_base')->website)){{ cache('system_base')->website }}@endif</title>
    <link rel="stylesheet" href="/css/style.css?v.0.0974234912">
    <script>
        console.log(document.location.toString().split('//')[1].split('/')[1]);
        @if(!isset($resetpassword))
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

        if(browserRedirect() == true){
            let jumpprefix = document.location.toString().split('//')[1].split('/')[1];
            if(jumpprefix == 'login'){
                window.location.href = '/mobile/login';
            }else if(jumpprefix == 'member'){
                window.location.href = '/mobile/member/';
            }else{
                window.location.href = '/mobile/index';
            }

        }
        @endif
    </script>
</head>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv=Content-Type content="text/html; charset=UTF-8">
    <style type="text/css" nonce="XazwjuiBS1/rnUm2Q5n5LDZ2/Uk">
        body,td,div,p,a,input {font-family: arial, sans-serif;}
    </style>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>密碼找回 - {{ $data['website'] }}</title>
<body>
<div style="border:1px solid #c8cfda;padding:40px">
    <p style="font-size:16px;margin:5px 0">尊敬的用户:{{ $data['name'] }}，您好！</p>
    <p>
        欢迎使用:{{ $data['website'] }}，請通過下面地址找回您的密碼。<br>
        網址：<a href="{{ $data['token'] }}" target="_blank" data-saferedirecturl="{{ $data['token'] }}">{{ $data['token'] }}</a><br>
    </p>
    <div class="m_3332943604357521389qmSysSign" style="padding-top:20px">
        <p>{{ $data['website'] }}运营团队</p>
    </div>
    <div style="border-top:1px solid #ccc;padding:6px 0;font-size:12px;margin:6px 0 20px">
        {{ $data['website'] }}帮助中心：<a href="mailto:{{ $data['email'] }}" target="_blank">{{ $data['email'] }}</a>
    </div>
</div>
</div>
</body>
@include('home.layouts.header')
@yield('style')
<body>
@include('home.layouts.nav')

@yield('content')
@include('home.layouts.footer')
@include('home.layouts.js')

@yield('script')

</body>
</html>
<!DOCTYPE html>
<html>
<head lang="{{ app()->getLocale() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>@yield('title', 'laraBBS') -- I'll cross this bottomless pit</title>

    <link type="text/css" href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

    <div class="coutainer">

        @yield('content') {{-- 这么粗心啊,看着报的错还看了3遍才发现 --}}

    </div>

    @include('layouts._footer')

</div>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
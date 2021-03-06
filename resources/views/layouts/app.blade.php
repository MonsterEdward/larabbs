<!DOCTYPE html>
<html>
<head lang="{{ app()->getLocale() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    {{-- csrf token --}}
    {{-- csrf-token错写成csrf_token --}}
    {{-- <meta name="csrf_token" content="{{ csrf_token() }}"> --}}
    {{--
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>@yield('title', 'laraBBS') -- I'll cross this bottomless pit</title> --}}
    {{-- 利于SEO --}}
    {{-- <meta name="description" content="@yidle('description', 'Laravel临摹')"> --}}

    {{-- 用于Administrator里关于SEO的配置 --}}
    <title>@yield('title', 'LaraBBS') - {{ setting('site_name', 'I will cross this bottomless pit') }}</title>
    <meta name="description" content="@yield('description', setting('seo_description', 'Laravel临摹'))" />
    <meta name="keyword" content="@yield('keyword', setting('seo_keyword', 'LaraBBS,laravel,learning'))" />

    <link type="text/css" href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- 种下锚点styles --}}
    @yield('styles')
</head>
<body>
    <div id="app" class="{{ route_class() }}-page">{{-- assets/sass/app.scss中对应的class --}}

        @include('layouts._header')

        <div class="coutainer">

            @include('layouts._message')
            @yield('content') {{-- 这么粗心啊,看着报的错还看了3遍才发现 --}}

        </div>

        @include('layouts._footer')

    </div>

    @if(app()->isLocal())
        {{-- 又拼错了, 手误 --}}
        @include('sudosu::user-selector')
    @endif

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    {{-- 种下锚点scripts --}}
    @yield('scripts')
</body>
</html>

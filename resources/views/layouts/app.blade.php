<!DOCTYPE html>
<html>
    <head>
        <title>
            星期八博客---@yield('title', 'blog')
        </title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,er-scaleable=no">
        <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/lib/font-awesome/css/font-awesome.css')}}">
        <link rel="stylesheet" href="{{asset('/css/blog.css')}}">
        @yield('styles')
    </head>
    <body>
        @include('layouts._header')
        <div class="container">
            @include('layouts._message')
            @yield('content')
        </div>
        @include('layouts._footer')
    </body>
</html>
<script src="{{asset('/js/app.js')}}"></script>
<script src="{{asset('/js/lib/layer/layer.js')}}"></script>
@yield('my-js')
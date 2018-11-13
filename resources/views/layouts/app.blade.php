<!DOCTYPE html>
<html>
    <head>
        <title>
            博客---@yield('title', 'blog')
        </title>
        <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/lib/font-awesome/css/font-awesome.css')}}">
        <link rel="stylesheet" href="{{asset('/css/blog.css')}}">
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
@yield('my-js')
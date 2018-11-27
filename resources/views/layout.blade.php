<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('head')
    </head>
    <body>
        @include('header')
        <div class="content">
            @yield('content')
        </div>
        @include('footer')
    </body>
</html>

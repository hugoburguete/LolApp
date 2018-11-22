<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('head')
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @include('header')
            <div class="content">
                @yield('content')
            </div>
            @include('footer')
        </div>
    </body>
</html>

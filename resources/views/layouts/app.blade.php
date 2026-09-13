<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Pelita Ilmu Bimbel')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-canvas text-void min-h-screen flex flex-col">
        @include('partials.navbar')

        <main class="flex-1 pt-20">
            @yield('content')
        </main>

        @include('partials.footer')
    </body>
</html>

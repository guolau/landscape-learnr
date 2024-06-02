<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/css/app.css'])

        @stack('head')

        <title>
            @hasSection('title') 
                @yield('title') | 
            @endif
            Learn Landscapes
        </title>
    </head>
    <body class="text-neutral-800 bg-neutral-200 mx-auto max-w-7xl">
        <header class="py-6 text-center">
            <a href="{{ route('home') }}" class="text-xl text-neutral-800 !no-underline">Learn Landscapes</a>
        </header>

        @yield('content')

        <footer class="my-8">
            <div class="flex items-center gap-4 justify-center">
                <div>Made with ♥ by Laura</div>
                <div><a href="https://github.com/guolau/learn-landscapes">View on GitHub</a></div>
            </div>
        </footer>
    </body>
</html>
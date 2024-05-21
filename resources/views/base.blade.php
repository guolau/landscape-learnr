<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <title>Learn Landscapes</title>
    </head>
    <body>
        <header>
            <div class="text-center my-8 text-2xl">Learn Landscapes</div>
        </header>

        <div id="app">
            <div class="gap-6 mx-32 md:columns-2 columns-1">
                <select name="country" class="w-full"></select>
                <input name="search" type="text" class="w-full" placeholder="Search">
            </div>

            <div class="mx-16 my-8">
                <results></results>
            </div>
        </div>

        <footer class="my-8">
            <div class="flex items-center gap-4 justify-center">
                <div>Made by Laura</div>
                <div><a href="https://github.com/guolau/learn-landscapes">View on GitHub</a></div>
            </div>
        </footer>
    </body>
</html>
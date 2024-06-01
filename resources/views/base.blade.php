<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <title>Learn Landscapes</title>
    </head>
    <body class="bg-gray-200 md:mx-16 mx-4">
        <header>
            <h1 class="text-center my-8">Learn Landscapes</h1>
        </header>

        <div id="app">
            <div class="grid grid-cols-5 
                gap-5 mx-auto max-w-4xl">
                <select name="country" class="p-4 bg-white col-span-2"><option>Kyrgystan</option></select>
                <input name="search" type="text" class="p-4 col-span-3" placeholder="Search">
            </div>

            <div class="my-8">
                <Results></Results>
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
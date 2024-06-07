<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        @vite(['resources/js/app.js', 'resources/css/app.css'])
        @routes()
        @inertiaHead
    </head>
    <body class="text-neutral-800 bg-neutral-200 mx-auto max-w-7xl">
        @inertia
    </body>
</html>
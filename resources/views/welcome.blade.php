<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Angop Library') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen flex items-center justify-center bg-base-200 p-4">
        <div class="text-center max-w-md space-y-6">
            <h1 class="text-4xl font-bold text-base-content">Under Construction</h1>
            <p class="text-base-content/70">
                This site is currently being built. Check back soon!
            </p>
        </div>
    </body>
</html>

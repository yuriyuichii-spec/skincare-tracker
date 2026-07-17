<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Skincare Tracker') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body text-ink antialiased">
    <div class="min-h-screen flex flex-col items-center pt-6 sm:justify-center sm:pt-0 relative overflow-x-hidden">

        <div class="sakura-container" aria-hidden="true">
            <span class="petal"></span>
            <span class="petal"></span>
            <span class="petal"></span>
            <span class="petal"></span>
            <span class="petal"></span>
            <span class="petal"></span>
            <span class="petal"></span>
            <span class="petal"></span>
            <span class="petal"></span>
            <span class="petal"></span>
        </div>

        <div class="relative z-10 flex flex-col items-center w-full">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🌸</span>
                <span class="font-display font-semibold text-blush-600 text-2xl">Skincare Tracker</span>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white/80 backdrop-blur-sm border border-pink-100 shadow-sm overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>

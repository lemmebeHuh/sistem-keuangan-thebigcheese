
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'The Big Cheese') }}</title>
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-4xl bg-white shadow-md overflow-hidden sm:rounded-lg grid grid-cols-1 md:grid-cols-2">
                <!-- Kolom Kiri: Branding -->
                <div class="hidden md:flex flex-col items-center justify-center p-12 bg-brand-red text-white">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo The Big Cheese" class="w-40 h-40 rounded-full shadow-lg">
                    </a>
                    <h1 class="text-2xl font-bold mt-6 text-brand-yellow">The Big Cheese</h1>
                    <p class="mt-2 text-center text-sm opacity-80">Sistem Informasi Pengelolaan Keuangan</p>
                </div>

                <!-- Kolom Kanan: Form -->
                <div class="w-full px-6 py-12 sm:px-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
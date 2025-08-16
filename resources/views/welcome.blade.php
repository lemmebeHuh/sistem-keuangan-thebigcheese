<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Big Cheese - Kelezatan Pasta & Keju</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="bg-white">
            <!-- Header -->
            <header class="absolute inset-x-0 top-0 z-50">
                <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                    <div class="flex lg:flex-1">
                        <a href="#" class="-m-1.5 p-1.5 flex items-center">
                            <img class="h-12 w-auto rounded-full" src="{{ asset('images/logo.png') }}" alt="Logo The Big Cheese">
                            <span class="ml-4 text-xl font-bold text-brand-yellow">The Big Cheese</span>
                        </a>
                    </div>
                    <div class="lg:flex lg:flex-1 lg:justify-end">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold leading-6 text-gray-900">Dashboard <span aria-hidden="true">&rarr;</span></a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900">Masuk <span aria-hidden="true">&rarr;</span></a>
                            @endauth
                        @endif
                    </div>
                </nav>
            </header>

            <main>
                <!-- Hero Section -->
                <div class="relative isolate overflow-hidden bg-brand-red pt-14">
                    <div class="absolute inset-0 bg-repeat bg-center opacity-10" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M52.5 30C52.5 42.4264 42.4264 52.5 30 52.5C17.5736 52.5 7.5 42.4264 7.5 30C7.5 17.5736 17.5736 7.5 30 7.5C42.4264 7.5 52.5 17.5736 52.5 30Z\" stroke=\"%23FFD400\" stroke-width=\"2\" fill=\"none\"/></svg>');"></div>
                    <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56 relative z-10">
                        <div class="text-center">
                            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                                Kelezatan Pasta & Keju <span class="text-brand-yellow">Autentik</span>
                            </h1>
                            <p class="mt-6 text-lg leading-8 text-yellow-50">
                                Dibuat dengan bahan-bahan pilihan dan resep spesial, The Big Cheese hadir untuk memanjakan lidah Anda di setiap acara dan bazaar.
                            </p>
                            <div class="mt-10 flex items-center justify-center gap-x-6">
                                <a href="{{ route('login') }}" class="rounded-md bg-brand-yellow px-4 py-2.5 text-sm font-semibold text-brand-dark shadow-sm hover:bg-opacity-80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-yellow">Masuk ke Sistem</a>
                                <a href="#produk" class="text-sm font-semibold leading-6 text-white">Lihat Produk <span aria-hidden="true">→</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div id="produk" class="bg-white py-24 sm:py-32">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Menu Andalan Kami</h2>
                            <p class="mt-2 text-lg leading-8 text-gray-600">
                                Dari Macaroni klasik hingga Spaghetti yang menggugah selera.
                            </p>
                        </div>
                        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                            <article class="flex flex-col items-start justify-between">
                                <div class="relative w-full">
                                    <img src="https://placehold.co/600x400/F24C27/FFD400?text=Mac+%26+Cheese" alt="Gambar Mac & Cheese" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                                    <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                                </div>
                                <div class="max-w-xl">
                                    <div class="group relative">
                                        <h3 class="mt-6 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                            Macaroni and Cheese
                                        </h3>
                                        <p class="mt-3 text-sm leading-6 text-gray-600">Perpaduan sempurna antara makaroni yang lembut dengan saus keju creamy yang melimpah. Menu favorit sepanjang masa!</p>
                                    </div>
                                </div>
                            </article>
                            <article class="flex flex-col items-start justify-between">
                                <div class="relative w-full">
                                    <img src="https://placehold.co/600x400/1E1E1E/FFFFFF?text=Spaghetti" alt="Gambar Spaghetti Bolognese" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                                    <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                                </div>
                                <div class="max-w-xl">
                                    <div class="group relative">
                                        <h3 class="mt-6 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                            Spaghetti Bolognese
                                        </h3>
                                        <p class="mt-3 text-sm leading-6 text-gray-600">Spaghetti al dente disajikan dengan saus bolognese kaya rasa yang dimasak perlahan hingga meresap sempurna.</p>
                                    </div>
                                </div>
                            </article>
                            <article class="flex flex-col items-start justify-between">
                                <div class="relative w-full">
                                    <img src="https://placehold.co/600x400/FFD400/1E1E1E?text=Chilli+Dog" alt="Gambar Chilli Dog" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                                    <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                                </div>
                                <div class="max-w-xl">
                                    <div class="group relative">
                                        <h3 class="mt-6 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                            Chilli Dog (Hot Dog)
                                        </h3>
                                        <p class="mt-3 text-sm leading-6 text-gray-600">Sosis berkualitas dalam balutan roti lembut, disiram dengan saus chilli spesial yang pedas dan nikmat.</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-brand-dark">
                <div class="mx-auto max-w-7xl px-6 py-12">
                    <div class="mt-8 md:order-1 md:mt-0">
                        <p class="text-center text-xs leading-5 text-gray-400">&copy; {{ date('Y') }} The Big Cheese. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
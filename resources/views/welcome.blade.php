<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Big Cheese - Kelezatan Pasta & Keju</title>

        <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

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
                <!-- Hero Section (DESAIN ULANG) -->
                <div class="relative bg-brand-red overflow-hidden">
                    <div class="max-w-7xl mx-auto">
                        <div class="relative z-10 pb-8 bg-brand-red sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                            <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-brand-red transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                                <polygon points="50,0 100,0 50,100 0,100" />
                            </svg>
                            <div class="relative pt-6 px-4 sm:px-6 lg:px-8"></div>
                            <div class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                                <div class="sm:text-center lg:text-left">
                                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                                        <span class="block">Kelezatan Pasta</span>
                                        <span class="block text-brand-yellow xl:inline">& Keju Autentik</span>
                                    </h1>
                                    <p class="mt-3 text-base text-yellow-50 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                        Dibuat dengan bahan-bahan pilihan dan resep spesial, The Big Cheese hadir untuk memanjakan lidah Anda di setiap acara dan bazaar.
                                    </p>
                                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                        <div class="rounded-md shadow">
                                            <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-brand-dark bg-brand-yellow hover:bg-opacity-90 md:py-4 md:text-lg md:px-10">
                                                Masuk ke Sistem
                                            </a>
                                        </div>
                                        <div class="mt-3 sm:mt-0 sm:ml-3">
                                            <a href="#produk" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-500 hover:bg-red-600 md:py-4 md:text-lg md:px-10">
                                                Lihat Produk
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="{{ asset('images/mc.png') }}" alt="Mac and Cheese The Big Cheese">
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
                                    <img src="{{ asset('images/macn.jpg') }}" alt="Gambar Mac & Cheese" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
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
                                    <img src="{{ asset('images/spg.jpg') }}" alt="Gambar Spaghetti Bolognese" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
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
                                    <img src="{{ asset('images/cdog.jpg') }}" alt="Gambar Chilli Dog" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
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
            <footer class="bg-white border-t border-gray-200">
                <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">
                    <!-- Grid Utama -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8    text-sm">
                        <!-- Kolom 1: Brand & Deskripsi -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <img class="h-12 w-auto rounded-full" src="{{ asset('images/logo.png') }}" alt="Logo The Big Cheese">
                                <span class="text-xl font-bold text-brand-dark">{{ config('app.name') }}</span>
                            </div>
                            <p class="text-gray-600 leading-relaxed">
                                Menyajikan kelezatan pasta dan keju autentik dengan bahan-bahan pilihan untuk setiap momen spesial Anda.
                            </p>
                        </div>

                        <!-- Kolom 2: Navigasi & Kontak -->
                        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div>
                                <h3 class="font-semibold text-gray-900">Navigasi</h3>
                                <ul class="mt-4 space-y-2 text-gray-600">
                                    <li><a href="#" class="hover:text-brand-red transition-colors duration-300">Beranda</a></li>
                                    <li><a href="#produk" class="hover:text-brand-red transition-colors duration-300">Produk</a></li>
                                    <li><a href="{{ route('login') }}" class="hover:text-brand-red transition-colors duration-300">Login Sistem</a></li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Hubungi Kami</h3>
                                <ul class="mt-4 space-y-2 text-gray-600">
                                    <li><p>Jalan Telekomunikasi No. 1, Bandung</p></li>
                                    <li><p>+62 812-3456-7890</p></li>
                                    <li><p>info@thebigcheese.com</p></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Bawah: Copyright & Social Media -->
                    <div class="mt-10 border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center">
                        <p class="text-xs text-gray-500 md:order-1">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>
                        <div class="flex space-x-6 md:order-2 mt-4 md:mt-0">
                            <a href="#" class="text-gray-400 hover:text-brand-red transition-colors duration-300">
                                <span class="sr-only">Facebook</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-brand-red transition-colors duration-300">
                                <span class="sr-only">Instagram</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-brand-red transition-colors duration-300">
                                <span class="sr-only">TikTok</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
                                <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Big Cheese - Kelezatan Pasta & Keju Autentik</title>
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-white">
        
        <!-- Header -->
        <header class="bg-white backdrop-blur-md fixed top-0 left-0 right-0 z-50 shadow-sm" x-data="{ open: false }">
            <nav class="mx-auto flex max-w-7xl items-center justify-between p-4 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="#" class="-m-1.5 p-1.5 flex items-center space-x-3">
                        <img class="h-10 w-auto rounded-full" src="{{ asset('images/logo.png') }}" alt="Logo The Big Cheese">
                    </a>
                </div>
                <div class="flex lg:hidden">
                    <button type="button" @click="open = ! open" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Buka menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="#produk" class="text-sm font-semibold leading-6 text-gray-900">Produk</a>
                    <a href="#tentang" class="text-sm font-semibold leading-6 text-gray-900">Tentang Kami</a>
                    <a href="#kontak" class="text-sm font-semibold leading-6 text-gray-900">Kontak</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-md bg-brand-red px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-red">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-md bg-brand-red px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-red">Masuk</a>
                        @endauth
                    @endif
                </div>
            </nav>
            <!-- Mobile menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-white border-t border-gray-200 shadow-md">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="#produk" @click="open = false" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Produk</a>
                    <a href="#tentang" @click="open = false" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Tentang Kami</a>
                    <a href="#kontak" @click="open = false" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Kontak</a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="px-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="block w-full text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="block w-full text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Masuk</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Section -->
            <section class="relative h-[600px] md:h-screen flex items-center">
                <div class="absolute inset-0">
                    <img src="{{ asset('images/mc.png') }}" class="w-full h-full object-cover" alt="Sajian Pasta The Big Cheese">
                    <div class="absolute inset-0 bg-black/50"></div>
                </div>
                <div class="relative mx-auto max-w-7xl px-6 text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl">
                        Rasa <span class="text-brand-yellow">Autentik</span> di Setiap Gigitan
                    </h1>
                    <p class="mt-6 max-w-2xl mx-auto text-lg text-gray-200">
                        Kami menyajikan kelezatan pasta dan keju terbaik yang dibuat dengan cinta, khusus untuk memeriahkan setiap momen Anda.
                    </p>
                    <div class="mt-10">
                        <a href="#produk" class="rounded-md bg-brand-yellow px-8 py-3 text-base font-semibold text-brand-dark shadow-lg hover:bg-opacity-90 transition-transform transform hover:scale-105">
                            Lihat Menu Andalan
                        </a>
                    </div>
                </div>
            </section>

            <!-- Products Section -->
            <section id="produk" class="py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Menu Andalan Kami</h2>
                        <p class="mt-2 text-lg leading-8 text-gray-600">
                            Dari Macaroni klasik hingga Spaghetti yang menggugah selera.
                        </p>
                    </div>
                    <div class="mx-auto mt-16 grid max-w-md grid-cols-1 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-3 lg:gap-x-8">
                        <article class="flex flex-col items-start rounded-2xl shadow-lg overflow-hidden transition-transform transform hover:-translate-y-2">
                            <img src="{{ asset('images/macn.jpg') }}" alt="Gambar Mac & Cheese" class="w-full h-56 object-cover">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900">Macaroni and Cheese</h3>
                                <p class="mt-3 text-sm leading-6 text-gray-600">Perpaduan sempurna antara makaroni lembut dengan saus keju creamy yang melimpah. Menu favorit sepanjang masa!</p>
                            </div>
                        </article>
                        <article class="flex flex-col items-start rounded-2xl shadow-lg overflow-hidden transition-transform transform hover:-translate-y-2">
                            <img src="{{ asset('images/spg.jpg') }}" alt="Gambar Spaghetti Bolognese" class="w-full h-56 object-cover">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900">Spaghetti Bolognese</h3>
                                <p class="mt-3 text-sm leading-6 text-gray-600">Spaghetti al dente disajikan dengan saus bolognese kaya rasa yang dimasak perlahan hingga meresap sempurna.</p>
                            </div>
                        </article>
                        <article class="flex flex-col items-start rounded-2xl shadow-lg overflow-hidden transition-transform transform hover:-translate-y-2">
                            <img src="{{ asset('images/cdog.jpg') }}" alt="Gambar Chilli Dog" class="w-full h-56 object-cover">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900">Chilli Dog (Hot Dog)</h3>
                                <p class="mt-3 text-sm leading-6 text-gray-600">Sosis berkualitas dalam balutan roti lembut, disiram dengan saus chilli spesial yang pedas dan nikmat.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer id="kontak" class="bg-white border-t border-gray-200">
            <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <img class="h-12 w-auto rounded-full" src="{{ asset('images/logo.png') }}" alt="Logo The Big Cheese">
                            <span class="text-xl font-bold text-brand-dark">{{ config('app.name') }}</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed">Menyajikan kelezatan pasta dan keju autentik dengan bahan-bahan pilihan untuk setiap momen spesial Anda.</p>
                    </div>
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
                <div class="mt-10 border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-xs text-gray-500 md:order-1">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
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
    </body>
</html>
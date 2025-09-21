<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Badung Lapor - Sistem Pengaduan Masyarakat</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-black">
    <div class="relative min-h-screen flex flex-col items-center justify-center bg-center bg-gray-100 dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1537953773345-d1ab3cc5a62f?q=80&w=2070&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-black opacity-60"></div>
        </div>

        <div class="relative w-full max-w-7xl mx-auto px-6 lg:px-8 z-10">
            <header class="flex items-center justify-between py-8">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo-badung.png') }}" alt="Logo Kabupaten Badung" class="h-12 w-auto">
                    <span class="ml-4 text-xl font-bold text-white">Badung Lapor</span>
                </div>
                <nav>
                    @if (Route::has('login'))
                    @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="rounded-md px-4 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                        Dashboard
                    </a>
                    @else
                    <a
                        href="{{ route('login') }}"
                        class="rounded-md px-4 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                        Log in
                    </a>

                    @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="ml-4 rounded-md px-4 py-2 text-black bg-white transition hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                        Register
                    </a>
                    @endif
                    @endauth
                    @endif
                </nav>
            </header>

            <main class="mt-20 text-center">
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white leading-tight">
                        Suarakan Aspirasi Anda untuk Badung yang Lebih Baik
                    </h1>
                    <p class="mt-6 text-lg text-gray-300">
                        Punya keluhan, masukan, atau laporan terkait layanan publik di Kabupaten Badung? Sampaikan langsung melalui platform resmi kami. Laporan Anda akan kami tindak lanjuti dengan cepat dan transparan.
                    </p>
                    <div class="mt-8">
                        @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block rounded-lg bg-indigo-600 px-8 py-4 text-lg font-semibold text-white shadow-lg transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                            Lihat Dashboard
                        </a>
                        @else
                        <a href="{{ route('register') }}" class="inline-block rounded-lg bg-indigo-600 px-8 py-4 text-lg font-semibold text-white shadow-lg transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                            Buat Laporan Sekarang
                        </a>
                        @endauth
                    </div>
                </div>
            </main>

            <footer class="py-16 mt-20 text-center text-sm text-white/70">
                Pemerintah Kabupaten Badung &copy; {{ date('Y') }}
            </footer>
        </div>
    </div>
</body>

</html>
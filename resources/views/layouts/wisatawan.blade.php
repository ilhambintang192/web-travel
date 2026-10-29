<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Jelajah Nusa — Wisata Travel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#E6F2F2', 100:'#CCE5E5', 200:'#99CBCB', 300:'#66B1B1', 400:'#339797', 500:'#1B6B6D', 600:'#165757', 700:'#114343', 800:'#0B2E2E', 900:'#061A1A' },
                        accent:  { 50:'#FEF5E7', 100:'#FDEACD', 200:'#FBD59B', 300:'#F9C069', 400:'#F7AB37', 500:'#F5A623', 600:'#D4880E', 700:'#A0660A', 800:'#6C4507', 900:'#382303' },
                        cream:   { 50:'#FEFDFB', 100:'#FBF8F4', 200:'#F5EFE6', 300:'#EFE6D8' },
                        dark:    '#1A2E35',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .nav-link { @apply text-gray-600 hover:text-primary-500 transition-colors font-medium; }
        .nav-link.active { @apply text-primary-500 font-semibold; }
    </style>
    @yield('head')
</head>
<body class="bg-cream-100 text-dark min-h-screen flex flex-col">
    {{-- NAVBAR --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-primary-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <span class="text-xl font-bold text-dark">Jelajah Nusa</span>
                </a>

                {{-- Nav Links --}}
                <div class="hidden md:flex items-center gap-8">
                    @auth
                        <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
                    @else
                        <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                    @endauth
                    <a href="/paket-wisata" class="nav-link {{ request()->is('paket-wisata*') ? 'active' : '' }}">Paket Wisata</a>
                    <a href="/custom-trip" class="nav-link {{ request()->is('custom-trip*') ? 'active' : '' }}">Custom Trip</a>
                    <a href="/pesanan-saya" class="nav-link {{ request()->is('pesanan-saya*') ? 'active' : '' }}">Pesanan Saya</a>
                </div>

                {{-- Auth Buttons --}}
                <div class="flex items-center gap-3">
                    @auth
                        {{-- Menu pengguna (dropdown) --}}
                        <div class="relative" id="user-menu">
                            <button type="button" onclick="document.getElementById('user-dropdown').classList.toggle('hidden')" class="flex items-center gap-2 focus:outline-none" aria-haspopup="true">
                                <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                                <div class="w-9 h-9 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ collect(explode(' ', trim(Auth::user()->name)))->filter()->take(2)->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))->implode('') }}
                                </div>
                                <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div id="user-dropdown" class="hidden absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-dark truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="/profil" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-cream-100 transition">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profil Saya
                                </a>
                                <a href="/ubah-password" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-cream-100 transition">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4"/></svg>
                                    Ubah Password
                                </a>
                                <form action="/logout" method="POST" class="border-t border-gray-100 mt-1 pt-1">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                        {{-- Mobile menu --}}
                        <div class="md:hidden relative" x-data="{ open: false }">
                            <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </button>
                        </div>
                    @else
                        <a href="/login" class="text-sm font-medium text-primary-500 hover:text-primary-600 transition">Masuk</a>
                        <a href="/register" class="bg-primary-500 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-primary-600 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Mobile Nav --}}
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-4 pb-4">
            @auth
                <a href="/dashboard" class="block py-2 text-gray-700 hover:text-primary-500">Dashboard</a>
            @else
                <a href="/" class="block py-2 text-gray-700 hover:text-primary-500">Beranda</a>
            @endauth
            <a href="/paket-wisata" class="block py-2 text-gray-700 hover:text-primary-500">Paket Wisata</a>
            <a href="/custom-trip" class="block py-2 text-gray-700 hover:text-primary-500">Custom Trip</a>
            <a href="/pesanan-saya" class="block py-2 text-gray-700 hover:text-primary-500">Pesanan Saya</a>
            @auth
                <a href="/profil" class="block py-2 text-gray-700 hover:text-primary-500 mt-2 border-t border-gray-100 pt-3">Profil Saya</a>
                <a href="/ubah-password" class="block py-2 text-gray-700 hover:text-primary-500">Ubah Password</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-red-500 hover:text-red-600">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div id="flash-success" class="max-w-7xl mx-auto px-4 mt-4">
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">&times;</button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">&times;</button>
        </div>
    </div>
    @endif

    {{-- MAIN CONTENT --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @yield('footer')

    @yield('scripts')
    <script>
        // Tutup dropdown profil saat klik di luar menu atau tekan Esc
        document.addEventListener('click', function (e) {
            var menu = document.getElementById('user-menu');
            var dd = document.getElementById('user-dropdown');
            if (menu && dd && !menu.contains(e.target)) dd.classList.add('hidden');
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                var dd = document.getElementById('user-dropdown');
                if (dd) dd.classList.add('hidden');
            }
        });
    </script>
</body>
</html>

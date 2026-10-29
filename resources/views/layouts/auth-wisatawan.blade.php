<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Jelajah Nusa')</title>
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
    <style>body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }</style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        {{-- Left: Image Panel --}}
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <img src="@yield('bg_image', 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200')" alt="Jelajah Nusa" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-dark/70 via-dark/20 to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end p-12 text-white">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <span class="font-semibold">Jelajah Nusa</span>
                </div>
                <h2 class="text-3xl font-bold leading-tight mb-3">Satu akun untuk semua perjalanan Anda.</h2>
                <p class="text-white/80 text-sm">Kuota real-time · pembayaran terverifikasi · tiket QR digital</p>
            </div>
        </div>

        {{-- Right: Form Panel --}}
        <div class="w-full lg:w-1/2 bg-cream-100 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                {{-- Flash Messages --}}
                @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">&times;</button>
                </div>
                @endif

                @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">&times;</button>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>

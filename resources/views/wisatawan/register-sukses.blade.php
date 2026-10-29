@extends('layouts.auth-wisatawan')
@section('title', 'Registrasi Berhasil — Jelajah Nusa')
@section('bg_image', 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=1200')

@section('content')
<div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mb-6">
    <svg class="w-7 h-7 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
</div>
<h1 class="text-3xl font-bold text-dark mb-3">Akun berhasil dibuat!</h1>
<p class="text-gray-500 mb-6">Selamat datang di Jelajah Nusa. Akun Anda siap digunakan untuk merencanakan perjalanan berikutnya.</p>

<div class="mb-2">
    <label class="block text-sm font-semibold text-dark mb-1.5">Email terdaftar</label>
    <div class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-600">{{ session('registered_email', 'user@email.com') }}</div>
</div>
<p class="flex items-center gap-1.5 text-sm text-green-600 font-medium mb-8"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Akun wisatawan aktif</p>

<a href="/dashboard" class="block w-full bg-primary-500 hover:bg-primary-600 text-white text-center font-semibold py-3 rounded-xl transition mb-3">Lanjut ke Dashboard</a>
<a href="/paket-wisata" class="block w-full border-2 border-primary-500 text-primary-500 hover:bg-primary-50 text-center font-semibold py-3 rounded-xl transition">Jelajahi Paket Wisata</a>
@endsection

@extends('layouts.auth-wisatawan')
@section('title', 'Masuk — Jelajah Nusa')
@section('bg_image', 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200')

@section('content')
<h1 class="text-3xl font-bold text-dark mb-2">Selamat datang kembali</h1>
<p class="text-gray-500 mb-8">Masuk untuk memesan paket atau mengelola perjalanan</p>

<form action="/login-proses" method="POST">
    @csrf
    <div class="mb-4">
        <label class="block text-sm font-semibold text-dark mb-1.5">Username</label>
        <input type="email" name="email" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition" placeholder="Masukkan username" required>
    </div>
    <div class="mb-6">
        <label class="block text-sm font-semibold text-dark mb-1.5">Password</label>
        <input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition" placeholder="••••••••" required>
    </div>
    <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3 rounded-xl transition">Masuk</button>
</form>
<p class="mt-6 text-center text-sm text-gray-500">Belum punya akun? <a href="/register" class="text-primary-500 font-semibold hover:underline">Daftar sekarang</a></p>
@endsection

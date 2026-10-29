@extends('layouts.auth-wisatawan')
@section('title', 'Daftar — Jelajah Nusa')
@section('bg_image', 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=1200')

@section('content')
<h1 class="text-3xl font-bold text-dark mb-2">Buat akun wisatawan</h1>
<p class="text-gray-500 mb-6">Isi data diri Anda untuk mulai memesan</p>

<form action="/register-proses" method="POST">
    @csrf
    <div class="mb-4">
        <label class="block text-sm font-semibold text-dark mb-1.5">Nama lengkap</label>
        <input type="text" name="name" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition" placeholder="Nama sesuai KTP" required value="{{ old('name') }}">
        @error('name')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
    </div>
    <div class="mb-4">
        <label class="block text-sm font-semibold text-dark mb-1.5">Email</label>
        <input type="email" name="email" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition" placeholder="nama@email.com" required value="{{ old('email') }}">
        @error('email')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
    </div>
    <div class="mb-4">
        <label class="block text-sm font-semibold text-dark mb-1.5">No. HP</label>
        <input type="text" name="phone" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition" placeholder="08xx xxxx xxxx" value="{{ old('phone') }}">
    </div>
    <div class="mb-4">
        <label class="block text-sm font-semibold text-dark mb-1.5">Password</label>
        <input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition" placeholder="Minimal 8 karakter" required>
        @error('password')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
    </div>
    <div class="mb-6">
        <label class="block text-sm font-semibold text-dark mb-1.5">Konfirmasi password</label>
        <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition" placeholder="Ulangi password" required>
    </div>
    <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3 rounded-xl transition">Daftar</button>
</form>
<p class="mt-6 text-center text-sm text-gray-500">Sudah punya akun? <a href="/login" class="text-primary-500 font-semibold hover:underline">Masuk</a></p>
@endsection

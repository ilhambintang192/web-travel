@extends('layouts.wisatawan')
@section('title', 'Profil Saya — Jelajah Nusa')

@section('content')
@php
    $inisial = collect(explode(' ', trim($user->name)))->filter()->take(2)->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))->implode('');
    $bergabung = !empty($user->created_at) ? \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') : null;
@endphp
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-dark mb-1">Profil Saya</h1>
    <p class="text-gray-500 mb-8">Kelola informasi akun dan keamanan Anda.</p>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Kartu ringkasan --}}
        <div class="w-full lg:w-80 flex-shrink-0 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                <div class="w-24 h-24 bg-primary-500 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">{{ $inisial }}</div>
                <h2 class="text-xl font-bold text-dark">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 mb-3">{{ $user->email }}</p>
                <span class="inline-block bg-primary-100 text-primary-600 text-xs font-semibold px-3 py-1 rounded-full">{{ $user->role ?? 'Wisatawan' }}</span>
                @if($bergabung)
                <p class="text-xs text-gray-400 mt-4">Bergabung sejak {{ $bergabung }}</p>
                @endif

                <div class="grid grid-cols-2 gap-3 mt-6 pt-6 border-t border-gray-100">
                    <div class="bg-cream-100 rounded-xl py-3">
                        <p class="text-2xl font-bold text-primary-500">{{ $statistik['pesanan'] }}</p>
                        <p class="text-xs text-gray-500">Pesanan</p>
                    </div>
                    <div class="bg-cream-100 rounded-xl py-3">
                        <p class="text-2xl font-bold text-primary-500">{{ $statistik['tiket'] }}</p>
                        <p class="text-xs text-gray-500">Tiket</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-4 space-y-1">
                <a href="/ubah-password" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-cream-100 transition">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4"/></svg>
                    Ubah Password
                </a>
                <a href="/pesanan-saya" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-cream-100 transition">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Pesanan Saya
                </a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 transition text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar (Logout)
                    </button>
                </form>
            </div>
        </div>

        {{-- Form edit profil --}}
        <div class="flex-1">
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h2 class="text-xl font-bold text-dark mb-1">Informasi Pribadi</h2>
                <p class="text-gray-500 text-sm mb-6">Perbarui nama dan kontak yang digunakan untuk pemesanan.</p>

                @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form action="/profil" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-dark mb-1.5">Nama lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-dark mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" required>
                    </div>
                    @if($punyaHp)
                    <div>
                        <label class="block text-sm font-semibold text-dark mb-1.5">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $noHp) }}" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" placeholder="0812 3456 7890">
                    </div>
                    @endif
                    @if($punyaAlamat)
                    <div>
                        <label class="block text-sm font-semibold text-dark mb-1.5">Alamat</label>
                        <textarea name="alamat" rows="3" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm resize-none">{{ old('alamat', $alamat) }}</textarea>
                    </div>
                    @endif
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold px-6 py-3 rounded-xl transition">Simpan Perubahan</button>
                        <a href="/dashboard" class="text-sm font-medium text-gray-500 hover:text-gray-700">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

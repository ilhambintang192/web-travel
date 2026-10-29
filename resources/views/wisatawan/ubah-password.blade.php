@extends('layouts.wisatawan')
@section('title', 'Ubah Password — Jelajah Nusa')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="/profil" class="text-sm font-medium text-primary-500 hover:text-primary-600 inline-flex items-center gap-1 mb-4">← Kembali ke profil</a>

    <div class="bg-white rounded-2xl shadow-sm p-8">
        <h1 class="text-2xl font-bold text-dark mb-1">Ubah Password</h1>
        <p class="text-gray-500 text-sm mb-6">Masukkan password lama, lalu tentukan password baru (minimal 6 karakter).</p>

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="/ubah-password" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-dark mb-1.5">Password lama</label>
                <input type="password" name="password_lama" autocomplete="current-password" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-dark mb-1.5">Password baru</label>
                <input type="password" name="password" autocomplete="new-password" minlength="6" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-dark mb-1.5">Konfirmasi password baru</label>
                <input type="password" name="password_confirmation" autocomplete="new-password" minlength="6" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" required>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold px-6 py-3 rounded-xl transition">Simpan Password</button>
                <a href="/profil" class="text-sm font-medium text-gray-500 hover:text-gray-700">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

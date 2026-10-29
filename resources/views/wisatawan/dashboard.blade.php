@extends('layouts.wisatawan')
@section('title', 'Dashboard — Jelajah Nusa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-dark">Halo, {{ Auth::user()->name ?? 'Wisatawan' }}</h1>
            <p class="text-gray-500 mt-1">Berikut ringkasan perjalanan Anda</p>
        </div>
        <div class="flex gap-3 mt-4 sm:mt-0">
            <a href="/pesanan-saya" class="border-2 border-primary-500 text-primary-500 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary-50 transition">Lihat Semua Pesanan</a>
            <a href="/custom-trip" class="bg-accent-500 hover:bg-accent-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">Ajukan Custom Trip</a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        @php
            $stats = [
                ['label'=>'Pesanan aktif','value'=> $pesanan_aktif ?? 0,'color'=>'primary'],
                ['label'=>'Pembayaran perlu diselesaikan','value'=> $pembayaran_pending ?? 0,'color'=>'primary'],
                ['label'=>'Tiket tersedia','value'=> $tiket_tersedia ?? 0,'color'=>'primary'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-2">{{ $s['label'] }}</p>
            <p class="text-4xl font-bold text-{{ $s['color'] }}-500">{{ $s['value'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Keberangkatan Terdekat --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-2/5 relative">
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600" alt="Trip" class="w-full h-64 md:h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-dark/70 to-transparent flex flex-col justify-end p-6">
                    <span class="inline-block bg-accent-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full mb-2 w-fit">Keberangkatan terdekat</span>
                    <h3 class="text-white text-xl font-bold">Solo – Bali 4H3M</h3>
                    <p class="text-white/80 text-sm">12 Des 2026 · kumpul 05.00 WIB di Terminal Tirtonadi</p>
                </div>
            </div>
            <div class="md:w-3/5 p-6">
                <span class="inline-block bg-accent-100 text-accent-600 text-xs font-semibold px-3 py-1 rounded-full mb-3">Keberangkatan terdekat</span>
                <h3 class="text-2xl font-bold text-dark mb-1">Solo – Bali 4H3M</h3>
                <p class="text-gray-500 mb-4">12 Des 2026 · kumpul 05.00 WIB di Terminal Tirtonadi</p>
                <div class="flex gap-4 mb-4">
                    <div class="bg-cream-100 rounded-xl px-4 py-3 flex-1"><p class="text-xs text-gray-400">Destinasi</p><p class="font-semibold">Bali</p></div>
                    <div class="bg-cream-100 rounded-xl px-4 py-3 flex-1"><p class="text-xs text-gray-400">Durasi</p><p class="font-semibold">4 hari 3 malam</p></div>
                </div>
                <div class="flex items-center justify-between">
                    <div><p class="text-xs text-gray-400">Status tiket</p><span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Tiket tersedia</span></div>
                    <a href="/tiket" class="border-2 border-accent-500 text-accent-500 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-accent-50 transition">Lihat Tiket</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Cards --}}
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-cream-100 rounded-2xl p-6 border border-cream-200">
            <h3 class="text-lg font-bold text-dark mb-2">Perlu dibayar</h3>
            <p class="text-gray-600 mb-1 font-medium">#PSN-1042 · Rp 7.000.000</p>
            <p class="text-red-500 text-sm mb-4">Batas bayar 25 Okt 2026, 23.59</p>
            <a href="/pembayaran" class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">Bayar Sekarang</a>
        </div>
        <div class="bg-cream-100 rounded-2xl p-6 border border-cream-200">
            <h3 class="text-lg font-bold text-dark mb-2">Custom trip Anda</h3>
            <p class="text-gray-600 mb-1">Raja Ampat · 6 orang</p>
            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full mb-4">Ditawarkan</span><br>
            <a href="/custom-trip/daftar" class="inline-block border border-dark text-dark px-5 py-2 rounded-xl text-sm font-semibold hover:bg-white transition">Lihat Penawaran</a>
        </div>
    </div>
</div>
@endsection

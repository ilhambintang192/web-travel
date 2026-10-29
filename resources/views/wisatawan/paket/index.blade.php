@extends('layouts.wisatawan')
@section('title', 'Paket Wisata — Jelajah Nusa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar Filter --}}
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                <h3 class="font-bold text-dark text-lg mb-5">Filter</h3>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-dark mb-1.5">Destinasi</label>
                    <select class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-primary-500 outline-none bg-white">
                        <option>Semua destinasi</option><option>Bali</option><option>Jawa Timur</option><option>Papua</option><option>NTT</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-dark mb-1.5">Jenis layanan</label>
                    <select class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-primary-500 outline-none bg-white">
                        <option>Open Trip / Paket Reguler</option><option>Open Trip</option><option>Paket Reguler</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-dark mb-1.5">Tanggal berangkat</label>
                    <input type="date" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-primary-500 outline-none">
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-dark mb-1.5">Rentang harga</label>
                    <input type="range" min="500000" max="10000000" class="w-full accent-primary-500">
                    <p class="text-xs text-gray-400 mt-1">Rp 500.000 – Rp 5.000.000</p>
                </div>
                <button class="w-full bg-primary-500 hover:bg-primary-600 text-white py-2.5 rounded-xl text-sm font-semibold transition">Terapkan Filter</button>
            </div>
        </aside>

        {{-- Package Grid --}}
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-dark">Paket Wisata ({{ count($data) }})</h1>
                <select class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 outline-none bg-white"><option>Urutkan: Terdekat</option><option>Harga terendah</option><option>Harga tertinggi</option></select>
            </div>
            <div class="grid sm:grid-cols-2 gap-6">
                @php $imgs = [
                    'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500',
                    'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=500',
                    'https://images.unsplash.com/photo-1570789210967-2cac24ee7399?w=500',
                    'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=500',
                ]; @endphp
                @foreach($data as $i => $paket)
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition">
                    <div class="relative">
                        <img src="{{ $imgs[$i % count($imgs)] }}" alt="{{ $paket->nama_paket }}" class="w-full h-52 object-cover">
                        <span class="absolute top-3 left-3 bg-primary-500/90 text-white text-xs font-semibold px-2.5 py-1 rounded-full">{{ $paket->jenis_layanan ?? 'Open Trip' }}</span>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-primary-500 border border-primary-500 px-2 py-0.5 rounded-full">{{ $paket->jenis_layanan ?? 'Open Trip' }}</span>
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Sisa {{ rand(5,15) }} kursi</span>
                        </div>
                        <h3 class="font-bold text-dark text-lg mb-2">{{ $paket->nama_paket }}</h3>
                        <p class="text-gray-500 text-sm flex items-center gap-1.5 mb-1">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $paket->destinasi }} · {{ $paket->durasi_hari }}H{{ $paket->durasi_hari - 1 }}M
                        </p>
                        <p class="text-gray-500 text-sm flex items-center gap-1.5 mb-4">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Berangkat {{ \Carbon\Carbon::now()->addDays(rand(10,60))->format('d M Y') }}
                        </p>
                        <div class="flex items-center justify-between">
                            <p class="text-xl font-bold text-primary-500">Rp {{ number_format($paket->harga,0,',','.') }}</p>
                            <a href="/paket-wisata/{{ $paket->id }}" class="border border-dark text-dark px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.wisatawan')
@section('title', 'Pesanan Saya — Jelajah Nusa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-dark mb-1">Pesanan Saya</h1>
    <p class="text-gray-500 mb-6">Pantau status pembayaran, keberangkatan, dan tiket digital untuk semua perjalananmu.</p>

    {{-- Tabs --}}
    <div class="flex gap-6 border-b border-gray-200 mb-8">
        <button class="pb-3 text-sm font-semibold text-primary-500 border-b-2 border-primary-500">Semua ({{ count($data) }})</button>
        <button class="pb-3 text-sm font-medium text-gray-400 hover:text-gray-600">Menunggu</button>
        <button class="pb-3 text-sm font-medium text-gray-400 hover:text-gray-600">Dikonfirmasi</button>
        <button class="pb-3 text-sm font-medium text-gray-400 hover:text-gray-600">Selesai</button>
        <button class="pb-3 text-sm font-medium text-gray-400 hover:text-gray-600">Dibatalkan</button>
    </div>

    {{-- Order Cards --}}
    <div class="space-y-4">
        @php $imgs=['https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=300','https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=300','https://images.unsplash.com/photo-1570789210967-2cac24ee7399?w=300','https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=300']; $dests=['Bali','Jawa Timur','NTT','Papua']; $names=['Solo – Bali 4H3M','Bromo Sunrise 2H1M','Labuan Bajo Sailing','Raja Ampat Explorer']; @endphp
        @forelse($data as $i => $pesanan)
        <div class="bg-white rounded-2xl shadow-sm p-4 flex flex-col sm:flex-row gap-4 hover:shadow-md transition">
            <div class="relative w-full sm:w-48 h-40 sm:h-auto flex-shrink-0 rounded-xl overflow-hidden">
                <img src="{{ $imgs[$i % count($imgs)] }}" alt="Trip" class="w-full h-full object-cover">
                <span class="absolute bottom-2 left-2 bg-dark/70 text-white text-xs font-semibold px-2 py-0.5 rounded-md">{{ $dests[$i % count($dests)] }}</span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-dark text-lg">{{ $names[$i % count($names)] }}</h3>
                    <p class="text-sm text-gray-500 mb-2">Berangkat {{ \Carbon\Carbon::now()->addDays(rand(5,60))->format('d M Y') }}</p>
                    <div class="flex flex-wrap gap-2">
                        @if(($pesanan->status ?? '') === 'Lunas')
                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Bayar: terverifikasi</span>
                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Keberangkatan dikonfirmasi</span>
                        @else
                        <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full">Bayar: menunggu</span>
                        <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full">Belum dikonfirmasi</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-end justify-between gap-3">
                <span class="border border-primary-500 text-primary-500 text-xs font-semibold px-2.5 py-1 rounded-full">#PSN-{{ str_pad($pesanan->id ?? $loop->iteration, 4, '0', STR_PAD_LEFT) }}</span>
                <p class="text-xl font-bold text-primary-500">Rp {{ number_format($pesanan->total_biaya ?? $pesanan->total_harga ?? $pesanan->harga ?? 3500000, 0,',','.') }}</p>
                @if(($pesanan->status ?? '') === 'Lunas')
                <a href="/tiket" class="border-2 border-primary-500 text-primary-500 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-primary-50 transition">Lihat Tiket</a>
                @else
                <a href="/pembayaran" class="bg-accent-500 hover:bg-accent-600 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">Bayar Sekarang</a>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-gray-400 font-medium">Belum ada pesanan</p>
            <a href="/paket-wisata" class="inline-block mt-4 bg-primary-500 hover:bg-primary-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">Jelajahi Paket Wisata</a>
        </div>
        @endforelse
    </div>
</div>
@endsection

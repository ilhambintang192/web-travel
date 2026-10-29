@extends('layouts.wisatawan')
@section('title', 'Pesanan Berhasil — Jelajah Nusa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-dark mb-6">Pemesanan Paket</h1>
    {{-- Step Bar --}}
    <div class="flex items-center gap-2 mb-10">
        @php $steps=['Jadwal & Jumlah','Data Peserta','Ringkasan','Konfirmasi']; @endphp
        @foreach($steps as $i=>$s)
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-green-500 text-white">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
            </div>
            <span class="text-sm font-semibold text-dark hidden sm:inline">{{ $s }}</span>
        </div>
        @if($i<3)<div class="flex-1 h-px bg-green-300 mx-1"></div>@endif
        @endforeach
    </div>

    {{-- Success --}}
    <div class="max-w-2xl mx-auto text-center">
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-8 justify-center">
            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <span class="text-sm font-medium">Pesanan berhasil dibuat</span>
        </div>

        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <h2 class="text-3xl font-bold text-dark mb-3">Pesanan Anda berhasil dibuat!</h2>
        <p class="text-gray-500 mb-8">Satu langkah lagi menuju Bali. Selesaikan pembayaran untuk mengamankan perjalanan Anda.</p>

        {{-- Order Summary --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 text-left mb-6">
            <h3 class="font-bold text-dark text-lg mb-4">Pesanan #PSN-{{ rand(1000,9999) }}</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Paket wisata</span><span class="font-medium text-dark">Solo – Bali 4H3M</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Keberangkatan</span><span class="font-medium text-dark">12 Des 2026 · 05.00 WIB</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Meeting point</span><span class="font-medium text-dark">Terminal Tirtonadi, Solo</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Pemesan</span><span class="font-medium text-dark">{{ Auth::user()->name ?? 'Wisatawan' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Jumlah peserta</span><span class="font-medium text-dark">2 orang</span></div>
            </div>
            <div class="border-t border-gray-100 mt-4 pt-4 flex justify-between items-center">
                <span class="text-gray-500">Total pembayaran</span>
                <span class="text-2xl font-bold text-primary-500">Rp 7.000.000</span>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mt-5">
                <p class="text-sm text-yellow-700 font-semibold flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> Batas pembayaran: {{ now()->addDays(1)->format('d M Y') }} 23.59</p>
                <p class="text-xs text-yellow-600 mt-1">Lakukan transfer dan unggah bukti pembayaran sebelum batas waktu. Tiket tersedia setelah verifikasi admin.</p>
            </div>
        </div>

        <div class="flex gap-4 justify-center">
            <a href="/pembayaran" class="bg-accent-500 hover:bg-accent-600 text-white px-8 py-3 rounded-xl font-semibold transition">Bayar Sekarang</a>
            <a href="/pesanan-saya" class="border-2 border-dark text-dark px-8 py-3 rounded-xl font-semibold hover:bg-gray-50 transition">Lihat Pesanan Saya</a>
        </div>
    </div>
</div>
@endsection

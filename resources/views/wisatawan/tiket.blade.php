@extends('layouts.wisatawan')
@section('title', 'Tiket Digital — Jelajah Nusa')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-dark text-center mb-10">Tiket Digital Anda</h1>

    @forelse($data as $tiket)
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col md:flex-row mb-6">
        {{-- Left - Ticket Info --}}
        <div class="md:w-3/5 bg-gradient-to-br from-primary-500 to-primary-700 text-white p-8 relative">
            <span class="inline-block bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full mb-4">Terverifikasi</span>
            <h2 class="text-2xl font-bold mb-2">Solo – Bali 4H3M</h2>
            <p class="text-white/80 mb-6">Peserta: {{ Auth::user()->name ?? 'Wisatawan' }}</p>
            <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                <div><p class="text-white/60 text-xs">Berangkat</p><p class="font-bold">12 Des 2026</p></div>
                <div><p class="text-white/60 text-xs">Jam kumpul</p><p class="font-bold">05.00 WIB</p></div>
                <div><p class="text-white/60 text-xs">Meeting point</p><p class="font-bold">Terminal Tirtonadi</p></div>
                <div><p class="text-white/60 text-xs">Kendaraan</p><p class="font-bold">Hiace Premio</p></div>
            </div>
            <p class="text-sm text-white/70">Kode tiket: <span class="font-bold text-white">JN-{{ $tiket->kode_tiket ?? 'PSN1042-01' }}</span></p>
        </div>

        {{-- Right - QR Code --}}
        <div class="md:w-2/5 p-8 flex flex-col items-center justify-center bg-white">
            {{-- QR Code Placeholder --}}
            <div class="w-40 h-40 bg-dark rounded-xl flex items-center justify-center mb-4 p-3">
                <svg viewBox="0 0 100 100" class="w-full h-full">
                    <rect fill="white" width="100" height="100"/>
                    @for($r=0;$r<10;$r++)@for($c=0;$c<10;$c++)@if(rand(0,1))<rect x="{{ $c*10 }}" y="{{ $r*10 }}" width="10" height="10" fill="#1A2E35"/>@endif @endfor @endfor
                    <rect x="5" y="5" width="25" height="25" fill="none" stroke="#1A2E35" stroke-width="3"/><rect x="10" y="10" width="15" height="15" fill="#1A2E35"/>
                    <rect x="70" y="5" width="25" height="25" fill="none" stroke="#1A2E35" stroke-width="3"/><rect x="75" y="10" width="15" height="15" fill="#1A2E35"/>
                    <rect x="5" y="70" width="25" height="25" fill="none" stroke="#1A2E35" stroke-width="3"/><rect x="10" y="75" width="15" height="15" fill="#1A2E35"/>
                </svg>
            </div>
            <p class="text-sm text-gray-500 mb-4">Pindai untuk verifikasi</p>
            <a href="#" class="border-2 border-primary-500 text-primary-500 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary-50 transition">Unduh PDF</a>
        </div>
    </div>
    @empty
    <div class="text-center py-16">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
        <p class="text-gray-400 font-medium">Belum ada tiket tersedia</p>
        <p class="text-gray-400 text-sm mt-1">Tiket terbit otomatis setelah pembayaran diverifikasi admin</p>
    </div>
    @endforelse
</div>
@endsection

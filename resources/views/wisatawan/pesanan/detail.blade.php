@extends('layouts.wisatawan')
@section('title', 'Detail Pesanan — Jelajah Nusa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div><h1 class="text-3xl font-bold text-dark">Detail Pesanan #PSN-{{ str_pad($pesanan->id ?? 1042, 4, '0', STR_PAD_LEFT) }}</h1><p class="text-gray-500 mt-1">Dipesan {{ \Carbon\Carbon::parse($pesanan->created_at ?? now())->format('d M Y') }} · {{ Auth::user()->name ?? 'Wisatawan' }}</p></div>
        <a href="/tiket" class="mt-4 sm:mt-0 bg-primary-500 hover:bg-primary-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">Lihat Tiket Digital</a>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="flex-1 space-y-6">
            {{-- Perjalanan --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-dark mb-4">Perjalanan Anda</h2>
                <div class="flex gap-5 mb-5">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=300" class="w-36 h-28 rounded-xl object-cover hidden sm:block">
                    <div><h3 class="font-bold text-dark text-lg mb-1">Solo – Bali 4H3M</h3><span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full mb-2">Keberangkatan dikonfirmasi</span><p class="text-sm text-gray-500">Bali · Open Trip · 4 hari 3 malam</p></div>
                </div>
                <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Berangkat</span><span class="font-medium">12 Des 2026 · 05.00 WIB</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Kembali</span><span class="font-medium">15 Des 2026</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Meeting point</span><span class="font-medium">Terminal Tirtonadi, Solo</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Kendaraan</span><span class="font-medium">Hiace Premio</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Jumlah peserta</span><span class="font-medium">2 orang</span></div>
                </div>
            </div>
            {{-- Peserta --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-dark mb-4">Daftar Peserta</h2>
                <table class="w-full text-sm">
                    <thead><tr class="text-gray-400 border-b border-gray-100"><th class="text-left py-2 font-medium">Nama peserta</th><th class="text-left py-2 font-medium">Kontak</th><th class="text-left py-2 font-medium">Dokumen</th></tr></thead>
                    <tbody>
                        <tr class="border-b border-gray-50"><td class="py-3 font-medium text-dark">Rina Wulandari</td><td class="py-3 text-gray-500">rina.w@email.com</td><td class="py-3"><span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Dokumen lengkap</span></td></tr>
                        <tr><td class="py-3 font-medium text-dark">Andi Pratama</td><td class="py-3 text-gray-500">andi.p@email.com</td><td class="py-3"><span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Dokumen lengkap</span></td></tr>
                    </tbody>
                </table>
                <p class="text-xs text-gray-400 mt-3">Identitas peserta tersimpan privat. Bawa dokumen asli saat keberangkatan.</p>
            </div>
            {{-- Rincian Pembayaran --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-dark mb-3">Rincian Pembayaran</h2>
                <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full mb-4">Pembayaran terverifikasi</span>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Rp 3.500.000 × 2 peserta</span><span class="font-medium">Rp 7.000.000</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Biaya layanan</span><span class="font-medium">Rp 0</span></div>
                </div>
                <div class="border-t border-gray-100 mt-3 pt-3 flex justify-between"><span class="text-gray-500">Total dibayar</span><span class="text-xl font-bold text-primary-500">Rp 7.000.000</span></div>
                <p class="text-xs text-gray-400 mt-2">Transfer Bank BCA · Diverifikasi pada 25 Okt 2026, 11.05 WIB</p>
            </div>
        </div>
        {{-- Timeline Sidebar --}}
        <div class="w-full lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                <h3 class="text-lg font-bold text-dark mb-6">Timeline Status</h3>
                @php $timeline = [
                    ['Pesanan dibuat','24 Okt 2026 · 19.42 WIB','Pesanan dan data 2 peserta tersimpan.',true],
                    ['Pembayaran diunggah','25 Okt 2026 · 10.20 WIB','Bukti transfer Rp 7.000.000 diterima.',true],
                    ['Verifikasi admin','25 Okt 2026 · 11.05 WIB','Pembayaran telah diverifikasi.',true],
                    ['Keberangkatan dikonfirmasi','25 Okt 2026 · 11.10 WIB','Minimal peserta terpenuhi. Perjalanan siap berangkat.',true],
                    ['Tiket terbit','25 Okt 2026 · 11.12 WIB','Tiket digital tersedia untuk seluruh peserta.',true],
                ]; @endphp
                <div class="space-y-6">
                    @foreach($timeline as $t)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 {{ $t[3] ? 'bg-green-500' : 'bg-gray-200' }}">
                                @if($t[3])<svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>@endif
                            </div>
                            @if(!$loop->last)<div class="w-0.5 flex-1 bg-{{ $t[3] ? 'green-300' : 'gray-200' }} mt-1"></div>@endif
                        </div>
                        <div class="pb-2"><p class="font-semibold text-dark text-sm">{{ $t[0] }}</p><p class="text-xs text-primary-500 mb-0.5">{{ $t[1] }}</p><p class="text-xs text-gray-400">{{ $t[2] }}</p></div>
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-400 mt-6 border-t border-gray-100 pt-4">Hadir 30 menit sebelum jam kumpul. Informasi perjalanan terbaru akan disampaikan oleh tim Jelajah Nusa.</p>
            </div>
        </div>
    </div>
</div>
@endsection

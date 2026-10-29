@extends('layouts.wisatawan')
@section('title', 'Pemesanan — Ringkasan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-dark mb-1">Periksa kembali pesanan Anda</h1>
    <p class="text-gray-500 mb-6">Pastikan jadwal, data peserta, dan rincian biaya sudah benar.</p>
    {{-- Step Bar --}}
    <div class="flex items-center gap-2 mb-10">
        @php $steps=['Jadwal & Jumlah','Data Peserta','Ringkasan','Konfirmasi']; @endphp
        @foreach($steps as $i=>$s)
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $i<2?'bg-green-500 text-white':($i===2?'bg-primary-500 text-white':'bg-gray-200 text-gray-400') }}">
                @if($i<2)<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>@else{{ $i+1 }}@endif
            </div>
            <span class="text-sm {{ $i<=2?'font-semibold text-dark':'text-gray-400' }} hidden sm:inline">{{ $s }}</span>
        </div>
        @if($i<3)<div class="flex-1 h-px bg-gray-200 mx-1"></div>@endif
        @endforeach
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="flex-1 space-y-6">
            {{-- Detail Perjalanan --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4"><h2 class="text-lg font-bold text-dark">Detail perjalanan</h2><span class="border border-primary-500 text-primary-500 text-xs font-semibold px-2 py-0.5 rounded-full">Open Trip</span></div>
                <h3 class="font-bold text-dark mb-3">Solo – Bali 4H3M</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Keberangkatan</span><span class="font-medium">12 Des 2026</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Kepulangan</span><span class="font-medium">15 Des 2026</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Jam kumpul</span><span class="font-medium">05.00 WIB</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Meeting point</span><span class="font-medium">Terminal Tirtonadi, Solo</span></div>
                </div>
                <p class="text-xs text-gray-400 mt-4 border-t border-gray-100 pt-3">Transportasi AC, hotel 3 malam, sarapan, tiket wisata, dan pemandu sudah termasuk dalam paket.</p>
            </div>
            {{-- Data Peserta --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-dark mb-4">Data peserta</h2>
                @php $peserta=[['Rina Wulandari','3372 •••• •••• 1201','0812 3456 7890','rina.w@email.com'],['Andi Pratama','3372 •••• •••• 1202','0813 9876 5432','andi.p@email.com']]; @endphp
                @foreach($peserta as $ps)
                <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <div><p class="font-bold text-dark">{{ $ps[0] }}</p><p class="text-sm text-gray-500">{{ $ps[1] }} · {{ $ps[2] }}</p><p class="text-sm text-gray-500">{{ $ps[3] }} · KTP sudah diunggah</p></div>
                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Dokumen lengkap</span>
                </div>
                @endforeach
                <a href="#" class="text-primary-500 text-sm font-semibold mt-3 inline-block hover:underline">Ubah Data Peserta</a>
            </div>
            {{-- Syarat --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-dark mb-3">Syarat & ketentuan</h2>
                <label class="flex items-start gap-3 cursor-pointer"><input type="checkbox" checked class="accent-primary-500 mt-1 w-5 h-5"><span class="text-sm text-gray-600">Saya menyetujui syarat & ketentuan perjalanan, kebijakan pembatalan, dan memastikan data peserta telah sesuai dokumen identitas.</span></label>
                <p class="text-xs text-gray-400 mt-3">Setelah dikonfirmasi, selesaikan pembayaran sesuai batas waktu yang tercantum.</p>
            </div>
        </div>
        {{-- Sidebar --}}
        <div class="w-full lg:w-96 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                <h3 class="text-lg font-bold text-dark mb-4">Ringkasan Pesanan</h3>
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400" class="w-full h-36 object-cover rounded-xl mb-4">
                <h4 class="font-bold text-dark mb-1">Solo – Bali 4H3M</h4>
                <p class="text-sm text-gray-500 mb-2">Berangkat 12 Des 2026 · 05.00 WIB</p>
                <span class="inline-block border border-primary-500 text-primary-500 text-xs font-semibold px-2 py-0.5 rounded-full mb-4">Open Trip</span>
                <div class="border-t border-gray-100 pt-3 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Harga per peserta</span><span class="font-medium">Rp 3.500.000</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Jumlah peserta</span><span class="font-medium">2 orang</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Harga × 2 peserta</span><span class="font-medium">Rp 7.000.000</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Biaya layanan</span><span class="font-medium">Rp 0</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Diskon</span><span class="font-medium">Rp 0</span></div>
                </div>
                <div class="border-t border-gray-100 mt-3 pt-3 flex justify-between items-center mb-5">
                    <span class="text-gray-500">Total pembayaran</span><span class="text-xl font-bold text-accent-500">Rp 7.000.000</span>
                </div>
                <form action="/pesan-paket" method="POST">
                    @csrf
                    <input type="hidden" name="id_paket" value="{{ $paket->id ?? 1 }}">
                    <input type="hidden" name="jumlah" value="2">
                    <button type="submit" class="w-full bg-accent-500 hover:bg-accent-600 text-white font-semibold py-3 rounded-xl transition">Konfirmasi Pesanan</button>
                </form>
                <p class="text-xs text-gray-400 text-center mt-3">Pastikan seluruh data sudah sesuai sebelum mengonfirmasi pesanan.</p>
            </div>
        </div>
    </div>
</div>
@endsection

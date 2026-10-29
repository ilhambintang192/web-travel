@extends('layouts.wisatawan')
@section('title', 'Pembayaran — Jelajah Nusa')

@section('content')
@php
    $pesanan = $pesanan ?? null;
    $nominal = $pesanan ? (float) ($pesanan->total_biaya ?? $pesanan->harga ?? 0) : 0;
@endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if($errors->any())<div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">{{ $errors->first() }}</div>@endif
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Left --}}
        <div class="flex-1 space-y-6">
            {{-- Instruksi Transfer --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-dark">Instruksi Transfer</h2>
                    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">Menunggu verifikasi</span>
                </div>
                <div class="bg-cream-100 rounded-xl p-5 mb-4">
                    <p class="text-sm text-gray-500 mb-1">Bank BCA · a.n. PT Jelajah Nusa Wisata</p>
                    <p class="text-3xl font-bold text-primary-500 tracking-wider mb-1">8830 1234 5678</p>
                    <p class="text-sm font-semibold text-dark">Nominal: Rp {{ number_format($nominal, 0, ',', '.') }}</p>
                </div>
                <p class="text-sm text-red-500 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    Selesaikan dalam 23:41:08 (batas {{ now()->addDays(1)->format('d M Y') }}, 23.59)
                </p>
            </div>

            {{-- Upload Bukti --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-dark mb-4">Unggah Bukti Pembayaran</h2>
                <form action="/proses-bayar" method="POST">
                    @csrf
                    @if($pesanan)
                    <input type="hidden" name="id_pemesanan" value="{{ $pesanan->id }}">
                    <input type="hidden" name="jumlah_bayar" value="{{ (int) $nominal }}">
                    @else
                    <div class="grid sm:grid-cols-2 gap-3 mb-4">
                        <input type="number" name="id_pemesanan" class="px-4 py-2 rounded-xl border border-gray-200 text-sm" placeholder="ID Pemesanan" required>
                        <input type="number" name="jumlah_bayar" class="px-4 py-2 rounded-xl border border-gray-200 text-sm" placeholder="Nominal pembayaran (Rp)" required>
                    </div>
                    @endif
                    <div class="border-2 border-dashed border-primary-300 bg-primary-50/30 rounded-2xl p-8 text-center mb-4">
                        <svg class="w-8 h-8 text-primary-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <p class="text-primary-500 font-semibold text-sm">Unggah bukti transfer</p>
                        <p class="text-gray-400 text-xs mt-1">JPG/PNG/PDF · maks. 5 MB · disimpan privat & terenkripsi</p>
                        <input type="text" name="bukti_bayar" class="mt-3 w-full max-w-xs mx-auto px-4 py-2 rounded-xl border border-gray-200 text-sm text-center focus:border-primary-500 outline-none" placeholder="Nama file bukti transfer" required>
                    </div>
                    <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">Kirim Bukti Pembayaran</button>
                </form>
            </div>

            {{-- Riwayat --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-dark mb-4">Riwayat Pembayaran</h2>
                <div class="space-y-3">
                    @foreach($data as $row)
                    <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                        <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($row->created_at ?? now())->format('d M Y') }}</span>
                        <span class="text-sm font-semibold">Rp {{ number_format($row->jumlah_bayar ?? 0,0,',','.') }}</span>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ ($row->status ?? '') === 'Terverifikasi' ? 'bg-green-100 text-green-700' : (($row->status ?? '') === 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ $row->status ?? 'Menunggu verifikasi' }}</span>
                    </div>
                    @endforeach
                    @if(count($data) === 0)
                    <p class="text-gray-400 text-sm text-center py-4">Belum ada riwayat pembayaran</p>
                    @endif
                </div>
                <p class="text-xs text-gray-400 mt-3">Ditolak? Unggah ulang bukti transfer yang benar.</p>
            </div>
        </div>

        {{-- Right Sidebar --}}
        <div class="w-full lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                <h3 class="text-lg font-bold text-dark mb-4">Status Pesanan</h3>
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=100" class="w-12 h-12 rounded-xl object-cover">
                    <div><p class="font-bold text-sm text-dark">{{ $pesanan ? '#PSN-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . ' · ' . ($pesanan->nama_paket ?? 'Paket Wisata') : 'Belum ada pesanan aktif' }}</p><p class="text-xs text-gray-400">Tiket terbit otomatis setelah pembayaran diverifikasi admin.</p></div>
                </div>
                <div class="space-y-4">
                    @php $timeline = [
                        ['Pesanan dibuat', true],
                        ['Pembayaran diunggah', true],
                        ['Verifikasi admin', false],
                        ['Tiket terbit', false],
                    ]; @endphp
                    @foreach($timeline as $t)
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 rounded-full flex-shrink-0 {{ $t[1] ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                        <span class="text-sm {{ $t[1] ? 'font-semibold text-dark' : 'text-gray-400' }}">{{ $t[0] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

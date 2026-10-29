@extends('layouts.wisatawan')
@section('title', 'Pemesanan — Data Peserta')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-dark mb-6">Pemesanan Paket</h1>
    {{-- Step Bar --}}
    <div class="flex items-center gap-2 mb-10">
        @php $steps = ['Jadwal & Jumlah','Data Peserta','Ringkasan','Konfirmasi']; @endphp
        @foreach($steps as $i => $s)
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $i < 1 ? 'bg-green-500 text-white' : ($i === 1 ? 'bg-primary-500 text-white' : 'bg-gray-200 text-gray-400') }}">
                @if($i < 1)<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>@else{{ $i+1 }}@endif
            </div>
            <span class="text-sm {{ $i <= 1 ? 'font-semibold text-dark' : 'text-gray-400' }} hidden sm:inline">{{ $s }}</span>
        </div>
        @if($i < 3)<div class="flex-1 h-px bg-gray-200 mx-1"></div>@endif
        @endforeach
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="flex-1 space-y-6">
            @for($p = 1; $p <= 2; $p++)
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-dark mb-5">Peserta {{ $p }}</h2>
                <div class="grid sm:grid-cols-2 gap-4 mb-4">
                    <div><label class="block text-sm font-semibold text-dark mb-1.5">Nama lengkap</label><input type="text" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" placeholder="Sesuai KTP/Paspor"></div>
                    <div><label class="block text-sm font-semibold text-dark mb-1.5">NIK / No. Paspor</label><input type="text" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" placeholder="16 digit"></div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4 mb-5">
                    <div><label class="block text-sm font-semibold text-dark mb-1.5">No. HP</label><input type="text" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" placeholder="08xx xxxx xxxx"></div>
                    <div><label class="block text-sm font-semibold text-dark mb-1.5">Email</label><input type="email" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" placeholder="nama@email.com"></div>
                </div>
                <div class="border-2 border-dashed border-primary-300 bg-primary-50/30 rounded-2xl p-8 text-center">
                    <svg class="w-8 h-8 text-primary-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <p class="text-primary-500 font-semibold text-sm">Unggah foto KTP / Paspor — tarik & lepas atau klik</p>
                    <p class="text-gray-400 text-xs mt-1">JPG/PNG/PDF · maks. 5 MB · disimpan privat & terenkripsi</p>
                </div>
            </div>
            @endfor
        </div>
        {{-- Sidebar --}}
        <div class="w-full lg:w-96 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                <h3 class="text-lg font-bold text-dark mb-4">Ringkasan Pesanan</h3>
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400" class="w-full h-36 object-cover rounded-xl mb-4">
                <h4 class="font-bold text-dark mb-1">Solo – Bali 4H3M</h4>
                <p class="text-sm text-gray-500 mb-4">Berangkat 12 Des 2026 · 05.00 WIB</p>
                <div class="space-y-2 text-sm border-t border-gray-100 pt-3">
                    <div class="flex justify-between"><span class="text-gray-500">Harga × 2 peserta</span><span class="font-medium">Rp 7.000.000</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Biaya layanan</span><span class="font-medium">Rp 0</span></div>
                </div>
                <div class="bg-yellow-50 rounded-xl p-3 mt-4 mb-3"><p class="text-xs text-yellow-700">Sisa kuota 8 kursi. Bila peserta melebihi sisa kuota, tampil pesan "Kuota penuh".</p></div>
                <div class="border-t border-gray-100 pt-3 flex justify-between items-center mb-4">
                    <span class="text-gray-500 font-medium">Total</span><span class="text-xl font-bold text-accent-500">Rp 7.000.000</span>
                </div>
                <a href="/pemesanan/step3/1" class="block w-full bg-accent-500 hover:bg-accent-600 text-white text-center font-semibold py-3 rounded-xl transition">Lanjut ke Ringkasan</a>
            </div>
        </div>
    </div>
</div>
@endsection

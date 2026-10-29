@extends('layouts.wisatawan')
@section('title', 'Pemesanan — Jadwal & Jumlah')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-dark mb-1">Pemesanan Paket</h1>
    <p class="text-gray-500 mb-6">Tentukan jadwal dan jumlah peserta untuk perjalanan Anda.</p>

    {{-- Step Bar --}}
    <div class="flex items-center gap-2 mb-10">
        @php $steps = ['Jadwal & Jumlah','Data Peserta','Ringkasan','Konfirmasi']; @endphp
        @foreach($steps as $i => $s)
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $i === 0 ? 'bg-primary-500 text-white' : 'bg-gray-200 text-gray-400' }}">{{ $i + 1 }}</div>
            <span class="text-sm {{ $i === 0 ? 'font-semibold text-dark' : 'text-gray-400' }} hidden sm:inline">{{ $s }}</span>
        </div>
        @if($i < 3)<div class="flex-1 h-px bg-gray-200 mx-1"></div>@endif
        @endforeach
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="flex-1 space-y-6">
            {{-- Jadwal --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-dark mb-1">Pilih jadwal keberangkatan</h2>
                <p class="text-gray-500 text-sm mb-4">Solo – Bali 4H3M · Pilih tanggal yang paling sesuai untuk Anda.</p>
                <div class="space-y-3">
                    @php $jadwals = [['12 Des 2026','05.00 WIB · Terminal Tirtonadi, Solo',8],['26 Des 2026','05.00 WIB · Terminal Tirtonadi, Solo',15],['09 Jan 2027','05.00 WIB · Terminal Tirtonadi, Solo',20]]; @endphp
                    @foreach($jadwals as $j)
                    <label class="flex items-center justify-between bg-cream-100 rounded-xl px-5 py-4 cursor-pointer border-2 border-transparent has-[:checked]:border-primary-500 hover:bg-cream-200 transition">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="jadwal" value="{{ $j[0] }}" class="accent-primary-500 w-5 h-5" {{ $loop->first ? 'checked' : '' }}>
                            <div><p class="font-bold text-dark">{{ $j[0] }}</p><p class="text-sm text-gray-500">{{ $j[1] }}</p></div>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">Sisa {{ $j[2] }} kursi</span>
                    </label>
                    @endforeach
                </div>
            </div>
            {{-- Jumlah Peserta --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-dark mb-1">Jumlah peserta</h2>
                <p class="text-gray-500 text-sm mb-4">Harga per orang Rp 3.500.000</p>
                <p class="text-xs text-gray-400 mb-3">Termasuk peserta dewasa dan anak yang menggunakan kursi.</p>
                <div class="flex items-center gap-4">
                    <button onclick="updateQty(-1)" class="w-10 h-10 bg-cream-100 rounded-xl flex items-center justify-center text-lg font-bold hover:bg-cream-200 transition">−</button>
                    <span id="qty" class="text-2xl font-bold text-dark w-8 text-center">2</span>
                    <button onclick="updateQty(1)" class="w-10 h-10 bg-cream-100 rounded-xl flex items-center justify-center text-lg font-bold hover:bg-cream-200 transition">+</button>
                </div>
            </div>
            {{-- Status Open Trip --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-dark mb-2">Status Open Trip</h2>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-500">12/20 peserta · minimal 10</span>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Layak dijalankan</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5"><div class="bg-primary-500 h-2.5 rounded-full" style="width:60%"></div></div>
                <p class="text-xs text-gray-400 mt-2">Minimal peserta sudah terpenuhi. Masih tersedia 8 kursi untuk keberangkatan ini.</p>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="w-full lg:w-96 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                <h3 class="text-lg font-bold text-dark mb-4">Ringkasan Pesanan</h3>
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400" class="w-full h-40 object-cover rounded-xl mb-4">
                <h4 class="font-bold text-dark mb-1">Solo – Bali 4H3M</h4>
                <p class="text-sm text-gray-500 mb-2">Berangkat 12 Des 2026 · 05.00 WIB</p>
                <span class="inline-block border border-primary-500 text-primary-500 text-xs font-semibold px-2 py-0.5 rounded-full mb-4">Open Trip</span>
                <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Harga per peserta</span><span class="font-medium">Rp 3.500.000</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Jumlah peserta</span><span id="sidebar-qty" class="font-medium">2 orang</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Harga × <span id="sidebar-mul">2</span> peserta</span><span id="sidebar-subtotal" class="font-medium">Rp 7.000.000</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Biaya layanan</span><span class="font-medium">Rp 0</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Diskon</span><span class="font-medium">Rp 0</span></div>
                </div>
                <div class="border-t border-gray-100 mt-3 pt-3 flex justify-between items-center">
                    <span class="text-gray-500">Total pembayaran</span>
                    <span id="sidebar-total" class="text-xl font-bold text-accent-500">Rp 7.000.000</span>
                </div>
                <a href="/pemesanan/step2/1" class="block w-full bg-accent-500 hover:bg-accent-600 text-white text-center font-semibold py-3 rounded-xl mt-5 transition">Lanjutkan</a>
                <p class="text-xs text-gray-400 text-center mt-3">Harga termasuk transportasi, hotel, tiket wisata, dan pemandu.</p>
            </div>
        </div>
    </div>
</div>
<script>
function updateQty(d){const e=document.getElementById('qty');let v=parseInt(e.textContent)+d;if(v<1)v=1;if(v>15)v=15;e.textContent=v;const p=3500000;document.getElementById('sidebar-qty').textContent=v+' orang';document.getElementById('sidebar-mul').textContent=v;document.getElementById('sidebar-subtotal').textContent='Rp '+new Intl.NumberFormat('id-ID').format(v*p);document.getElementById('sidebar-total').textContent='Rp '+new Intl.NumberFormat('id-ID').format(v*p);}
</script>
@endsection

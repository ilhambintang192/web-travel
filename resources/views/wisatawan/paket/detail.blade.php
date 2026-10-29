@extends('layouts.wisatawan')
@section('title', ($paket->nama_paket ?? 'Detail Paket') . ' — Jelajah Nusa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Left Content --}}
        <div class="flex-1">
            <div class="relative rounded-2xl overflow-hidden mb-6">
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=900" alt="{{ $paket->nama_paket }}" class="w-full h-72 lg:h-96 object-cover">
                <span class="absolute top-4 left-4 bg-primary-500/90 text-white text-xs font-semibold px-3 py-1 rounded-full">{{ $paket->jenis_layanan ?? 'Open Trip' }}</span>
            </div>
            <h1 class="text-3xl font-bold text-dark mb-3">{{ $paket->nama_paket }}</h1>
            <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-6">
                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg> {{ $paket->destinasi }}</span>
                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> {{ $paket->durasi_hari }} hari {{ $paket->durasi_hari - 1 }} malam</span>
                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg> Hiace Premio · 15 kursi</span>
            </div>

            {{-- Tabs --}}
            <div class="flex gap-6 border-b border-gray-200 mb-6">
                <button class="pb-3 text-sm font-semibold text-primary-500 border-b-2 border-primary-500">Itinerary</button>
                <button class="pb-3 text-sm font-medium text-gray-400 hover:text-gray-600">Fasilitas</button>
                <button class="pb-3 text-sm font-medium text-gray-400 hover:text-gray-600">Kendaraan</button>
                <button class="pb-3 text-sm font-medium text-gray-400 hover:text-gray-600">Meeting Point</button>
            </div>

            {{-- Itinerary --}}
            <div class="space-y-4">
                @php $itinerary = [
                    ['Hari 1','Solo → Surabaya → Banyuwangi','Berkumpul 05.00 di meeting point, perjalanan darat, makan malam di Banyuwangi.'],
                    ['Hari 2','Penyeberangan → Ubud & Tegallalang','Check-in hotel, kunjungan Ubud, sunset di Tanah Lot.'],
                    ['Hari 3','Nusa Penida & Pantai Kuta','Island hopping, snorkeling, free time malam hari.'],
                    ['Hari 4','Kembali ke Solo','Belanja oleh-oleh, perjalanan pulang, tiba esok hari.'],
                ]; @endphp
                @foreach($itinerary as $day)
                <div class="bg-white rounded-xl p-5 shadow-sm flex gap-4">
                    <div class="w-14 h-14 bg-cream-100 rounded-xl flex items-center justify-center text-xs font-bold text-primary-500 flex-shrink-0">{{ $day[0] }}</div>
                    <div>
                        <h4 class="font-bold text-dark mb-1">{{ $day[1] }}</h4>
                        <p class="text-gray-500 text-sm">{{ $day[2] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right Sidebar - Booking --}}
        <div class="w-full lg:w-96 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-400">Mulai dari</span>
                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Layak dijalankan</span>
                </div>
                <p class="text-3xl font-bold text-primary-500 mb-1">Rp {{ number_format($paket->harga,0,',','.') }}</p>
                <p class="text-sm text-gray-400 mb-5">per peserta</p>

                <p class="font-semibold text-dark mb-3">Pilih jadwal keberangkatan</p>
                @php $jadwals = [
                    ['12 Des 2026', 8], ['26 Des 2026', 15], ['09 Jan 2027', 15],
                ]; @endphp
                <div class="space-y-2 mb-5">
                    @foreach($jadwals as $j)
                    <label class="flex items-center justify-between bg-cream-100 rounded-xl px-4 py-3 cursor-pointer hover:bg-cream-200 transition border-2 border-transparent has-[:checked]:border-primary-500">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="jadwal" value="{{ $j[0] }}" class="accent-primary-500" {{ $loop->first ? 'checked' : '' }}>
                            <span class="font-semibold text-sm">{{ $j[0] }}</span>
                        </div>
                        <span class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-0.5 rounded-full">Sisa {{ $j[1] }} kursi</span>
                    </label>
                    @endforeach
                </div>

                <div class="bg-cream-100 rounded-xl p-4 mb-5">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Layak dijalankan</span>
                        <span class="text-xs text-gray-500">12/20 peserta terdaftar · minimal 10</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-primary-500 h-2 rounded-full" style="width:60%"></div></div>
                </div>

                <form action="/pesan-paket" method="POST">
                    @csrf
                    <input type="hidden" name="id_paket" value="{{ $paket->id }}">
                    <input type="hidden" name="jumlah" value="1">
                    <button type="submit" class="w-full bg-accent-500 hover:bg-accent-600 text-white font-semibold py-3 rounded-xl transition text-lg">Pesan Sekarang</button>
                </form>
                <p class="text-xs text-gray-400 text-center mt-3">Ringkasan & total biaya ditampilkan sebelum konfirmasi</p>
            </div>
        </div>
    </div>
</div>
@endsection

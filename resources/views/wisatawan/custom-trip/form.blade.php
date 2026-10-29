@extends('layouts.wisatawan')
@section('title', 'Custom Trip — Jelajah Nusa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Left - Form --}}
        <div class="flex-1">
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <span class="inline-block bg-primary-100 text-primary-600 text-xs font-semibold px-3 py-1 rounded-full mb-4">Rancang perjalanan impianmu</span>
                <h1 class="text-2xl font-bold text-dark mb-2">Ajukan Custom Trip</h1>
                <p class="text-gray-500 mb-6">Ceritakan perjalanan impian Anda — admin akan mengirim penawaran.</p>
                @if($errors->any())<div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">{{ $errors->first() }}</div>@endif
                <form action="/custom-trip/kirim" method="POST">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4 mb-4">
                        <div><label class="block text-sm font-semibold text-dark mb-1.5">Tujuan</label><input type="text" name="tujuan" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" placeholder="Contoh: Raja Ampat" required></div>
                        <div><label class="block text-sm font-semibold text-dark mb-1.5">Jumlah peserta</label><input type="number" name="jumlah_peserta" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" placeholder="6 orang" required></div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4 mb-4">
                        <div><label class="block text-sm font-semibold text-dark mb-1.5">Tanggal mulai</label><input type="date" name="tanggal_mulai" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" required></div>
                        <div><label class="block text-sm font-semibold text-dark mb-1.5">Tanggal selesai</label><input type="date" name="tanggal_selesai" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm" required></div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-dark mb-1.5">Kebutuhan perjalanan</label>
                        <textarea name="kebutuhan" rows="4" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 focus:border-primary-500 outline-none text-sm resize-none" placeholder="Kendaraan, fasilitas, anggaran, permintaan khusus..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3 rounded-xl transition">Kirim Pengajuan</button>
                </form>
                <p class="text-xs text-gray-400 mt-4">Admin akan menghubungi Anda maksimal 1×24 jam setelah pengajuan dikirim.</p>
            </div>
        </div>

        {{-- Right --}}
        <div class="w-full lg:w-96 flex-shrink-0 space-y-6">
            {{-- Hero Image --}}
            <div class="relative rounded-2xl overflow-hidden h-64">
                <img src="https://images.unsplash.com/photo-1570789210967-2cac24ee7399?w=600" alt="Custom Trip" class="w-full h-full object-cover">
                <span class="absolute top-4 left-4 bg-primary-500/80 text-white text-xs px-3 py-1 rounded-full">Destinasi populer</span>
                <span class="absolute top-4 right-4 bg-accent-500/80 text-white text-xs px-3 py-1 rounded-full">3.500+ wisatawan aktif</span>
                <div class="absolute inset-0 bg-gradient-to-t from-dark/70 to-transparent flex flex-col justify-end p-6">
                    <p class="text-white font-bold text-lg leading-tight mb-3">Rancang perjalanan impianmu dengan foto-foto destinasi nyata.</p>
                    <div class="flex gap-3">
                        <a href="/paket-wisata" class="bg-white text-primary-500 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-100 transition">Lihat Contoh Trip</a>
                        <a href="/paket-wisata" class="text-accent-500 text-sm font-semibold hover:underline flex items-center">Cek Jadwal →</a>
                    </div>
                </div>
            </div>
            {{-- Alur Pengajuan --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-bold text-dark mb-4">Alur Pengajuan</h3>
                <div class="space-y-4">
                    <div class="bg-yellow-50 rounded-xl p-4"><span class="inline-block bg-yellow-200 text-yellow-800 text-xs font-semibold px-2 py-0.5 rounded-full mb-2">Diajukan</span><p class="text-sm text-gray-600">Pengajuan Anda diterima admin</p></div>
                    <div class="bg-green-50 rounded-xl p-4"><span class="inline-block bg-green-200 text-green-800 text-xs font-semibold px-2 py-0.5 rounded-full mb-2">Ditawarkan</span><p class="text-sm text-gray-600">Admin menetapkan kendaraan, fasilitas, jadwal & biaya</p></div>
                    <div class="bg-primary-50 rounded-xl p-4"><span class="inline-block bg-primary-200 text-primary-800 text-xs font-semibold px-2 py-0.5 rounded-full mb-2">Disetujui</span><p class="text-sm text-gray-600">Anda menyetujui penawaran lalu lanjut membayar</p></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

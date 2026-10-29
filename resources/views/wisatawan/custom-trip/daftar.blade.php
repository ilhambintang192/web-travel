@extends('layouts.wisatawan')
@section('title', 'Pengajuan Custom Trip — Jelajah Nusa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div><h1 class="text-3xl font-bold text-dark">Pengajuan Custom Trip</h1><p class="text-gray-500 mt-1">Kelola perjalanan impian Anda dan tinjau penawaran dari admin.</p></div>
        <a href="/custom-trip" class="mt-4 sm:mt-0 bg-primary-500 hover:bg-primary-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">+ Ajukan Custom Trip</a>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Left --}}
        <div class="flex-1 space-y-6">
            {{-- Riwayat --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-dark mb-4">Riwayat Pengajuan ({{ count($data) }})</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead><tr class="text-gray-400 border-b border-gray-100"><th class="text-left py-2 font-medium">Tujuan / kode</th><th class="text-left py-2 font-medium">Jadwal</th><th class="text-left py-2 font-medium">Peserta</th><th class="text-left py-2 font-medium">Status</th></tr></thead>
                        <tbody>
                            @php $demos=[['Raja Ampat','#CT-024','03–07 Jan 2027','6 orang','Ditawarkan','yellow'],['Lombok','#CT-025','14–17 Feb 2027','8 orang','Diajukan','blue'],['Yogyakarta','#CT-019','12–13 Sep 2026','12 orang','Disetujui','green'],['Labuan Bajo','#CT-017','05–08 Agu 2026','6 orang','Ditolak','red']]; @endphp
                            @foreach($demos as $d)
                            <tr class="border-b border-gray-50">
                                <td class="py-3"><p class="font-bold text-dark">{{ $d[0] }}</p><p class="text-gray-400 text-xs">{{ $d[1] }} · Dipilih</p></td>
                                <td class="py-3 text-gray-600">{{ $d[2] }}</td>
                                <td class="py-3 text-gray-600">{{ $d[3] }}</td>
                                <td class="py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $d[5]==='yellow'?'bg-yellow-100 text-yellow-700':($d[5]==='blue'?'bg-blue-100 text-blue-700':($d[5]==='green'?'bg-green-100 text-green-700':'bg-red-100 text-red-700')) }}">{{ $d[4] }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-xs text-gray-400 mt-3">Menampilkan 4 pengajuan · Diperbarui {{ now()->format('d M Y') }}</p>
            </div>

            {{-- Info Banner --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                <div><p class="text-sm font-semibold text-blue-700">Penawaran siap ditinjau</p><p class="text-xs text-blue-600">Pengajuan Raja Ampat Anda telah mendapatkan penawaran. Periksa fasilitas dan jadwal sebelum menyetujui.</p></div>
            </div>

            {{-- Detail Kebutuhan --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-dark mb-4">Detail kebutuhan Anda</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Tujuan</span><span class="font-medium">Raja Ampat, Papua Barat Daya</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Peserta</span><span class="font-medium">6 orang</span></div>
                </div>
                <p class="text-sm text-gray-500 mt-3">Perjalanan privat 5 hari 4 malam, aktivitas snorkeling, penginapan tepi laut, dan kendaraan untuk seluruh rombongan.</p>
            </div>
        </div>

        {{-- Right - Penawaran Admin --}}
        <div class="w-full lg:w-96 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                <h3 class="text-lg font-bold text-dark mb-4">Penawaran dari Admin</h3>
                <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full mb-3">Ditawarkan</span>
                <h4 class="text-lg font-bold text-dark mb-1">Raja Ampat · 5H4M</h4>
                <p class="text-sm text-gray-500 mb-4">#CT-024 · Dikirim 25 Okt 2026</p>

                <div class="border-t border-gray-100 pt-4 space-y-2 text-sm mb-4">
                    <div class="flex justify-between"><span class="text-gray-500">Jadwal</span><span class="font-medium">03–07 Jan 2027</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Peserta</span><span class="font-medium">6 orang</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Kendaraan</span><span class="font-medium text-right">Hiace Premio + speedboat privat</span></div>
                </div>

                <h4 class="font-bold text-dark mb-2">Fasilitas termasuk</h4>
                <ul class="space-y-1 text-sm text-gray-600 mb-5">
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Penginapan tepi laut 4 malam</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Makan 3× sehari & air mineral</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Pemandu lokal & alat snorkeling</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Tiket destinasi & transfer bandara</li>
                </ul>
                <p class="text-xs text-gray-400 mb-4">Belum termasuk tiket pesawat dan pengeluaran pribadi.</p>

                <p class="text-3xl font-bold text-primary-500 mb-1">Rp 42.000.000</p>
                <p class="text-sm text-gray-500 mb-5">Total untuk 6 peserta · Rp 7.000.000/orang</p>

                <div class="flex gap-3 mb-4">
                    <button class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-xl font-semibold transition">Setujui</button>
                    <button class="flex-1 bg-accent-500 hover:bg-accent-600 text-white py-3 rounded-xl font-semibold transition">Tolak</button>
                </div>
                <p class="text-xs text-gray-400 text-center">Penawaran berlaku sampai 28 Okt 2026. Pembayaran dilakukan setelah penawaran disetujui.</p>
            </div>
        </div>
    </div>
</div>
@endsection

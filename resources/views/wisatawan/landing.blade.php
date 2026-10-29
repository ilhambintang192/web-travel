@extends('layouts.wisatawan')
@section('title', 'Jelajah Nusa — Wisata Travel & Tour')

@section('content')
{{-- HERO --}}
<section class="bg-cream-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            <div>
                <span class="inline-block bg-primary-500/10 text-primary-500 text-xs font-semibold px-3 py-1 rounded-full mb-4">Open Trip & Custom Trip ke seluruh Indonesia</span>
                <h1 class="text-4xl lg:text-5xl font-extrabold text-dark leading-tight mb-5">Jelajahi Indonesia, dari Solo ke Bali dan lebih jauh</h1>
                <p class="text-gray-500 mb-8 max-w-lg">Pesan open trip, paket reguler, atau rancang perjalananmu sendiri. Kuota real-time, pembayaran terverifikasi, tiket QR digital.</p>
                <div class="bg-white rounded-2xl shadow-sm p-4 flex flex-wrap gap-3 items-end mb-6">
                    <div class="flex-1 min-w-[140px]">
                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Destinasi</label>
                        <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 outline-none"><option>Bali, Bromo, Raja Ampat...</option></select>
                    </div>
                    <div class="flex-1 min-w-[130px]">
                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Tanggal Berangkat</label>
                        <input type="date" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 outline-none">
                    </div>
                    <div class="flex-1 min-w-[130px]">
                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Jenis Layanan</label>
                        <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 outline-none"><option>Semua layanan</option></select>
                    </div>
                    <a href="/paket-wisata" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition whitespace-nowrap">Cari Paket</a>
                </div>
                <div class="flex gap-4">
                    <a href="/paket-wisata" class="border-2 border-primary-500 text-primary-500 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-primary-50 transition">Lihat Semua Paket</a>
                    <a href="#jadwal" class="text-primary-500 px-4 py-2.5 text-sm font-semibold hover:underline">Cari Jadwal →</a>
                </div>
            </div>
            <div class="relative hidden lg:block">
                <span class="absolute top-4 left-4 bg-primary-500/80 text-white text-xs px-3 py-1 rounded-full z-10">Destinasi populer</span>
                <span class="absolute top-4 right-4 bg-accent-500/80 text-white text-xs px-3 py-1 rounded-full z-10">3.500+ wisatawan aktif</span>
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=700" alt="Bali" class="rounded-2xl shadow-lg w-full h-80 object-cover">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-dark/70 to-transparent p-6 rounded-b-2xl">
                    <p class="text-white font-bold text-lg">Temukan paket wisata yang sesuai dengan rencana liburanmu.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PAKET POPULER --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-dark mb-1">Paket Populer</h2>
        <p class="text-gray-500 mb-8">Destinasi favorit wisatawan — harga transparan, kuota diperbarui otomatis</p>
        <div class="grid md:grid-cols-3 gap-6">
            @php $demos = [
                ['nama'=>'Solo – Bali 4H3M','dest'=>'Bali','dur'=>'4 hari 3 malam','tgl'=>'12 Des 2026','harga'=>3500000,'jenis'=>'Open Trip','sisa'=>8,'img'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500'],
                ['nama'=>'Bromo Sunrise 2H1M','dest'=>'Jawa Timur','dur'=>'2 hari 1 malam','tgl'=>'20 Nov 2026','harga'=>850000,'jenis'=>'Open Trip','sisa'=>11,'img'=>'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=500'],
                ['nama'=>'Raja Ampat Explorer 5H4M','dest'=>'Papua Barat Daya','dur'=>'5 hari 4 malam','tgl'=>'03 Jan 2027','harga'=>7250000,'jenis'=>'Paket Reguler','sisa'=>6,'img'=>'https://images.unsplash.com/photo-1570789210967-2cac24ee7399?w=500'],
            ]; @endphp
            @foreach($demos as $p)
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition">
                <img src="{{ $p['img'] }}" alt="{{ $p['nama'] }}" class="w-full h-48 object-cover">
                <div class="p-5">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold text-primary-500 border border-primary-500 px-2 py-0.5 rounded-full">{{ $p['jenis'] }}</span>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Sisa {{ $p['sisa'] }} kursi</span>
                    </div>
                    <h3 class="font-bold text-dark text-lg mb-2">{{ $p['nama'] }}</h3>
                    <p class="text-gray-500 text-sm flex items-center gap-1 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> {{ $p['dest'] }}</p>
                    <p class="text-gray-500 text-sm flex items-center gap-1 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> {{ $p['dur'] }}</p>
                    <p class="text-gray-500 text-sm flex items-center gap-1 mb-4"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> Berangkat {{ $p['tgl'] }}</p>
                    <div class="flex items-center justify-between">
                        <div><span class="text-xs text-gray-400">Mulai dari</span><p class="text-xl font-bold text-primary-500">Rp {{ number_format($p['harga'],0,',','.') }}</p></div>
                        <a href="/paket-wisata" class="border border-dark text-dark px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- OPEN TRIP SEGERA BERANGKAT --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-dark mb-1">Open Trip Segera Berangkat</h2>
        <p class="text-gray-500 mb-8">Pantau jumlah peserta — keberangkatan dikonfirmasi saat batas minimal terpenuhi</p>
        <div class="grid md:grid-cols-2 gap-6">
            @php $trips = [
                ['nama'=>'Labuan Bajo Sailing 4H3M','tgl'=>'15 Des 2026','peserta'=>12,'min'=>10,'max'=>20,'layak'=>true,'img'=>'https://images.unsplash.com/photo-1570789210967-2cac24ee7399?w=500'],
                ['nama'=>'Ijen Blue Fire 3H2M','tgl'=>'28 Nov 2026','peserta'=>6,'min'=>10,'max'=>15,'layak'=>false,'img'=>'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=500'],
            ]; @endphp
            @foreach($trips as $t)
            <div class="flex bg-cream-100 rounded-2xl overflow-hidden">
                <img src="{{ $t['img'] }}" alt="{{ $t['nama'] }}" class="w-40 h-full object-cover hidden sm:block">
                <div class="p-5 flex-1">
                    <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded-full mb-2 {{ $t['layak'] ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">{{ $t['layak'] ? 'Layak dijalankan' : 'Belum memenuhi minimal' }}</span>
                    <h3 class="font-bold text-dark text-lg mb-1">{{ $t['nama'] }}</h3>
                    <p class="text-gray-500 text-sm mb-3 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> Berangkat {{ $t['tgl'] }}</p>
                    <p class="text-xs text-gray-500 mb-2">{{ $t['peserta'] }}/{{ $t['max'] }} peserta terdaftar · minimal {{ $t['min'] }}</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3"><div class="h-2 rounded-full {{ $t['layak'] ? 'bg-primary-500' : 'bg-orange-400' }}" style="width:{{ ($t['peserta']/$t['max'])*100 }}%"></div></div>
                    <a href="/paket-wisata" class="inline-block border border-dark text-dark px-4 py-1.5 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Lihat Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CARA PESAN 4 LANGKAH --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-dark mb-1">Cara Pesan dalam 4 Langkah</h2>
        <p class="text-gray-500 mb-8">Dari memilih paket sampai tiket QR di tangan Anda</p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $steps = [['1','Pilih Paket','Cari & filter destinasi, jadwal, harga'],['2','Isi Data Peserta','Unggah KTP/Paspor dengan aman'],['3','Bayar & Verifikasi','Unggah bukti transfer, admin memverifikasi'],['4','Terima Tiket QR','Tiket digital terbit otomatis']]; @endphp
            @foreach($steps as $s)
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="w-10 h-10 bg-cream-100 rounded-xl flex items-center justify-center text-lg font-bold text-primary-500 mb-4">{{ $s[0] }}</div>
                <h3 class="font-bold text-dark mb-2">{{ $s[1] }}</h3>
                <p class="text-gray-500 text-sm">{{ $s[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- KENAPA JELAJAH NUSA --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-dark mb-1">Kenapa Jelajah Nusa</h2>
        <p class="text-gray-500 mb-8">Sistem terpusat yang membuat perjalanan lebih tertib dan aman</p>
        <div class="grid md:grid-cols-3 gap-6">
            @php $feats = [
                ['📊','Kuota Real-time','Sisa kursi dan status keberangkatan selalu diperbarui otomatis.'],
                ['🛡️','Pembayaran Terverifikasi','Bukti transfer dicek admin, status bayar jelas dan tercatat.'],
                ['🎫','Tiket Digital QR','Tiket unik dengan QR code yang mudah diverifikasi keasliannya.'],
            ]; @endphp
            @foreach($feats as $f)
            <div class="bg-cream-100 rounded-2xl p-6">
                <div class="text-3xl mb-4">{{ $f[0] }}</div>
                <h3 class="font-bold text-dark mb-2">{{ $f[1] }}</h3>
                <p class="text-gray-500 text-sm">{{ $f[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA CUSTOM TRIP --}}
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-primary-500 rounded-2xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Punya rencana perjalanan sendiri?</h2>
                <p class="text-primary-100">Ajukan custom trip — tentukan tujuan, waktu, dan kebutuhan, kami siapkan penawarannya.</p>
            </div>
            <a href="/custom-trip" class="bg-accent-500 hover:bg-accent-600 text-white px-8 py-3 rounded-xl font-semibold transition whitespace-nowrap">Ajukan Custom Trip</a>
        </div>
    </div>
</section>
@endsection

@section('footer')
<footer class="bg-dark text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="font-bold text-lg mb-1">Jelajah Nusa</p>
        <p class="text-gray-400 text-sm mb-2">Sistem Informasi Travel dan Agen Wisata · Surakarta, Jawa Tengah</p>
        <p class="text-gray-500 text-xs">© 2026 Kelompok 3 — Universitas Duta Bangsa</p>
    </div>
</footer>
@endsection

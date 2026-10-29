<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WisataController extends Controller
{
    // ─────────────────────────────────────────────────────────
    //  Landing Page (public)
    // ─────────────────────────────────────────────────────────

    public function landing()
    {
        $paketPopuler = DB::table('paket_wisata')->limit(6)->get();
        return view('wisatawan.landing', compact('paketPopuler'));
    }

    // ─────────────────────────────────────────────────────────
    //  Authentication
    // ─────────────────────────────────────────────────────────

    public function halamanLogin()
    {
        return view('wisatawan.login');
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        if ($user) {
            Auth::loginUsingId($user->id);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Login gagal! Email atau password salah.');
    }

    public function halamanRegister()
    {
        return view('wisatawan.register');
    }

    public function prosesRegister(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique'       => 'Email sudah terdaftar!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ]);

        DB::table('users')->insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => $request->password,
            'role'       => 'Wisatawan',
            'created_at' => now(),
        ]);

        return redirect('/register-sukses')->with('success', 'Registrasi berhasil!');
    }

    public function registerSukses()
    {
        return view('wisatawan.register-sukses');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // ─────────────────────────────────────────────────────────
    //  Dashboard (role-aware)
    // ─────────────────────────────────────────────────────────

    public function dashboard(): View
    {
        if (Auth::user()->role === 'Admin') {
            return view('dashboard');
        }

        return $this->dashboardWisatawan();
    }

    public function dashboardWisatawan(): View
    {
        if (Auth::user()->role === 'Admin') {
            return view('dashboard');
        }

        $pemesananIds = $this->getPemesananIds();

        $statusCol = $this->col('pemesanan', ['status', 'status_pemesanan']);
        $orderCol  = $this->orderCol('pemesanan');

        $aktifQuery = DB::table('pemesanan')->whereIn('id', $pemesananIds);
        if ($statusCol) {
            $aktifQuery->whereNotIn($statusCol, ['Selesai', 'Dibatalkan']);
        }
        $pesanan_aktif = $aktifQuery->count();

        $pembayaran_pending = 0;
        $bayarPesananCol    = $this->col('pembayaran', ['id_pemesanan', 'pemesanan_id']);
        $bayarStatusCol     = $this->col('pembayaran', ['status', 'status_pembayaran']);
        if ($bayarPesananCol && $bayarStatusCol) {
            $pembayaran_pending = DB::table('pembayaran')
                ->whereIn($bayarPesananCol, $pemesananIds)
                ->where($bayarStatusCol, 'Verifikasi')
                ->count();
        }

        $tiket_tersedia = 0;
        $tiketPesananCol = $this->col('tiket', ['id_pemesanan', 'pemesanan_id']);
        if ($tiketPesananCol) {
            $tiket_tersedia = DB::table('tiket')
                ->whereIn($tiketPesananCol, $pemesananIds)
                ->count();
        }

        $keberangkatan = collect();
        $kq = $this->pemesananQuery()->whereIn('pemesanan.id', $pemesananIds);
        if ($statusCol) {
            $kq->whereNotIn("pemesanan.$statusCol", ['Selesai', 'Dibatalkan']);
        }
        $keberangkatan = $kq
            ->orderBy("pemesanan.$orderCol", 'desc')
            ->limit(3)
            ->get()
            ->map(fn($r) => (object) [
                'nama_paket'   => $r->nama_paket ?? 'Paket Wisata',
                'status'       => $statusCol ? ($r->$statusCol ?? 'Menunggu Pembayaran') : 'Menunggu Pembayaran',
                'created_at'   => $r->$orderCol ?? null,
                'pemesanan_id' => $r->id,
            ]);

        return view('wisatawan.dashboard', compact(
            'pesanan_aktif',
            'pembayaran_pending',
            'tiket_tersedia',
            'keberangkatan'
        ));
    }

    // ─────────────────────────────────────────────────────────
    //  Paket Wisata (role-aware)
    // ─────────────────────────────────────────────────────────

    public function tampilPaket(): View
    {
        $data = DB::table('paket_wisata')->get();

        if (Auth::check() && Auth::user()->role === 'Admin') {
            return view('paket_wisata', ['data' => $data]);
        }

        return view('wisatawan.paket.index', ['data' => $data]);
    }

    public function detailPaket($id): View
    {
        $paket = DB::table('paket_wisata')->where('id', $id)->first();

        if (!$paket) {
            abort(404, 'Paket wisata tidak ditemukan.');
        }

        $jadwal = $this->jadwalUntukPaket($id);

        return view('wisatawan.paket.detail', compact('paket', 'jadwal'));
    }

    // ─────────────────────────────────────────────────────────
    //  Pemesanan Wizard (Wisatawan only)
    // ─────────────────────────────────────────────────────────

    public function pemesananStep1($id): View
    {
        $paket = DB::table('paket_wisata')->where('id', $id)->first();
        abort_unless($paket, 404, 'Paket tidak ditemukan.');

        $jadwal = $this->jadwalUntukPaket($id);

        return view('wisatawan.pemesanan.step1', compact('paket', 'jadwal'));
    }

    public function pemesananStep2($id): View
    {
        $paket = DB::table('paket_wisata')->where('id', $id)->first();
        abort_unless($paket, 404, 'Paket tidak ditemukan.');

        return view('wisatawan.pemesanan.step2', compact('paket'));
    }

    public function pemesananStep3($id): View
    {
        $paket = DB::table('paket_wisata')->where('id', $id)->first();
        abort_unless($paket, 404, 'Paket tidak ditemukan.');

        return view('wisatawan.pemesanan.step3', compact('paket'));
    }

    public function prosesPesan(Request $request)
    {
        $request->validate([
            'id_paket' => 'required',
            'jumlah'   => 'required|numeric|min:1',
        ]);

        $paket = DB::table('paket_wisata')->where('id', $request->id_paket)->first();
        abort_unless($paket, 404, 'Paket tidak ditemukan.');

        $jumlah = (int) $request->jumlah;
        $total  = (float) ($paket->harga ?? 0) * $jumlah;

        // Jadwal: pakai yang dipilih, kalau tidak ada ambil jadwal terbaru milik paket
        $jadwalId = $request->input('id_jadwal');
        if (!$jadwalId) {
            $jadwalId = optional($this->jadwalUntukPaket($paket->id)->first())->id;
        }

        // Tabel pemesanan mewajibkan jadwal (jadwal_id NOT NULL) — tanpa jadwal pesanan tidak bisa dibuat
        if ($this->col('pemesanan', ['jadwal_id', 'id_jadwal']) && !$jadwalId) {
            return back()->with('error', 'Paket "' . ($paket->nama_paket ?? 'ini') . '" belum memiliki jadwal keberangkatan, jadi belum bisa dipesan. Silakan hubungi admin.');
        }

        $row = $this->filterKolom('pemesanan', [
            [['user_id', 'id_user'],                          Auth::id()],
            [['paket_id', 'id_paket'],                        $paket->id],
            [['jadwal_id', 'id_jadwal'],                      $jadwalId],
            [['jumlah_peserta', 'jumlah_pax', 'jumlah'],      $jumlah],
            [['total_biaya', 'total_harga'],                  $total],
            [['kode_pemesanan'],                              'PSN-' . strtoupper(Str::random(6))],
            [['status', 'status_pemesanan'],                  'Menunggu Pembayaran'],
            [['tanggal_pemesanan', 'tanggal_pesan'],          now()],
            [['created_at'],                                  now()],
            [['updated_at'],                                  now()],
        ]);

        try {
            $pemesananId = DB::table('pemesanan')->insertGetId($row);
        } catch (QueryException $e) {
            Log::error('Gagal menyimpan pemesanan: ' . $e->getMessage());
            return back()->with('error', 'Pemesanan gagal disimpan.' . (config('app.debug') ? ' ' . $e->getMessage() : ''));
        }

        if (Auth::user()->role === 'Wisatawan') {
            return redirect('/pesanan-saya/' . $pemesananId)
                ->with('success', 'Pemesanan berhasil! Silakan lakukan pembayaran.');
        }

        return redirect('/pembayaran')->with('success', 'Pemesanan berhasil! Silakan lakukan pembayaran.');
    }

    // ─────────────────────────────────────────────────────────
    //  Pesanan Saya (Wisatawan)
    // ─────────────────────────────────────────────────────────

    public function pesananSaya(): View
    {
        $pemesananIds = $this->getPemesananIds();

        $data = $this->pemesananQuery()
            ->whereIn('pemesanan.id', $pemesananIds)
            ->orderBy('pemesanan.' . $this->orderCol('pemesanan'), 'desc')
            ->get();

        return view('wisatawan.pesanan.index', ['data' => $this->normalisasiPemesanan($data)]);
    }

    public function detailPesanan($id): View
    {
        $query = $this->pemesananQuery(true)->where('pemesanan.id', $id);
        $this->batasiPemilik($query);

        $pesanan = $query->first();
        abort_unless($pesanan, 404, 'Pesanan tidak ditemukan.');

        $pesanan = $this->normalisasiPemesanan(collect([$pesanan]))->first();

        $pembayaran = $this->pembayaranUntukPesanan($id);

        $tiket = null;
        $tiketCol = $this->col('tiket', ['id_pemesanan', 'pemesanan_id']);
        if ($tiketCol) {
            $tiket = DB::table('tiket')->where($tiketCol, $id)->first();
        }

        return view('wisatawan.pesanan.detail', compact('pesanan', 'pembayaran', 'tiket'));
    }

    // ─────────────────────────────────────────────────────────
    //  Pembayaran (role-aware)
    // ─────────────────────────────────────────────────────────

    public function tampilPembayaran(): View
    {
        if (Auth::user()->role === 'Admin') {
            $data = $this->normalisasiStatus(DB::table('pembayaran')->get());
            return view('pembayaran', ['data' => $data]);
        }

        $pemesananIds = $this->getPemesananIds();
        $bayarCol     = $this->col('pembayaran', ['id_pemesanan', 'pemesanan_id']);

        $data = $bayarCol
            ? DB::table('pembayaran')->whereIn($bayarCol, $pemesananIds)->get()
            : collect();

        // Pesanan terbaru yang belum lunas, supaya form bayar terisi otomatis
        $pesanan = $this->pemesananQuery()
            ->whereIn('pemesanan.id', $pemesananIds)
            ->orderBy('pemesanan.' . $this->orderCol('pemesanan'), 'desc')
            ->get();
        $pesanan = $this->normalisasiPemesanan($pesanan)
            ->first(fn($p) => !in_array($p->status ?? '', ['Lunas', 'Selesai', 'Dibatalkan'], true));

        return view('wisatawan.pembayaran', [
            'data'    => $this->normalisasiStatus($data),
            'pesanan' => $pesanan,
        ]);
    }

    public function halamanBayar($id): View
    {
        $query = $this->pemesananQuery()->where('pemesanan.id', $id);
        $this->batasiPemilik($query);

        $pesanan = $query->first();
        abort_unless($pesanan, 404, 'Pesanan tidak ditemukan.');

        $pesanan    = $this->normalisasiPemesanan(collect([$pesanan]))->first();
        $pembayaran = $this->pembayaranUntukPesanan($id);

        // View wisatawan.pembayaran memakai variabel $data
        return view('wisatawan.pembayaran', [
            'pesanan'    => $pesanan,
            'pembayaran' => $pembayaran,
            'data'       => $pembayaran,
        ]);
    }

    public function prosesBayar(Request $request)
    {
        $request->validate([
            'id_pemesanan' => 'required',
            'jumlah_bayar' => 'required|numeric',
            'bukti_bayar'  => 'required',
        ]);

        // Wisatawan hanya boleh membayar pesanannya sendiri
        if (Auth::user()->role !== 'Admin') {
            abort_unless(in_array((int) $request->id_pemesanan, array_map('intval', $this->getPemesananIds()), true), 403, 'Pesanan bukan milik Anda.');
        }

        $buktiBayar = $request->bukti_bayar;
        if ($request->hasFile('bukti_bayar')) {
            $buktiBayar = $request->file('bukti_bayar')->store('bukti_pembayaran', 'public');
        }

        $row = $this->filterKolom('pembayaran', [
            [['id_pemesanan', 'pemesanan_id'],                                   $request->id_pemesanan],
            [['jumlah_bayar', 'jumlah', 'nominal'],                              $request->jumlah_bayar],
            [['bukti_bayar', 'bukti_pembayaran', 'bukti_transfer', 'file_bukti'], $buktiBayar],
            [['status', 'status_pembayaran'],                                    'Verifikasi'],
            [['tanggal_bayar', 'tanggal_pembayaran'],                            now()],
            [['created_at'],                                                     now()],
            [['updated_at'],                                                     now()],
        ]);

        try {
            DB::table('pembayaran')->insert($row);
        } catch (QueryException $e) {
            Log::error('Gagal menyimpan pembayaran: ' . $e->getMessage());
            return back()->with('error', 'Pembayaran gagal disimpan.' . (config('app.debug') ? ' ' . $e->getMessage() : ''));
        }

        if (Auth::user()->role === 'Wisatawan') {
            return redirect('/pesanan-saya/' . $request->id_pemesanan)
                ->with('success', 'Pembayaran berhasil dikirim! Menunggu verifikasi admin.');
        }

        return redirect('/pembayaran')->with('success', 'Pembayaran berhasil dikirim! Menunggu verifikasi admin.');
    }

    public function verifikasiPembayaran(Request $request, $id)
    {
        abort_unless(Auth::user()->role === 'Admin', 403, 'Hanya admin yang dapat memverifikasi pembayaran.');

        $bayarStatusCol  = $this->col('pembayaran', ['status', 'status_pembayaran']);
        $bayarPesananCol = $this->col('pembayaran', ['id_pemesanan', 'pemesanan_id']);

        if ($bayarStatusCol) {
            DB::table('pembayaran')->where('id', $id)->update([$bayarStatusCol => 'Terverifikasi']);
        }

        $pembayaran = DB::table('pembayaran')->where('id', $id)->first();

        if ($pembayaran && $bayarPesananCol) {
            $pesananId = $pembayaran->$bayarPesananCol;

            $pesananStatusCol = $this->col('pemesanan', ['status', 'status_pemesanan']);
            if ($pesananStatusCol) {
                DB::table('pemesanan')->where('id', $pesananId)->update([$pesananStatusCol => 'Lunas']);
            }

            $tiketCol = $this->col('tiket', ['id_pemesanan', 'pemesanan_id']);
            if ($tiketCol && !DB::table('tiket')->where($tiketCol, $pesananId)->exists()) {
                $row = $this->filterKolom('tiket', [
                    [['id_pemesanan', 'pemesanan_id'], $pesananId],
                    [['kode_tiket'],                   'TKT-' . strtoupper(Str::random(8))],
                    [['created_at'],                   now()],
                    [['updated_at'],                   now()],
                ]);
                DB::table('tiket')->insert($row);
            }
        }

        return redirect('/pembayaran')->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    // ─────────────────────────────────────────────────────────
    //  Tiket (role-aware)
    // ─────────────────────────────────────────────────────────

    public function tampilTiket(): View
    {
        if (Auth::user()->role === 'Admin') {
            $data = DB::table('tiket')->get();
            return view('tiket', ['data' => $data]);
        }

        $pemesananIds = $this->getPemesananIds();
        $tiketCol     = $this->col('tiket', ['id_pemesanan', 'pemesanan_id']);

        $data = $tiketCol
            ? DB::table('tiket')->whereIn($tiketCol, $pemesananIds)->get()
            : collect();

        return view('wisatawan.tiket', ['data' => $data]);
    }

    public function detailTiket($id): View
    {
        $tiket = DB::table('tiket')->where('id', $id)->first();
        abort_unless($tiket, 404, 'Tiket tidak ditemukan.');

        $tiketCol  = $this->col('tiket', ['id_pemesanan', 'pemesanan_id']);
        $pesananId = $tiketCol ? $tiket->$tiketCol : null;

        // Wisatawan hanya boleh melihat tiketnya sendiri
        if (Auth::user()->role !== 'Admin') {
            abort_unless(in_array((int) $pesananId, array_map('intval', $this->getPemesananIds()), true), 403, 'Tiket bukan milik Anda.');
        }

        $pesanan = $pesananId
            ? $this->pemesananQuery()->where('pemesanan.id', $pesananId)->first()
            : null;

        // View wisatawan.tiket memakai variabel $data (koleksi tiket)
        return view('wisatawan.tiket', [
            'data'    => collect([$tiket]),
            'tiket'   => $tiket,
            'pesanan' => $pesanan,
        ]);
    }

    // ─────────────────────────────────────────────────────────
    //  Custom Trip (role-aware)
    // ─────────────────────────────────────────────────────────

    public function tampilCustomTrip(): View
    {
        if (Auth::user()->role === 'Admin') {
            $data = DB::table('custom_trip')->get();
            return view('custom_trip', ['data' => $data]);
        }

        return view('wisatawan.custom-trip.form');
    }

    public function daftarCustomTrip(): View
    {
        $userCol = $this->col('custom_trip', ['user_id', 'id_user']);

        $data = $userCol
            ? DB::table('custom_trip')
                ->where($userCol, Auth::id())
                ->orderBy($this->orderCol('custom_trip'), 'desc')
                ->get()
            : collect();

        return view('wisatawan.custom-trip.daftar', ['data' => $data]);
    }

    public function kirimCustomTrip(Request $request)
    {
        $request->validate([
            'tujuan'          => 'required|string|max:255',
            'jumlah_peserta'  => 'required|numeric|min:1',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kebutuhan'       => 'nullable|string',
        ]);

        $mulai   = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);
        $durasi  = (int) abs($mulai->diffInDays($selesai)) + 1;

        $row = $this->filterKolom('custom_trip', [
            [['user_id', 'id_user'],                                   Auth::id()],
            [['tujuan'],                                               $request->tujuan],
            [['jumlah_peserta'],                                       (int) $request->jumlah_peserta],
            [['tanggal_diinginkan', 'tanggal_mulai', 'tanggal_berangkat'], $request->tanggal_mulai],
            [['tanggal_selesai'],                                      $request->tanggal_selesai],
            [['durasi_hari'],                                          $durasi],
            [['kebutuhan', 'catatan', 'keterangan'],                   $request->kebutuhan ?? ''],
            [['status'],                                               'Diajukan'],
            [['created_at'],                                           now()],
            [['updated_at'],                                           now()],
        ]);

        try {
            DB::table('custom_trip')->insert($row);
        } catch (QueryException $e) {
            Log::error('Gagal menyimpan custom trip: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Pengajuan gagal disimpan.' . (config('app.debug') ? ' ' . $e->getMessage() : ''));
        }

        return redirect('/custom-trip/daftar')->with('success', 'Permintaan custom trip berhasil dikirim!');
    }

    // ─────────────────────────────────────────────────────────
    //  Profil & Akun (semua user yang login)
    // ─────────────────────────────────────────────────────────

    public function profil(): View
    {
        $user = DB::table('users')->where('id', Auth::id())->first();
        abort_unless($user, 404, 'Pengguna tidak ditemukan.');

        $pemesananIds = $this->getPemesananIds();
        $tiketCol     = $this->col('tiket', ['id_pemesanan', 'pemesanan_id']);

        $statistik = [
            'pesanan' => count($pemesananIds),
            'tiket'   => $tiketCol ? DB::table('tiket')->whereIn($tiketCol, $pemesananIds)->count() : 0,
        ];

        // Kolom opsional: hanya ditampilkan kalau tabel users memilikinya
        $kolomHp     = $this->col('users', ['no_hp', 'telepon', 'phone']);
        $kolomAlamat = $this->col('users', ['alamat', 'address']);

        return view('wisatawan.profil', [
            'user'        => $user,
            'statistik'   => $statistik,
            'noHp'        => $kolomHp ? ($user->$kolomHp ?? '') : null,
            'alamat'      => $kolomAlamat ? ($user->$kolomAlamat ?? '') : null,
            'punyaHp'     => (bool) $kolomHp,
            'punyaAlamat' => (bool) $kolomAlamat,
        ]);
    }

    public function updateProfil(Request $request)
    {
        $id = Auth::id();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:users,email,' . $id,
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah dipakai akun lain.',
        ]);

        // Nilai kosong dikirim sebagai '' (bukan null) agar kolom opsional bisa dikosongkan
        $row = $this->filterKolom('users', [
            [['name'],                         $request->name],
            [['email'],                        $request->email],
            [['no_hp', 'telepon', 'phone'],    (string) $request->no_hp],
            [['alamat', 'address'],            (string) $request->alamat],
            [['updated_at'],                   now()],
        ]);

        DB::table('users')->where('id', $id)->update($row);

        return redirect('/profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function ubahPassword(): View
    {
        return view('wisatawan.ubah-password');
    }

    public function prosesUbahPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|min:6|confirmed|different:password_lama',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password.required'      => 'Password baru wajib diisi.',
            'password.min'           => 'Password baru minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi password baru tidak cocok.',
            'password.different'     => 'Password baru harus berbeda dari password lama.',
        ]);

        $user = DB::table('users')->where('id', Auth::id())->first();
        abort_unless($user, 404, 'Pengguna tidak ditemukan.');

        // Aplikasi ini menyimpan & membandingkan password apa adanya (lihat prosesLogin),
        // jadi perubahan password harus mengikuti cara yang sama agar login tetap berfungsi.
        if ($user->password !== $request->password_lama) {
            return back()->withErrors(['password_lama' => 'Password lama salah.']);
        }

        $row = $this->filterKolom('users', [
            [['password'],   $request->password],
            [['updated_at'], now()],
        ]);

        DB::table('users')->where('id', $user->id)->update($row);

        return redirect('/profil')->with('success', 'Password berhasil diubah.');
    }

    // ─────────────────────────────────────────────────────────
    //  Admin-Only Pages
    // ─────────────────────────────────────────────────────────

    public function tampilUsers(): View
    {
        $this->wajibAdmin();
        return view('users', ['data' => DB::table('users')->get()]);
    }

    public function tampilKendaraan(): View
    {
        $this->wajibAdmin();

        try {
            $data = DB::table('kendaraan')->get();
        } catch (\Exception $e) {
            $data = [];
        }

        return view('kendaraan', ['data' => $data]);
    }

    public function tampilJadwal(): View
    {
        $this->wajibAdmin();
        return view('jadwal_keberangkatan', ['data' => DB::table('jadwal_keberangkatan')->get()]);
    }

    public function tampilPeserta(): View
    {
        $this->wajibAdmin();
        return view('peserta', ['data' => DB::table('peserta')->get()]);
    }

    public function tampilPemesanan(): View
    {
        $data = (Auth::user()?->role === 'Admin')
            ? DB::table('pemesanan')->get()
            : DB::table('pemesanan')->whereIn('id', $this->getPemesananIds())->get();

        return view('pemesanan', ['data' => $this->normalisasiPemesanan($data)]);
    }

    public function tampilPengembalian(): View
    {
        try {
            if (Auth::user()?->role === 'Admin') {
                $data = DB::table('pengembalian')->get();
            } else {
                $col  = $this->col('pengembalian', ['id_pemesanan', 'pemesanan_id']);
                $data = $col
                    ? DB::table('pengembalian')->whereIn($col, $this->getPemesananIds())->get()
                    : collect();
            }
        } catch (\Exception $e) {
            $data = [];
        }

        return view('pengembalian', ['data' => $data]);
    }

    public function tampilLaporan(): View
    {
        $this->wajibAdmin();

        return view('laporan', [
            'pemesanan'  => DB::table('pemesanan')->get(),
            'pembayaran' => DB::table('pembayaran')->get(),
        ]);
    }

    // ─────────────────────────────────────────────────────────
    //  Helper — deteksi skema
    //  Tabel bisnis dibuat di luar migrasi Laravel, jadi nama kolom
    //  dicek ke database dulu supaya query tidak error.
    // ─────────────────────────────────────────────────────────

    /** Ambil nama kolom pertama dari $kandidat yang benar-benar ada di tabel. */
    private function col(string $table, array $kandidat): ?string
    {
        if (!Schema::hasTable($table)) {
            return null;
        }

        foreach ($kandidat as $c) {
            if (Schema::hasColumn($table, $c)) {
                return $c;
            }
        }

        return null;
    }

    /** Kolom untuk pengurutan: created_at kalau ada, kalau tidak id. */
    private function orderCol(string $table): string
    {
        return $this->col($table, ['created_at', 'id']) ?? 'id';
    }

    /**
     * Susun array insert hanya dari kolom yang ada.
     * Format: [ [ ['kolom_a','kolom_b'], nilai ], ... ]
     * Kolom pertama yang ada dipakai; nilai null dilewati.
     */
    private function filterKolom(string $table, array $peta): array
    {
        $row = [];

        foreach ($peta as [$kandidat, $nilai]) {
            if ($nilai === null) {
                continue;
            }
            $c = $this->col($table, $kandidat);
            if ($c && !array_key_exists($c, $row)) {
                $row[$c] = $nilai;
            }
        }

        return $row;
    }

    /** Query pemesanan + data paket. Paket bisa langsung di pemesanan, atau lewat jadwal_keberangkatan. */
    private function pemesananQuery(bool $denganDeskripsi = false)
    {
        $q      = DB::table('pemesanan');
        $select = ['pemesanan.*'];

        if ($this->joinPaket($q)) {
            $select[] = 'paket_wisata.nama_paket';
            $select[] = 'paket_wisata.harga';
            if ($denganDeskripsi) {
                $select[] = Schema::hasColumn('paket_wisata', 'deskripsi')
                    ? 'paket_wisata.deskripsi'
                    : DB::raw('NULL as deskripsi');
            }
        } else {
            $select[] = DB::raw('NULL as nama_paket');
            $select[] = DB::raw('NULL as harga');
            if ($denganDeskripsi) {
                $select[] = DB::raw('NULL as deskripsi');
            }
        }

        return $q->select($select);
    }

    /**
     * Hubungkan query pemesanan ke paket_wisata.
     * 1) langsung lewat kolom paket di pemesanan, atau
     * 2) lewat pemesanan.jadwal_id -> jadwal_keberangkatan -> paket_wisata.
     */
    private function joinPaket($q): bool
    {
        $paketCol = $this->col('pemesanan', ['paket_id', 'id_paket']);
        if ($paketCol) {
            $q->leftJoin('paket_wisata', "pemesanan.$paketCol", '=', 'paket_wisata.id');
            return true;
        }

        $jadwalCol      = $this->col('pemesanan', ['jadwal_id', 'id_jadwal']);
        $jadwalPaketCol = $this->jadwalPaketCol();
        if ($jadwalCol && $jadwalPaketCol) {
            $q->leftJoin('jadwal_keberangkatan as jk', "pemesanan.$jadwalCol", '=', 'jk.id')
              ->leftJoin('paket_wisata', "jk.$jadwalPaketCol", '=', 'paket_wisata.id');
            return true;
        }

        return false;
    }

    /** Kolom di jadwal_keberangkatan yang menunjuk ke paket_wisata (nama dideteksi). */
    private function jadwalPaketCol(): ?string
    {
        $c = $this->col('jadwal_keberangkatan', ['paket_id', 'id_paket', 'paket_wisata_id', 'id_paket_wisata']);
        if ($c) {
            return $c;
        }

        if (!Schema::hasTable('jadwal_keberangkatan')) {
            return null;
        }

        foreach (Schema::getColumnListing('jadwal_keberangkatan') as $nama) {
            if (preg_match('/paket.*id|id.*paket/i', $nama)) {
                return $nama;
            }
        }

        return null;
    }

    /** Batasi query pemesanan ke milik user login (admin melihat semua). */
    private function batasiPemilik($query): void
    {
        if (Auth::user()?->role === 'Admin') {
            return;
        }

        $userCol = $this->col('pemesanan', ['user_id', 'id_user']);
        $userCol
            ? $query->where("pemesanan.$userCol", Auth::id())
            : $query->whereRaw('1 = 0');
    }

    private function jadwalUntukPaket($paketId)
    {
        $col = $this->jadwalPaketCol();
        if (!$col) {
            return collect();
        }

        return DB::table('jadwal_keberangkatan')
            ->where($col, $paketId)
            ->orderBy($this->orderCol('jadwal_keberangkatan'), 'desc')
            ->get();
    }

    private function pembayaranUntukPesanan($pesananId)
    {
        $col = $this->col('pembayaran', ['id_pemesanan', 'pemesanan_id']);
        if (!$col) {
            return collect();
        }

        return $this->normalisasiStatus(
            DB::table('pembayaran')
                ->where($col, $pesananId)
                ->orderBy($this->orderCol('pembayaran'), 'desc')
                ->get()
        );
    }

    /** Samakan nama kolom status supaya view cukup memakai ->status. */
    private function normalisasiStatus($rows)
    {
        return collect($rows)->map(function ($r) {
            if (!isset($r->status)) {
                foreach (['status_pemesanan', 'status_pembayaran'] as $k) {
                    if (isset($r->$k)) {
                        $r->status = $r->$k;
                        break;
                    }
                }
            }
            return $r;
        });
    }

    /** Normalisasi status + hitung total biaya bila kolomnya tidak ada. */
    private function normalisasiPemesanan($rows)
    {
        return $this->normalisasiStatus($rows)->map(function ($r) {
            if (!isset($r->total_biaya) || (float) $r->total_biaya <= 0) {
                $total = null;
                if (isset($r->total_harga) && (float) $r->total_harga > 0) {
                    $total = (float) $r->total_harga;
                } elseif (isset($r->harga)) {
                    $jumlah = $r->jumlah_peserta ?? $r->jumlah_pax ?? $r->jumlah ?? 1;
                    $total  = (float) $r->harga * max(1, (int) $jumlah);
                }
                if ($total !== null) {
                    $r->total_biaya = $total;
                }
            }
            return $r;
        });
    }

    /**
     * SEMENTARA: tampilkan struktur database (tabel, kolom, relasi, jumlah baris) sebagai teks.
     * Hanya aktif saat APP_DEBUG=true. Hapus method + route ini sebelum aplikasi dikumpulkan/dipublikasikan.
     */
    public function debugSkema()
    {
        abort_unless(config('app.debug'), 404);

        $abaikan = ['migrations', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs', 'sessions', 'password_reset_tokens'];
        $out     = ["DATABASE: " . DB::getDatabaseName(), ''];

        foreach (Schema::getTables() as $t) {
            $nama = $t['name'];
            if (in_array($nama, $abaikan, true)) {
                continue;
            }

            $out[] = "TABEL {$nama}  (" . DB::table($nama)->count() . " baris)";
            foreach (Schema::getColumns($nama) as $c) {
                $out[] = sprintf(
                    '  - %s  %s  %s%s%s',
                    $c['name'],
                    $c['type'],
                    $c['nullable'] ? 'NULL' : 'NOT NULL',
                    ($c['default'] ?? null) !== null ? '  default=' . $c['default'] : '',
                    !empty($c['auto_increment']) ? '  AUTO_INCREMENT' : ''
                );
            }
            foreach (Schema::getForeignKeys($nama) as $fk) {
                $out[] = '  FK (' . implode(',', $fk['columns']) . ') -> ' . $fk['foreign_table'] . '(' . implode(',', $fk['foreign_columns']) . ')';
            }
            $out[] = '';
        }

        return response(implode("\n", $out), 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    private function wajibAdmin(): void
    {
        abort_unless(Auth::user()?->role === 'Admin', 403, 'Halaman ini hanya untuk admin.');
    }

    private function getPemesananIds(): array
    {
        $col = $this->col('pemesanan', ['user_id', 'id_user']);
        if (!$col) {
            return [];
        }

        return DB::table('pemesanan')->where($col, Auth::id())->pluck('id')->toArray();
    }
}

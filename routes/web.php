<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage; 

// --- 1. LIVEWIRE COMPONENTS ---
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\AturJadwal;
use App\Livewire\Admin\ManajemenUser;
use App\Livewire\Pimpinan\Dashboard as PimpinanDashboard;
use App\Livewire\StrukturOrganisasi;
use App\Livewire\DokumenRenstra;
use App\Livewire\TujuanRenstra;
use App\Livewire\SasaranRenstra;
use App\Livewire\OutcomeRenstra;
use App\Livewire\ProgramKegiatan;
use App\Livewire\KegiatanRenstra;
use App\Livewire\SubKegiatanRenstra;
use App\Livewire\CascadingRenstra;
use App\Livewire\PerjanjianKinerja;
use App\Livewire\PerjanjianKinerjaDetail;
use App\Livewire\PerjanjianKinerjaLihat;
use App\Livewire\PengukuranBulanan;
use App\Livewire\PengukuranKinerja as DetailPengukuranKinerja;
use App\Livewire\PengaturanKinerja;
use App\Livewire\Laporan\Index as LaporanIndex; 

// --- 2. MODELS ---
use App\Models\PerjanjianKinerja as PkModel;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\Outcome;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\PohonKinerja;

// --- 3. EXPORT & PDF ---
use App\Exports\DokumenRenstraExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HALAMAN LOGIN ---
Route::get('/login', Login::class)->name('login');


// --- ROUTES YANG BUTUH LOGIN (MIDDLEWARE AUTH) ---
Route::middleware('auth')->group(function () {

    // 1. LOGOUT
    Route::post('/logout', function () {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    })->name('logout');


    // 2. DASHBOARD UTAMA
    Route::get('/', Dashboard::class)->name('dashboard');


    // 3. AREA ADMIN (Role: Admin)
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/admin/atur-jadwal', AturJadwal::class)->name('admin.atur-jadwal');
        Route::get('/admin/manajemen-user', ManajemenUser::class)->name('admin.manajemen-user');
        
        // --- ROUTE PUSAT LAPORAN ---
        Route::get('/admin/laporan', LaporanIndex::class)->name('laporan.index');

        // --- GROUP LOGIC CETAK PDF LAPORAN ---
        Route::prefix('laporan/cetak')->group(function () {

            // A. LAPORAN STATUS PENGISIAN PK
            Route::get('/status-pk', function (Request $request) {
                $tahun = (int) ($request->year ?? date('Y'));
                $status = $request->status ?? 'all';

                $pegawais = Pegawai::with(['jabatan', 'jabatan.perjanjianKinerja' => function($q) use($tahun) {
                    $q->where('tahun', $tahun);
                }])->orderBy('nama', 'asc')->get();

                if ($status !== 'all') {
                    $pegawais = $pegawais->filter(function ($p) use ($status) {
                        $pk = $p->jabatan?->perjanjianKinerja->first();
                        if ($status == 'draft') return !$pk || $pk->status == 'draft';
                        if ($status == 'final') return $pk && $pk->status == 'final';
                        return true;
                    });
                }

                $pdf = Pdf::loadView('cetak.laporan-status-pk', compact('pegawais', 'tahun', 'status'));
                $pdf->setPaper('a4', 'portrait');
                return $pdf->stream('Laporan_Status_PK_'.$tahun.'.pdf');
            })->name('laporan.status-pk.print');


            // B. LAPORAN REKAP SUB KEGIATAN
            Route::get('/sub-kegiatan', function (Request $request) {
                $tahun = (int) ($request->year ?? date('Y'));
                
                $subKegiatans = SubKegiatan::with(['indikators', 'kegiatan.program'])
                    ->get();

                $pdf = Pdf::loadView('cetak.laporan-sub-kegiatan', compact('subKegiatans', 'tahun'));
                $pdf->setPaper('a4', 'landscape');
                return $pdf->stream('Laporan_Sub_Kegiatan_'.$tahun.'.pdf');
            })->name('laporan.sub-kegiatan.print');


            // C. LAPORAN KINERJA BULANAN (UPDATE BAHASA INDONESIA)
            Route::get('/bulanan', function (Request $request) {
                $bulan = (int) ($request->month ?? date('n'));
                $tahun = (int) ($request->year ?? date('Y'));
                
                // --- PERBAIKAN: PAKAI ARRAY MANUAL BIAR PASTI INDONESIA ---
                $daftarBulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                $nama_bulan = $daftarBulan[$bulan] ?? 'Bulan Tidak Valid';

                // Query Data
                $pegawais = Pegawai::with(['jabatan', 'jabatan.perjanjianKinerja' => function($q) use ($tahun) {
                        $q->where('tahun', $tahun);
                    }, 
                    'jabatan.perjanjianKinerja.sasarans.indikators.realisasi' => function($q) use ($bulan, $tahun) {
                        $q->where('bulan', $bulan)->where('tahun', $tahun);
                    }
                ])->whereHas('jabatan')->orderBy('nama')->get();

                $pdf = Pdf::loadView('cetak.laporan-bulanan', compact('pegawais', 'bulan', 'tahun', 'nama_bulan'));
                $pdf->setPaper('a4', 'landscape');
                return $pdf->stream('Laporan_Bulanan_'.$nama_bulan.'_'.$tahun.'.pdf');
            })->name('laporan.bulanan.print');


            // D. LAPORAN TOP PERFORMER (UPDATE BAHASA INDONESIA)
            Route::get('/top-performer', function (Request $request) {
                $bulan = (int) ($request->month ?? date('n'));
                $tahun = (int) ($request->year ?? date('Y'));
                
                // --- PERBAIKAN: PAKAI ARRAY MANUAL JUGA ---
                $daftarBulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                $nama_bulan = $daftarBulan[$bulan] ?? 'Bulan Tidak Valid';

                // Hitung Data
                $pegawais = Pegawai::with(['jabatan'])->get()->map(function($pegawai) use ($bulan, $tahun) {
                    $totalCapaian = 0;
                    $jumlahIndikator = 0;

                    if ($pegawai->jabatan) {
                        $pk = PkModel::where('jabatan_id', $pegawai->jabatan_id)
                            ->where('tahun', $tahun)->with('sasarans.indikators.realisasi')->first();

                        if ($pk) {
                            foreach ($pk->sasarans as $sasaran) {
                                foreach ($sasaran->indikators as $indikator) {
                                    $realisasi = $indikator->realisasi->where('bulan', $bulan)->where('tahun', $tahun)->first();
                                    if ($realisasi) {
                                        $totalCapaian += $realisasi->capaian;
                                        $jumlahIndikator++;
                                    }
                                }
                            }
                        }
                    }

                    $pegawai->rata_rata = $jumlahIndikator > 0 ? round($totalCapaian / $jumlahIndikator, 2) : 0;
                    return $pegawai;
                });

                $sortedPegawais = $pegawais->sortByDesc('rata_rata')->values();

                $pdf = Pdf::loadView('cetak.laporan-top-performer', compact('sortedPegawais', 'bulan', 'tahun', 'nama_bulan'));
                $pdf->setPaper('a4', 'portrait');
                return $pdf->stream('Top_Performer_'.$nama_bulan.'_'.$tahun.'.pdf');
            })->name('laporan.top-performer.print');

        });
    });


    // 4. AREA PIMPINAN (Role: Pimpinan)
    Route::middleware('role:pimpinan')->group(function () {
        Route::get('/pimpinan/dashboard', PimpinanDashboard::class)->name('pimpinan.dashboard');
    });


    // 5. FITUR DOWNLOAD AMAN
    Route::get('/dokumen/unduh/{folder}/{filename}', function ($folder, $filename) {
        $path = $folder . '/' . $filename;
        if (!Storage::exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }
        return Storage::download($path);
    })->name('dokumen.download');


    // --- MASTER DATA ---
    Route::get('/struktur-organisasi', StrukturOrganisasi::class);
    
    // --- MATRIK RENSTRA ---
    Route::prefix('matrik-renstra')->group(function () {
        
        Route::get('/dokumen', DokumenRenstra::class)->name('matrik.dokumen');
        
        // CETAK PDF RENSTRA
        Route::get('/dokumen/cetak', function () {
            $tujuans = Tujuan::with('pohonKinerja.indikators')->get();
            $sasarans = Sasaran::with('pohonKinerja.indikators')->get();
            $outcomes = Outcome::with(['program', 'pohonKinerja.indikators'])->get();
            $kegiatans = Kegiatan::with('pohonKinerja.indikators')->whereNotNull('output')->get();
            $sub_kegiatans = SubKegiatan::with('pohonKinerja.indikators')->get();

            $header = ['unit_kerja' => 'DINAS KESEHATAN', 'periode' => '2025 - 2029'];
            
            $pdf = Pdf::loadView('cetak.dokumen-renstra', compact(
                'tujuans', 'sasarans', 'outcomes', 'kegiatans', 'sub_kegiatans', 'header'
            ));

            $pdf->setPaper('a4', 'landscape');
            return $pdf->download('Matriks_RENSTRA_Dinas_Kesehatan.pdf');
        })->name('matrik.dokumen.print');

        // EXPORT EXCEL RENSTRA
        Route::get('/dokumen/excel', function () {
            $data = [
                'tujuans' => Tujuan::with('pohonKinerja.indikators')->get(),
                'sasarans' => Sasaran::with('pohonKinerja.indikators')->get(),
                'outcomes' => Outcome::with(['program', 'pohonKinerja.indikators'])->get(),
                'kegiatans' => Kegiatan::with('pohonKinerja.indikators')->whereNotNull('output')->get(),
                'sub_kegiatans' => SubKegiatan::with('pohonKinerja.indikators')->get(),
                'header' => ['unit_kerja' => 'DINAS KESEHATAN', 'periode' => '2025 - 2029']
            ];
            return Excel::download(new DokumenRenstraExport($data), 'Matriks_RENSTRA_Dinas_Kesehatan.xlsx');
        })->name('matrik.dokumen.excel');

        // SUB MENU MATRIK
        Route::get('/tujuan', TujuanRenstra::class);
        Route::get('/sasaran', SasaranRenstra::class);
        Route::get('/outcome', OutcomeRenstra::class);
        Route::get('/program-kegiatan-sub', ProgramKegiatan::class)->name('matrik.program');
        Route::get('/program-kegiatan-sub/kegiatan/{id}', KegiatanRenstra::class)->name('matrik.kegiatan');
        Route::get('/renstra/kegiatan/{id}/sub-kegiatan', SubKegiatanRenstra::class)->name('renstra.sub_kegiatan');
    });

    // --- PERENCANAAN KINERJA ---
    Route::prefix('perencanaan-kinerja')->group(function () {
        Route::get('/cascading-renstra', CascadingRenstra::class)->name('cascading.renstra');
        Route::get('/perjanjian-kinerja', PerjanjianKinerja::class)->name('perjanjian.kinerja');
        Route::get('/perjanjian-kinerja/{id}', PerjanjianKinerjaDetail::class)->name('perjanjian.kinerja.detail');
        Route::get('/perjanjian-kinerja/lihat/{id}', PerjanjianKinerjaLihat::class)->name('perjanjian.kinerja.lihat');
        
        // CETAK PERJANJIAN KINERJA
        Route::get('/perjanjian-kinerja/cetak/{id}', function ($id) {
            $pk = PkModel::with(['jabatan', 'pegawai', 'sasarans.indikators', 'anggarans.subKegiatan'])->findOrFail($id);
            $jabatan = $pk->jabatan;
            
            $is_kepala_dinas = is_null($jabatan->parent_id);
            $atasan_pegawai = null;
            $atasan_jabatan = null;

            if ($jabatan->parent_id) {
                $parentJabatan = Jabatan::find($jabatan->parent_id);
                if ($parentJabatan) {
                    $atasan_jabatan = $parentJabatan;
                    $atasan_pegawai = Pegawai::where('jabatan_id', $parentJabatan->id)->latest()->first();
                }
            }
            
            $pdf = Pdf::loadView('cetak.perjanjian-kinerja', [
                'pk' => $pk,
                'jabatan' => $jabatan,
                'pegawai' => $pk->pegawai,
                'is_kepala_dinas' => $is_kepala_dinas,
                'atasan_pegawai' => $atasan_pegawai,
                'atasan_jabatan' => $atasan_jabatan
            ]);

            $pdf->setPaper('a4', 'portrait');
            $namaFile = 'PK_' . $pk->tahun . '_' . str_replace(' ', '_', $jabatan->nama) . '.pdf';

            return $pdf->download($namaFile);
        })->name('perjanjian.kinerja.print');
    });

    // --- PENGUKURAN KINERJA ---
    Route::prefix('pengukuran-kinerja')->group(function () {
        Route::get('/bulanan', PengukuranBulanan::class)->name('pengukuran.bulanan');
        Route::get('/atur-kinerja/{jabatanId}', PengaturanKinerja::class)->name('pengukuran.atur');
        Route::get('/pengukuran/{jabatanId}', DetailPengukuranKinerja::class)->name('pengukuran.detail');
    });
});
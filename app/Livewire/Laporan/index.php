<?php

namespace App\Livewire\Laporan;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\PerjanjianKinerja;

#[Title('Pusat Laporan')]
class Index extends Component
{
    // State Tab
    public $activeTab = 'pk';

    // State Filter
    public $selectedPegawaiId;
    public $year;
    public $month;
    public $filterStatus = 'all';

    public function mount()
    {
        $this->year = date('Y');
        $this->month = date('n');
    }

    public function render()
    {
        // Ambil data pegawai yang punya jabatan saja (biar list tidak kotor)
        $pegawais = Pegawai::with('jabatan')
            ->whereNotNull('jabatan_id')
            ->orderBy('nama', 'asc')
            ->get();

        return view('livewire.laporan.index', [
            'pegawais' => $pegawais
        ]);
    }

    // --- 1. LOGIC CETAK PERJANJIAN KINERJA (YANG BERMASALAH TADI) ---
    public function cetakPK()
    {
        // 1. Cek apakah pegawai sudah dipilih
        if (empty($this->selectedPegawaiId)) {
            // Gunakan Javacript alert standar jika sweetalert belum setup
            $this->js("alert('Silakan pilih pegawai terlebih dahulu!')");
            return;
        }

        // 2. Ambil Data Pegawai
        $pegawai = Pegawai::find($this->selectedPegawaiId);
        
        if (!$pegawai || !$pegawai->jabatan_id) {
            $this->js("alert('Pegawai tidak memiliki jabatan aktif.')");
            return;
        }

        // 3. Cari Dokumen PK berdasarkan Jabatan & Tahun
        $pk = PerjanjianKinerja::where('jabatan_id', $pegawai->jabatan_id)
                                ->where('tahun', $this->year)
                                ->first();

        // 4. Redirect jika ketemu, Alert jika kosong
        if ($pk) {
            return redirect()->route('perjanjian.kinerja.print', ['id' => $pk->id]);
        } else {
            $this->js("alert('Dokumen Perjanjian Kinerja tahun {$this->year} belum dibuat/ditemukan untuk pegawai ini.')");
        }
    }

    // --- 2. LOGIC CETAK LAINNYA ---
    
    public function cetakStatusPK()
    {
        return redirect()->route('laporan.status-pk.print', [
            'status' => $this->filterStatus,
            'year' => $this->year
        ]);
    }

    public function cetakSubKegiatan()
    {
        return redirect()->route('laporan.sub-kegiatan.print', [
            'year' => $this->year
        ]);
    }

    public function cetakBulanan()
    {
        return redirect()->route('laporan.bulanan.print', [
            'month' => $this->month,
            'year' => $this->year
        ]);
    }

    public function cetakTopPerformer()
    {
        return redirect()->route('laporan.top-performer.print', [
            'month' => $this->month,
            'year' => $this->year
        ]);
    }
}
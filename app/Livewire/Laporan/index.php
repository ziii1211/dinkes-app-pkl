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
    // State untuk Tab Aktif (Default: PK)
    public $activeTab = 'pk';

    // State untuk Filter Form
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
        // Ambil data pegawai untuk dropdown filter
        $pegawais = Pegawai::orderBy('nama', 'asc')->get();

        return view('livewire.laporan.index', [
            'pegawais' => $pegawais
        ]);
    }

    // --- LOGIC CETAK (Nanti kita isi logic PDF di sini satu per satu) ---
    
    public function cetakPK()
    {
        // Validasi simpel
        if(!$this->selectedPegawaiId) {
            // Jika mau cetak semua, nanti kita handle logicnya
            // Untuk sekarang kita alert dulu
            $this->dispatch('alert', [
                'type' => 'info',
                'title' => 'Info',
                'message' => 'Fitur cetak masal sedang disiapkan. Pilih 1 pegawai dulu.'
            ]);
            return;
        }

        // Cari ID PK berdasarkan Pegawai & Tahun
        $pegawai = Pegawai::find($this->selectedPegawaiId);
        if(!$pegawai || !$pegawai->jabatan_id) {
             $this->dispatch('alert', ['type' => 'error', 'title' => 'Gagal', 'message' => 'Pegawai tidak memiliki jabatan.']);
             return;
        }

        $pk = PerjanjianKinerja::where('jabatan_id', $pegawai->jabatan_id)
                                ->where('tahun', $this->year)
                                ->first();

        if($pk) {
            // Redirect ke route cetak yang sudah ada di web.php
            return redirect()->route('perjanjian.kinerja.print', ['id' => $pk->id]);
        } else {
            $this->dispatch('alert', ['type' => 'warning', 'title' => 'Tidak Ditemukan', 'message' => 'Dokumen PK belum dibuat untuk pegawai ini.']);
        }
    }

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
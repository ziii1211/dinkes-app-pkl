<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PkIndikator extends Model
{
    use HasFactory;

    protected $fillable = [
        'pk_sasaran_id', 
        'nama_indikator', 
        'satuan', 
        'arah',
        // Target Per Tahun
        'target_2025', 'target_2026', 'target_2027', 
        'target_2028', 'target_2029', 'target_2030'
    ];

    // --- PERBAIKAN: TAMBAHKAN RELASI KE SASARAN (PARENT) ---
    public function sasaran()
    {
        return $this->belongsTo(PkSasaran::class, 'pk_sasaran_id');
    }

    // --- PERBAIKAN: TAMBAHKAN RELASI KE REALISASI (CHILD) ---
    // Indikator punya banyak data realisasi (per bulan)
    public function realisasi()
    {
        return $this->hasMany(RealisasiKinerja::class, 'indikator_id');
    }
}

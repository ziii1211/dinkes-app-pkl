<!DOCTYPE html>
<html>
<head>
    <title>Top Performer</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; margin: 0; padding: 0; }
        
        /* KOP SURAT */
        .kop-surat { width: 100%; border-bottom: 4px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .logo-img { width: 85px; height: auto; }
        .text-cell { width: 85%; text-align: center; vertical-align: middle; padding-right: 15%; }
        .text-header-1 { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .text-header-2 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 2px 0; }
        .text-address { font-size: 10pt; font-weight: normal; margin: 0; }

        .judul-laporan { text-align: center; margin-bottom: 20px; font-weight: bold; font-size: 12pt; text-transform: uppercase; }
        
        table.data { width: 100%; border-collapse: collapse; }
        table.data th, table.data td { border: 1px solid #000; padding: 8px 12px; }
        table.data th { background-color: #333; color: white; text-align: center; }
        
        .rank-1 { background-color: #FFF8DC; } /* Goldish */
        .rank-2 { background-color: #F5F5F5; } /* Silverish */
        .rank-3 { background-color: #FFF0F5; } /* Bronzish */
    </style>
</head>
<body>
    
    {{-- KOP SURAT --}}
    <table class="kop-surat">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('Coat_of_arms_of_South_Kalimantan.svg.png') }}" class="logo-img" alt="Logo">
            </td>
            <td class="text-cell">
                <div class="text-header-1">PEMERINTAH PROVINSI KALIMANTAN SELATAN</div>
                <div class="text-header-2">DINAS KESEHATAN</div>
                <div class="text-address">Jalan Belitung Darat No.118 Banjarmasin Kode Pos 70116</div>
                <div class="text-address">Telepon : (0511) 3355661 – 3352575 (Fax - 3359735)</div>
                <div class="text-address">Email : keskalsel@gmail.com Website : https://dinkes.kalselprov.go.id</div>
            </td>
        </tr>
    </table>

    <div class="judul-laporan">
        PERINGKAT KINERJA PEGAWAI (TOP PERFORMER) <br> PERIODE: {{ strtoupper($nama_bulan) }} {{ $tahun }}
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="10%">Peringkat</th>
                <th width="40%">Nama Pegawai</th>
                <th width="30%">Jabatan</th>
                <th width="20%">Rata-rata Capaian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sortedPegawais as $index => $p)
                <tr class="{{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : '')) }}">
                    <td align="center" style="font-weight: bold; font-size: 14px;">#{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $p->nama }}</strong><br>
                        <small>NIP. {{ $p->nip }}</small>
                    </td>
                    <td>{{ $p->jabatan->nama ?? '-' }}</td>
                    <td align="center" style="font-weight: bold; font-size: 14px; {{ $p->rata_rata >= 100 ? 'color: green;' : 'color: red;' }}">
                        {{ $p->rata_rata }}%
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center">Data belum tersedia untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 20px; font-size: 11px; color: gray;">
        * Peringkat dihitung berdasarkan rata-rata persentase capaian seluruh indikator kinerja individu pada bulan tersebut.
    </div>
</body>
</html>
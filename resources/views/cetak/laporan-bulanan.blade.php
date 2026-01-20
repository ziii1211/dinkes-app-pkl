<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11px; margin: 0; padding: 0; }
        
        /* KOP SURAT */
        .kop-surat { width: 100%; border-bottom: 4px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .logo-img { width: 85px; height: auto; }
        .text-cell { width: 85%; text-align: center; vertical-align: middle; padding-right: 15%; }
        .text-header-1 { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .text-header-2 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 2px 0; }
        .text-address { font-size: 10pt; font-weight: normal; margin: 0; }

        .judul-laporan { text-align: center; margin-bottom: 15px; font-weight: bold; font-size: 12pt; text-transform: uppercase; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th, table.data td { border: 1px solid #000; padding: 4px; }
        table.data th { background-color: #eee; text-align: center; }
        .section-title { background-color: #f9f9f9; font-weight: bold; padding: 5px; }
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
        LAPORAN CAPAIAN KINERJA BULANAN <br> PERIODE: {{ strtoupper($nama_bulan) }} {{ $tahun }}
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="20%">Nama Pegawai</th>
                <th width="40%">Indikator Kinerja</th>
                <th width="10%">Target</th>
                <th width="10%">Realisasi</th>
                <th width="10%">Capaian (%)</th>
                <th width="10%">Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawais as $p)
                @php 
                    $pk = $p->jabatan?->perjanjianKinerja->first(); 
                @endphp
                
                @if($pk)
                    <tr class="section-title">
                        <td colspan="6">{{ $p->nama }} - {{ $p->jabatan->nama ?? '' }}</td>
                    </tr>

                    @foreach($pk->sasarans as $sasaran)
                        @foreach($sasaran->indikators as $ind)
                            @php
                                $real = $ind->realisasi->first(); 
                                $target = $tahun == 2025 ? $ind->target_2025 : $ind->target_2026;
                                $capaian = $real ? $real->capaian : 0;
                            @endphp
                            <tr>
                                <td></td>
                                <td>{{ $ind->nama_indikator }}</td>
                                <td align="center">{{ $target }}</td>
                                <td align="center">{{ $real ? $real->realisasi : '0' }}</td>
                                <td align="center" style="{{ $capaian < 100 ? 'color:red;' : 'color:green;' }}">
                                    {{ $capaian }}%
                                </td>
                                <td align="center">{{ $real ? 'Input' : 'Belum' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Sub Kegiatan</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11px; margin: 0; padding: 0; }
        
        /* KOP SURAT STYLE */
        .kop-surat { width: 100%; border-bottom: 4px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .logo-img { width: 85px; height: auto; }
        .text-cell { width: 85%; text-align: center; vertical-align: middle; padding-right: 15%; }
        .text-header-1 { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .text-header-2 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 2px 0; }
        .text-address { font-size: 10pt; font-weight: normal; margin: 0; }

        /* CONTENT */
        .judul-laporan { text-align: center; margin-bottom: 20px; font-weight: bold; font-size: 12pt; text-transform: uppercase; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th, table.data td { border: 1px solid #000; padding: 5px; vertical-align: top; }
        table.data th { background-color: #eee; text-align: center; }
        ul { padding-left: 15px; margin: 0; }
        li { margin-bottom: 4px; }
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
        REKAPITULASI SUB KEGIATAN DAN INDIKATOR <br> TAHUN {{ $tahun }}
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Program / Kegiatan</th>
                <th width="25%">Sub Kegiatan</th>
                <th width="30%">Indikator Sub Kegiatan</th>
                <th width="5%">Satuan</th>
                <th width="10%">Target</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subKegiatans as $index => $sub)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>
                        <strong>Prog:</strong> {{ $sub->kegiatan->program->nama ?? '-' }}<br><br>
                        <strong>Keg:</strong> {{ $sub->kegiatan->nama ?? '-' }}
                    </td>
                    <td>{{ $sub->nama }}</td>
                    <td>
                        @if($sub->indikators->count() > 0)
                            <ul>
                                @foreach($sub->indikators as $ind)
                                    <li>{{ $ind->keterangan }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span style="color: red; font-style: italic;">(Belum ada indikator)</span>
                        @endif
                    </td>
                    <td align="center">
                        @foreach($sub->indikators as $ind)
                            <div style="margin-bottom: 4px;">{{ $ind->satuan }}</div>
                        @endforeach
                    </td>
                    <td align="center">
                        @foreach($sub->indikators as $ind)
                            @php
                                $target = '-';
                                if($tahun == 2025) $target = $ind->target_2025;
                                elseif($tahun == 2026) $target = $ind->target_2026;
                            @endphp
                            <div style="margin-bottom: 4px;">{{ $target ?? '-' }}</div>
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Tidak ada data Sub Kegiatan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

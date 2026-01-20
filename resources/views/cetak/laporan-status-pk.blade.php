<!DOCTYPE html>
<html>
<head>
    <title>Laporan Status PK</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; margin: 0; padding: 0; }
        
        /* KOP SURAT STYLE */
        .kop-surat { width: 100%; border-bottom: 4px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .logo-img { width: 85px; height: auto; }
        .text-cell { width: 85%; text-align: center; vertical-align: middle; padding-right: 15%; }
        .text-header-1 { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .text-header-2 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 2px 0; }
        .text-address { font-size: 10pt; font-weight: normal; margin: 0; }

        /* CONTENT STYLE */
        .judul-laporan { text-align: center; margin-bottom: 15px; font-weight: bold; font-size: 12pt; text-transform: uppercase; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th, table.data td { border: 1px solid #000; padding: 6px; }
        table.data th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; color: white; display: inline-block; font-size: 10px; text-align: center;}
        .bg-green { background-color: #28a745; }
        .bg-grey { background-color: #6c757d; }
    </style>
</head>
<body>
    
    {{-- KOP SURAT RESMI --}}
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
        LAPORAN STATUS PENGISIAN PERJANJIAN KINERJA <br> TAHUN {{ $tahun }}
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Nama Pegawai</th>
                <th style="width: 35%;">Jabatan</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 15%;">Tgl Update</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawais as $index => $p)
                @php 
                    $pk = $p->jabatan?->perjanjianKinerja->first(); 
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $p->nama }}<br><small>NIP. {{ $p->nip }}</small></td>
                    <td>{{ $p->jabatan->nama ?? '-' }}</td>
                    <td style="text-align: center;">
                        @if($pk && $pk->status == 'final')
                            <span class="badge bg-green">FINAL</span>
                        @else
                            <span class="badge bg-grey">DRAFT / BELUM</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        {{ $pk ? $pk->updated_at->format('d/m/Y') : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

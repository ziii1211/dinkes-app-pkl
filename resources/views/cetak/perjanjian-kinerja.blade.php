<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cetak Perjanjian Kinerja</title>
    <style>
        /* 1. SETUP HALAMAN PDF */
        @page { 
            size: A4 portrait; 
            margin: 2cm 2cm; 
        }
        
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 11pt; 
            color: #000; 
            background: #fff; 
            margin: 0; 
            padding: 0;
            line-height: 1.3;
        }

        /* 2. KOP SURAT RESMI */
        .kop-surat { width: 100%; border-bottom: 4px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .logo-img { width: 80px; height: auto; }
        .text-cell { width: 85%; text-align: center; vertical-align: middle; padding-right: 15%; }
        .text-header-1 { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .text-header-2 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 2px 0; }
        .text-address { font-size: 10pt; font-weight: normal; margin: 0; }

        /* UTILITIES */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        /* HEADER JUDUL */
        .header-title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            line-height: 1.5;
        }

        /* TABEL UTAMA (SASARAN) */
        .table-main {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-main th, 
        .table-main td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }
        .table-main th {
            background-color: #E8E8E8; 
            text-align: center;
            font-weight: bold;
        }

        /* TABEL ANGGARAN */
        .table-budget {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 30px;
        }
        .table-budget td {
            padding: 4px 5px;
            vertical-align: top;
            border: none; 
        }
        .border-top-black {
            border-top: 1px solid #000 !important;
        }

        /* TANDA TANGAN */
        .table-signature {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: avoid; 
        }
        .table-signature td {
            border: none;
            text-align: center;
            vertical-align: top;
            padding: 0;
        }
        .row-space td {
            height: 80px;
            vertical-align: middle;
        }
        .name-underline {
            font-weight: bold;
            text-decoration: underline;
        }
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

    {{-- JUDUL --}}
    <div class="header-title">
        PERJANJIAN KINERJA TAHUN {{ $pk->tahun }}<br>
        {{ $jabatan->nama }}<br>
        DINAS KESEHATAN<br>
        PROVINSI KALIMANTAN SELATAN
    </div>

    {{-- TABEL SASARAN --}}
    <table class="table-main">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">KINERJA UTAMA</th>
                <th style="width: 45%;">INDIKATOR KINERJA</th>
                <th style="width: 15%;">TARGET</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($pk->sasarans as $sasaran)
                @php 
                    $countIndikator = $sasaran->indikators->count();
                    $rowspan = $countIndikator > 0 ? $countIndikator : 1; 
                @endphp
                
                @if($countIndikator > 0)
                    @foreach($sasaran->indikators as $index => $ind)
                        <tr>
                            {{-- Merge Cell untuk Sasaran --}}
                            @if($index === 0)
                                <td rowspan="{{ $rowspan }}" class="text-center">{{ $no++ }}.</td>
                                {{-- PERBAIKAN: Menggunakan 'sasaran' sesuai database --}}
                                <td rowspan="{{ $rowspan }}">{{ $sasaran->sasaran }}</td>
                            @endif

                            <td style="padding-left: 10px;">{{ $ind->nama_indikator }}</td>
                            <td class="text-center">
                                @php 
                                    $colTarget = $pk->tahun == 2025 ? 'target_2025' : 'target_2026';
                                    $val = $ind->$colTarget;
                                    // Format angka target (hilangkan desimal .00)
                                    $val = (float)$val == (int)$val ? (int)$val : $val;
                                @endphp
                                {{ $val }} {{ $ind->satuan }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    {{-- Jika tidak ada indikator, tetap tampilkan baris sasaran --}}
                    <tr>
                        <td class="text-center">{{ $no++ }}.</td>
                        {{-- PERBAIKAN: Menggunakan 'sasaran' sesuai database --}}
                        <td>{{ $sasaran->sasaran }}</td>
                        <td>-</td>
                        <td class="text-center">-</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    {{-- TABEL ANGGARAN --}}
    <table class="table-budget">
        <thead>
            <tr>
                <th style="text-align: left; width: 70%; border:none; padding-bottom: 10px;">Program/Kegiatan/Sub Kegiatan</th>
                <th style="text-align: right; width: 30%; border:none; padding-bottom: 10px;">Anggaran</th>
            </tr>
        </thead>
        <tbody>
            @php $totalAnggaran = 0; @endphp
            @foreach($pk->anggarans as $idx => $anggaran)
                @php $totalAnggaran += $anggaran->anggaran; @endphp
                <tr>
                    <td>
                        {{ $idx + 1 }}. 
                        @if($anggaran->subKegiatan)
                            {{ $anggaran->subKegiatan->nama }}
                        @else
                            {{ preg_replace('/^[\d\.]+\s*/', '', $anggaran->nama_program_kegiatan ?? '-') }}
                        @endif
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($anggaran->anggaran, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
            
            <tr style="font-weight: bold;">
                <td class="text-center" style="padding-top: 10px;">JUMLAH</td>
                <td class="text-right border-top-black" style="padding-top: 10px;">
                    Rp {{ number_format($totalAnggaran, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <table class="table-signature">
        <tr>
            {{-- PIHAK PERTAMA --}}
            <td style="width: 50%; padding-bottom: 0;">
                <p class="font-bold" style="margin-bottom: 5px;">PIHAK PERTAMA,</p>
                <p class="font-bold uppercase" style="margin-top: 0;">
                    {{ $jabatan->nama }}
                </p>
            </td>

            {{-- PIHAK KEDUA --}}
            <td style="width: 50%; padding-bottom: 0;">
                <p class="font-bold" style="margin-bottom: 5px;">PIHAK KEDUA,</p>
                @if($is_kepala_dinas)
                    <p class="font-bold uppercase" style="margin-top: 0;">
                        GUBERNUR KALIMANTAN SELATAN
                    </p>
                @elseif(isset($atasan_jabatan) && $atasan_jabatan)
                    <p class="font-bold uppercase" style="margin-top: 0;">
                        {{ $atasan_jabatan->nama }}
                    </p>
                @else
                    <p class="font-bold uppercase" style="margin-top: 0;">
                        (JABATAN ATASAN)
                    </p>
                @endif
            </td>
        </tr>

        <tr class="row-space">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            {{-- NAMA PIHAK PERTAMA --}}
            <td>
                @if($pegawai)
                    <p class="name-underline" style="margin: 0;">{{ $pegawai->nama }}</p>
                    <p style="margin: 0;">NIP. {{ $pegawai->nip }}</p>
                @else
                    <p class="name-underline" style="margin: 0;">(Belum Ada Pejabat)</p>
                    <p style="margin: 0;">NIP. -</p>
                @endif
            </td>

            {{-- NAMA PIHAK KEDUA --}}
            <td>
                @if($is_kepala_dinas)
                    <p class="name-underline" style="margin: 0;">H. MUHIDIN</p>
                @elseif($atasan_pegawai)
                    <p class="name-underline" style="margin: 0;">{{ $atasan_pegawai->nama }}</p>
                    <p style="margin: 0;">NIP. {{ $atasan_pegawai->nip }}</p>
                @else
                    <p class="name-underline" style="margin: 0;">(Atasan Belum Diset)</p>
                    <p style="margin: 0;">NIP. -</p>
                @endif
            </td>
        </tr>
    </table>

</body>
</html>
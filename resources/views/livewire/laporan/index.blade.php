
<div class="min-h-screen space-y-6" x-data="{ activeTab: @entangle('activeTab') }">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate-fade-in-down">
        <div>
        </div>
    </div>

    {{-- Main Split Layout --}}
    <div class="flex flex-col md:flex-row gap-6 items-start">
        
        {{-- BAGIAN KIRI: DAFTAR MENU LAPORAN --}}
        <div class="w-full md:w-1/3 lg:w-1/4 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden sticky top-24">
            <div class="p-4 bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori Laporan</span>
            </div>
            <nav class="flex flex-col p-2 space-y-1">
                
                {{-- 1. Perjanjian Kinerja --}}
                <button @click="activeTab = 'pk'" 
                    :class="activeTab === 'pk' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 w-full text-left">
                    <svg class="w-5 h-5 mr-3 transition-colors" :class="activeTab === 'pk' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Perjanjian Kinerja
                </button>

                {{-- 2. Pengaturan Kinerja (Status PK) --}}
                <button @click="activeTab = 'status_pk'" 
                    :class="activeTab === 'status_pk' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 w-full text-left">
                    <svg class="w-5 h-5 mr-3 transition-colors" :class="activeTab === 'status_pk' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Pengaturan Kinerja
                </button>

                {{-- 3. Menu Sub Kegiatan --}}
                <button @click="activeTab = 'sub_kegiatan'" 
                    :class="activeTab === 'sub_kegiatan' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 w-full text-left">
                    <svg class="w-5 h-5 mr-3 transition-colors" :class="activeTab === 'sub_kegiatan' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Sub Kegiatan
                </button>

                {{-- 4. Pengukuran Bulanan --}}
                <button @click="activeTab = 'bulanan'" 
                    :class="activeTab === 'bulanan' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 w-full text-left">
                    <svg class="w-5 h-5 mr-3 transition-colors" :class="activeTab === 'bulanan' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Pengukuran Bulanan
                </button>

                {{-- 5. Detail & Top Performer --}}
                <button @click="activeTab = 'top_performer'" 
                    :class="activeTab === 'top_performer' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 w-full text-left">
                    <svg class="w-5 h-5 mr-3 transition-colors" :class="activeTab === 'top_performer' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    Top Performer
                </button>
            </nav>
        </div>

        {{-- BAGIAN KANAN: PANEL FILTER & AKSI --}}
        <div class="w-full md:w-2/3 lg:w-3/4 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 min-h-[400px]">
            
            {{-- TAB 1: PERJANJIAN KINERJA --}}
            <div x-show="activeTab === 'pk'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="border-b border-gray-100 dark:border-slate-700 pb-4 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Laporan Perjanjian Kinerja</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Cetak dokumen Perjanjian Kinerja (PK) individu pegawai.</p>
                </div>
                
                <div class="space-y-4 max-w-lg">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pilih Pegawai</label>
                        <select wire:model="selectedPegawaiId" class="w-full rounded-lg border-gray-300 dark:bg-slate-700 dark:border-slate-600 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $p) 
                                <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->jabatan->nama ?? 'Tanpa Jabatan' }}</option> 
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Tahun Anggaran</label>
                        <select wire:model="year" class="w-full rounded-lg border-gray-300 dark:bg-slate-700 dark:border-slate-600">
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>
                    </div>

                    <div class="pt-4">
                        <button wire:click="cetakPK" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg shadow-blue-500/30 transition-all focus:ring-4 focus:ring-blue-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Laporan PK
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB 2: STATUS PENGISIAN PK (Pengaturan Kinerja) --}}
            <div x-show="activeTab === 'status_pk'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="border-b border-gray-100 dark:border-slate-700 pb-4 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Status Pengaturan Kinerja</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Daftar pegawai yang sudah FINAL atau masih DRAFT dalam pengisian PK.</p>
                </div>
                
                <div class="space-y-4 max-w-lg">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Filter Status</label>
                        <select wire:model="filterStatus" class="w-full rounded-lg border-gray-300 dark:bg-slate-700 dark:border-slate-600">
                            <option value="all">Semua Status</option>
                            <option value="final">Sudah Final (Selesai)</option>
                            <option value="draft">Masih Draft (Belum Selesai)</option>
                        </select>
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg p-4">
                        <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center gap-2">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Laporan ini menampilkan rekapitulasi pegawai berdasarkan status dokumen PK.
                        </p>
                    </div>

                    <div class="pt-4">
                        <button wire:click="cetakStatusPK" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg shadow-blue-500/30 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Cetak Status PK
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB 3: SUB KEGIATAN --}}
            <div x-show="activeTab === 'sub_kegiatan'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="border-b border-gray-100 dark:border-slate-700 pb-4 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Laporan Sub Kegiatan</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Rekapitulasi Indikator Sub Kegiatan dan target tahunan.</p>
                </div>
                
                <div class="space-y-4 max-w-lg">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Tahun</label>
                         <select wire:model="year" class="w-full rounded-lg border-gray-300 dark:bg-slate-700 dark:border-slate-600">
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>
                    </div>

                    <div class="pt-4">
                        <button wire:click="cetakSubKegiatan" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg shadow-blue-500/30 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Rekap Sub Kegiatan
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB 4: PENGUKURAN BULANAN --}}
            <div x-show="activeTab === 'bulanan'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="border-b border-gray-100 dark:border-slate-700 pb-4 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Laporan Kinerja Bulanan</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Cetak capaian realisasi fisik dan kinerja per bulan.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-lg">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Bulan</label>
                        <select wire:model="month" class="w-full rounded-lg border-gray-300 dark:bg-slate-700 dark:border-slate-600">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Tahun</label>
                        <select wire:model="year" class="w-full rounded-lg border-gray-300 dark:bg-slate-700 dark:border-slate-600">
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>
                    </div>
                </div>

                <div class="pt-6">
                    <button wire:click="cetakBulanan" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg shadow-blue-500/30 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Cetak Laporan Bulanan
                    </button>
                </div>
            </div>

            {{-- TAB 5: TOP PERFORMER --}}
            <div x-show="activeTab === 'top_performer'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="border-b border-gray-100 dark:border-slate-700 pb-4 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Detail & Top Performer</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">
                        Urutan pegawai berdasarkan capaian tertinggi ke terendah.
                    </p>
                </div>
                
                <div class="space-y-4 max-w-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Periode Bulan</label>
                            <select wire:model="month" class="w-full rounded-lg border-gray-300 dark:bg-slate-700 dark:border-slate-600">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Tahun</label>
                            <select wire:model="year" class="w-full rounded-lg border-gray-300 dark:bg-slate-700 dark:border-slate-600">
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800 rounded-lg p-4 flex gap-3">
                        <svg class="w-6 h-6 text-yellow-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <div>
                            <p class="text-sm text-yellow-800 dark:text-yellow-200 font-bold">Informasi Sistem:</p>
                            <p class="text-xs text-yellow-700 dark:text-yellow-300 mt-1">
                                Sistem akan menghitung rata-rata capaian seluruh indikator kinerja pegawai pada bulan yang dipilih, lalu mengurutkannya dari Ranking 1 ke bawah.
                            </p>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button wire:click="cetakTopPerformer" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg shadow-blue-500/30 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Cetak Peringkat
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
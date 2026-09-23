<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php
        $data = $this->getMatrixData();
        $bulanNamaArray = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $totalSiswaCount = count($data['siswas']);
        $totalMapelCount = count($data['mapelList']);
    ?>

    <!-- HERO HEADER CONTAINER -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-teal-900 via-teal-800 to-slate-900 text-white p-6 shadow-xl border border-teal-700/50 mb-6">
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
            <svg class="w-80 h-80 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
            </svg>
        </div>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 relative z-10">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-500/20 border border-teal-400/30 text-teal-200 text-xs font-semibold uppercase tracking-wider mb-2">
                    <svg class="w-3.5 h-3.5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Format Excel Matrix Presensi
                </div>
                <h2 class="text-2xl font-black tracking-tight text-white flex items-center gap-2">
                    Rekap Presensi Bulanan
                    <span class="text-teal-300 font-normal text-lg">(<?php echo e($bulanNamaArray[$this->bulan] ?? ''); ?> <?php echo e($this->tahun); ?>)</span>
                </h2>
                <p class="text-xs text-teal-100/80 mt-1">
                    Format matriks presensi terstruktur per mata pelajaran (Pertemuan 1–4) & siswa. Sesuai standar laporan bimbel.
                </p>
            </div>

            <!-- Stats badges -->
            <div class="flex items-center gap-3">
                <div class="px-4 py-2.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 text-center min-w-[100px]">
                    <span class="block text-xl font-black text-amber-300"><?php echo e($totalSiswaCount); ?></span>
                    <span class="text-[10px] uppercase font-semibold text-teal-100 tracking-wider">Total Siswa</span>
                </div>
                <div class="px-4 py-2.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 text-center min-w-[100px]">
                    <span class="block text-xl font-black text-teal-300"><?php echo e($totalMapelCount); ?></span>
                    <span class="text-[10px] uppercase font-semibold text-teal-100 tracking-wider">Mata Pelajaran</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER & TOOLBAR BAR -->
    <div class="bg-white dark:bg-slate-900 rounded-xl p-4 shadow-sm border border-slate-200 dark:border-slate-800 mb-5">
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
            
            <!-- Filter Controls -->
            <div class="flex flex-wrap items-center gap-3">
                
                <!-- Search Input -->
                <div class="relative min-w-[200px] flex-1 sm:flex-none">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="searchSiswa" placeholder="Cari nama siswa..." 
                           class="w-full pl-9 pr-3 py-2 border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-lg text-xs font-medium focus:ring-teal-500 focus:border-teal-500 text-slate-800 dark:text-slate-200 placeholder-slate-400"/>
                </div>

                <!-- Filter Bulan -->
                <div class="flex items-center gap-1.5">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Bulan:</span>
                    <select wire:model.live="bulan" class="border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-lg text-xs font-semibold py-2 px-3 focus:ring-teal-500 focus:border-teal-500 text-slate-800 dark:text-slate-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $bulanNamaArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($num); ?>"><?php echo e($nama); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div class="flex items-center gap-1.5">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Tahun:</span>
                    <select wire:model.live="tahun" class="border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-lg text-xs font-semibold py-2 px-3 focus:ring-teal-500 focus:border-teal-500 text-slate-800 dark:text-slate-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [2024, 2025, 2026, 2027]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($t); ?>"><?php echo e($t); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <!-- Filter Kelompok -->
                <div class="flex items-center gap-1.5">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Kelompok:</span>
                    <select wire:model.live="kelompokId" class="border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-lg text-xs font-semibold py-2 px-3 focus:ring-teal-500 focus:border-teal-500 text-slate-800 dark:text-slate-200 max-w-[200px]">
                        <option value="">Semua Kelompok</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $data['allKelompoks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($k->id); ?>"><?php echo e($k->nama_kelompok); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- Export Excel Action Button -->
            <div>
                <button wire:click="exportExcel" type="button" 
                        class="w-full lg:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-xs rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                    <svg class="w-4 h-4 text-emerald-100" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 20V4h7v5h5v11H6zm10.5-5.5l-2.1-2.1 2.1-2.1-1.4-1.4-2.1 2.1-2.1-2.1-1.4 1.4 2.1 2.1-2.1 2.1 1.4 1.4 2.1-2.1 2.1 2.1 1.4-1.4z"/>
                    </svg>
                    Download Excel (.xlsx)
                </button>
            </div>

        </div>
    </div>

    <!-- STATUS COLOR LEGEND BAR -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4 bg-slate-50 dark:bg-slate-900/60 p-3 rounded-xl border border-slate-200 dark:border-slate-800 text-xs">
        <div class="flex flex-wrap items-center gap-2 font-semibold text-slate-600 dark:text-slate-400">
            <span class="text-slate-800 dark:text-slate-200 font-extrabold mr-1">Status Kehadiran:</span>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-white font-black bg-emerald-600 shadow-sm">
                HADIR
            </span>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-white font-black bg-amber-600 shadow-sm">
                SAKIT
            </span>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-white font-black bg-blue-600 shadow-sm">
                IZIN
            </span>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-white font-black bg-red-600 shadow-sm">
                ALPA
            </span>
            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-slate-500 dark:text-slate-400 bg-slate-200 dark:bg-slate-800 font-semibold border border-slate-300 dark:border-slate-700">
                - (Belum Ada)
            </span>
        </div>
        <span class="text-[11px] font-medium text-slate-400">
            *Setiap mata pelajaran memiliki 4 slot pertemuan (P1–P4) per bulan.
        </span>
    </div>

    <!-- MATRIX TABLE CONTAINER -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto max-h-[68vh] scrollbar-thin scrollbar-thumb-teal-500">
            <table class="w-full text-xs text-center border-collapse">
                
                <!-- STICKY HEADER -->
                <thead class="sticky top-0 z-20 shadow-md">
                    
                    <!-- Row 1: Main Header -->
                    <tr class="bg-slate-900 text-white font-black border-b border-slate-700">
                        <th class="p-3 border-r border-slate-700 bg-slate-900 w-12 sticky left-0 z-30 shadow-r">
                            NO
                        </th>
                        <th class="p-3 border-r border-slate-700 text-left bg-slate-900 min-w-[200px] sticky left-12 z-30 shadow-r">
                            NAMA SISWA
                        </th>
                        <th colspan="<?php echo e(count($data['mapelList']) * 4); ?>" class="p-3 bg-gradient-to-r from-teal-800 to-slate-800 text-teal-100 uppercase tracking-wider text-sm font-extrabold border-b border-teal-700">
                            REKAP PRESENSI MATRIX - BULAN <?php echo e(strtoupper($bulanNamaArray[$this->bulan] ?? '')); ?> <?php echo e($this->tahun); ?>

                        </th>
                    </tr>

                    <!-- Row 2: Mata Pelajaran Group Headers -->
                    <tr class="bg-teal-900 text-white border-b border-teal-800">
                        <th class="p-2 border-r border-slate-700 bg-slate-900 sticky left-0 z-30"></th>
                        <th class="p-2 border-r border-slate-700 bg-slate-900 sticky left-12 z-30"></th>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $data['mapelList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <th colspan="4" class="p-2.5 font-black text-teal-100 bg-teal-800/90 border-r-2 border-slate-700 uppercase tracking-wide border-t border-teal-700">
                                <span class="inline-block bg-teal-950/60 px-3 py-1 rounded-full border border-teal-500/30 text-teal-200">
                                    <?php echo e($m['nama']); ?>

                                </span>
                            </th>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tr>

                    <!-- Row 3: Pertemuan 1, 2, 3, 4 -->
                    <tr class="bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold border-b border-slate-300 dark:border-slate-700">
                        <th class="p-2 border-r border-slate-300 dark:border-slate-700 bg-slate-200 dark:bg-slate-800 sticky left-0 z-30"></th>
                        <th class="p-2 border-r border-slate-300 dark:border-slate-700 bg-slate-200 dark:bg-slate-800 sticky left-12 z-30"></th>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $data['mapelList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <th class="p-1.5 border-r border-slate-200 dark:border-slate-700 w-14 bg-slate-200/60 dark:bg-slate-800">P1</th>
                            <th class="p-1.5 border-r border-slate-200 dark:border-slate-700 w-14 bg-slate-200/60 dark:bg-slate-800">P2</th>
                            <th class="p-1.5 border-r border-slate-200 dark:border-slate-700 w-14 bg-slate-200/60 dark:bg-slate-800">P3</th>
                            <th class="p-1.5 border-r-2 border-slate-400 dark:border-slate-600 w-14 bg-slate-300/60 dark:bg-slate-700 text-slate-900 dark:text-white font-extrabold">P4</th>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tr>
                </thead>

                <!-- TABLE DATA ROWS -->
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 font-medium">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $data['siswas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="hover:bg-teal-50/50 dark:hover:bg-slate-800/60 transition-colors <?php echo e($index % 2 === 0 ? 'bg-white dark:bg-slate-900' : 'bg-slate-50/40 dark:bg-slate-900/40'); ?>">
                            
                            <!-- Index NO -->
                            <td class="p-2.5 font-bold text-slate-500 dark:text-slate-400 border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 sticky left-0 z-10 shadow-sm">
                                <?php echo e($index + 1); ?>

                            </td>

                            <!-- Nama Siswa Sticky Left -->
                            <td class="p-2.5 font-bold text-slate-900 dark:text-white text-left border-r-2 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 sticky left-12 z-10 truncate max-w-[220px] shadow-sm" title="<?php echo e($s->nama_lengkap); ?>">
                                <span class="hover:text-teal-600 transition-colors cursor-default">
                                    <?php echo e($s->nama_lengkap); ?>

                                </span>
                            </td>

                            <!-- Mapel Matrix Columns -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $data['mapelList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mId => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $sessions = $data['sessionsByMapel'][$mId] ?? [];
                                ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($p = 0; $p < 4; $p++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php
                                        $jadwal = $sessions[$p] ?? null;
                                        $status = '-';
                                        $badgeClass = 'text-slate-400 bg-slate-100/70 dark:bg-slate-800/40 font-normal';

                                        if ($jadwal) {
                                            $st = strtolower($data['presensis'][$s->id][$jadwal->id] ?? '');
                                            if ($st === 'hadir') {
                                                $status = 'HADIR';
                                                $badgeClass = 'bg-emerald-600 text-white font-extrabold shadow-sm';
                                            } elseif ($st === 'sakit') {
                                                $status = 'SAKIT';
                                                $badgeClass = 'bg-amber-600 text-white font-extrabold shadow-sm';
                                            } elseif ($st === 'izin') {
                                                $status = 'IZIN';
                                                $badgeClass = 'bg-blue-600 text-white font-extrabold shadow-sm';
                                            } elseif ($st === 'alpa') {
                                                $status = 'ALPA';
                                                $badgeClass = 'bg-red-600 text-white font-extrabold shadow-sm';
                                            }
                                        }
                                    ?>
                                    <td class="p-1 border-r border-slate-200 dark:border-slate-800 <?php echo e($p === 3 ? 'border-r-2 border-r-slate-400 dark:border-r-slate-600' : ''); ?>">
                                        <span class="inline-block w-full py-1.5 px-1 rounded-md text-[10px] tracking-tight transition-transform transform hover:scale-105 <?php echo e($badgeClass); ?>">
                                            <?php echo e($status); ?>

                                        </span>
                                    </td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="<?php echo e(2 + (count($data['mapelList']) * 4)); ?>" class="p-12 text-center text-slate-500 dark:text-slate-400 bg-slate-50/50 dark:bg-slate-900/50">
                                <div class="max-w-xs mx-auto text-center">
                                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-bold text-slate-700 dark:text-slate-300 text-sm">Tidak ada siswa / presensi ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba ubah kata kunci pencarian, bulan, atau filter kelompok di atas.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH C:\Users\DELL\Downloads\Kuliah\Projek-Bimbel\pelita-ilmu\resources\views/filament/pages/rekap-presensi-matrix.blade.php ENDPATH**/ ?>
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="p-8 w-full space-y-8">
        <!-- Page Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-neutral-900 tracking-tight">Competitor Intelligence & AI Gap Analysis</h1>
                <p class="text-xs text-neutral-500 mt-1">Benchmarking statistik performa akun Anda vs kompetitor dan deteksi peluang topik baru.</p>
            </div>
            <div class="flex items-center space-x-3">
                <form action="<?php echo e(route('competitors.auto-hermes')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-3 py-1.5 rounded uppercase tracking-wider transition shadow-sm">
                        🤖 Hermes AI Agent: Run Niche Analysis
                    </button>
                </form>
                <span class="text-xs bg-neutral-900 text-white px-3 py-1.5 rounded font-mono font-medium shadow-sm">
                    Hermes AI Agent Engine
                </span>
            </div>
        </div>

        <?php if(session('status')): ?>
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs px-4 py-3 rounded flex items-center justify-between">
                <span><?php echo e(session('status')); ?></span>
                <span class="font-bold cursor-pointer" onclick="this.parentElement.remove()">×</span>
            </div>
        <?php endif; ?>

        <!-- My Account Summary Bar vs Competitors -->
        <div class="bg-neutral-900 text-white rounded-lg p-6 mb-8 shadow-sm">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-4 mb-4">
                <div>
                    <span class="text-[10px] uppercase font-semibold tracking-widest text-emerald-400">Akun Anda (Benchmark Baseline)</span>
                    <h2 class="text-lg font-bold text-white">@rifjanj</h2>
                </div>
                <div class="flex items-center space-x-6 text-xs text-neutral-300 font-mono">
                    <div>Followers: <strong class="text-white"><?php echo e(number_format($insights['followers_count'] ?? 755)); ?></strong></div>
                    <div>Engagement Rate: <strong class="text-emerald-400 font-bold"><?php echo e($insights['engagement_rate'] ?? '12.50%'); ?></strong></div>
                    <div>Avg Interactions: <strong class="text-white"><?php echo e(number_format($insights['total_interactions'] ?? 225)); ?></strong></div>
                </div>
            </div>

            <!-- Form Tambah Akun Kompetitor -->
            <form action="<?php echo e(route('competitors.store')); ?>" method="POST" class="flex items-center space-x-3">
                <?php echo csrf_field(); ?>
                <input type="text" name="username" required placeholder="Masukkan Username Kompetitor (misal: @kompetitor_brand)" class="flex-1 text-xs px-3.5 py-2.5 bg-neutral-800 border border-neutral-700 text-white rounded focus:border-white focus:outline-none">
                <button type="submit" class="px-4 py-2.5 bg-white text-neutral-900 text-xs font-bold uppercase tracking-wider rounded hover:bg-neutral-200 transition">
                    + Tambah Kompetitor
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Benchmark Matrix Table -->
            <div class="lg:col-span-2 bg-white border border-neutral-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-neutral-900 mb-4 pb-3 border-b border-neutral-100 flex items-center justify-between">
                    <span>📊 Matriks Benchmark Performa Kompetitor</span>
                    <span class="text-xs text-neutral-400 font-normal"><?php echo e(count($competitors)); ?> Akun Dipantau</span>
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-neutral-200 text-[11px] font-semibold text-neutral-500 uppercase tracking-wider">
                                <th class="pb-3">Username</th>
                                <th class="pb-3">Followers</th>
                                <th class="pb-3">Engagement Rate</th>
                                <th class="pb-3">Avg Likes</th>
                                <th class="pb-3">Avg Comments</th>
                                <th class="pb-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100 text-xs">
                            <!-- Baseline User Row -->
                            <tr class="bg-emerald-50/50 font-medium">
                                <td class="py-3 font-bold text-neutral-900">@rifjanj <span class="text-[9px] bg-emerald-600 text-white px-1.5 py-0.5 rounded ml-1">ANDA</span></td>
                                <td class="py-3 font-mono"><?php echo e(number_format($insights['followers_count'] ?? 755)); ?></td>
                                <td class="py-3 font-mono font-bold text-emerald-600"><?php echo e($insights['engagement_rate'] ?? '12.50%'); ?></td>
                                <td class="py-3 font-mono"><?php echo e(number_format($insights['total_likes'] ?? 223)); ?></td>
                                <td class="py-3 font-mono"><?php echo e(number_format($insights['total_comments'] ?? 2)); ?></td>
                                <td class="py-3 text-right text-neutral-400">-</td>
                            </tr>

                            <?php $__empty_1 = true; $__currentLoopData = $competitors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-neutral-50 transition">
                                    <td class="py-3 font-semibold text-neutral-800"><?php echo e($comp->username); ?></td>
                                    <td class="py-3 font-mono"><?php echo e(number_format($comp->followers_count)); ?></td>
                                    <td class="py-3 font-mono font-semibold text-neutral-900"><?php echo e(number_format($comp->engagement_rate, 2)); ?>%</td>
                                    <td class="py-3 font-mono"><?php echo e(number_format($comp->avg_likes)); ?></td>
                                    <td class="py-3 font-mono"><?php echo e(number_format($comp->avg_comments)); ?></td>
                                    <td class="py-3 text-right">
                                        <form action="<?php echo e(route('competitors.destroy', $comp->id)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-medium">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-xs text-neutral-400">
                                        Belum ada kompetitor yang ditambahkan. Masukkan username kompetitor di atas untuk memulai analisis.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- AI Content Gap Analysis Panel -->
            <div class="bg-white border border-neutral-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-neutral-900 mb-4 pb-3 border-b border-neutral-100 flex items-center justify-between">
                    <span>💡 AI Content Gap Analysis</span>
                    <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded font-mono">Opportunity AI</span>
                </h3>

                <div class="bg-neutral-50 p-4 rounded border border-neutral-100 text-xs text-neutral-700 whitespace-pre-line leading-relaxed">
                    <?php echo nl2br(e($gapAnalysis)); ?>

                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /var/www/resources/views/competitors.blade.php ENDPATH**/ ?>
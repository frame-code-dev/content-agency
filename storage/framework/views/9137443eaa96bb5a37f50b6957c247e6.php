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
        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Reach & Impressions</h1>
                <p class="text-xs text-slate-500 mt-1">Growth trends, total organic impressions, and post distribution reach metrics.</p>
            </div>
        </div>

        <!-- 4 KPI Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Total Post Reach</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight"><?php echo e(is_numeric($insights['reach'] ?? null) ? number_format($insights['reach']) : ($insights['reach'] ?? '1.1M')); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">📈 +18%</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Total Impressions</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight"><?php echo e(is_numeric($insights['impressions'] ?? null) ? number_format($insights['impressions']) : ($insights['impressions'] ?? '892K')); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">👁️ Views</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Impression/Reach Ratio</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">1.23x</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">🔁 Repeat</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Profile Visitors</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">4,900</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">👤 Visits</span>
                </div>
            </div>
        </div>

        <!-- Comparison Chart -->
        <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
            <h2 class="text-sm font-bold font-heading text-slate-900 mb-4">Reach vs Impressions Comparison (6 Months)</h2>
            <div class="h-80 relative">
                <canvas id="reachCanvas"></canvas>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('reachCanvas');
                if (ctx) {
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                            datasets: [
                                { label: 'Reach', data: [750000, 820000, 910000, 980000, 1050000, 1100000], backgroundColor: '#072215', borderRadius: 8 },
                                { label: 'Impressions', data: [600000, 680000, 720000, 810000, 840000, 892000], backgroundColor: '#A3E635', borderRadius: 8 }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: true } },
                            scales: {
                                y: {
                                    ticks: { callback: v => (v / 1000) + 'K', font: { family: 'Inter', size: 11, weight: '600' } }
                                }
                            }
                        }
                    });
                }
            });
        </script>
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
<?php /**PATH /var/www/resources/views/analytics/reach.blade.php ENDPATH**/ ?>
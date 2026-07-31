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
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Campaign Performance</h1>
                <p class="text-xs text-slate-500 mt-1">Track content marketing campaigns, ROI, and SPK prioritization scores.</p>
            </div>
            <a href="<?php echo e(route('planner.index')); ?>" class="px-5 py-2.5 bg-[#072215] text-[#A3E635] text-xs font-bold rounded-2xl shadow transition hover:scale-105">
                + Launch New Campaign Plan
            </a>
        </div>

        <!-- 4 Summary KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Active Campaigns</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight"><?php echo e(count($plans)); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">🚀 Active</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Scheduled Posts</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight"><?php echo e($plans->where('status', 'scheduled')->count()); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">📅 Queued</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Avg SPK Decision Score</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight"><?php echo e(number_format($plans->avg('spk_score'), 2)); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">🎯 SAW</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Highest Priority Topic</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-lg font-bold font-heading text-slate-900 truncate max-w-[140px]"><?php echo e($plans->first()->topic ?? 'AI Automation'); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">⭐ Top</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
            <h2 class="text-base font-bold font-heading text-slate-900 mb-4">Active Content Campaigns Table</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider">
                            <th class="py-3 px-4">Campaign Topic</th>
                            <th class="py-3 px-4">Concept</th>
                            <th class="py-3 px-4">Tone</th>
                            <th class="py-3 px-4">SPK Score</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3.5 px-4 font-bold text-slate-900"><?php echo e($plan->topic); ?></td>
                                <td class="py-3.5 px-4 max-w-sm truncate"><?php echo e($plan->concept); ?></td>
                                <td class="py-3.5 px-4"><?php echo e($plan->tone); ?></td>
                                <td class="py-3.5 px-4 text-emerald-600 font-mono font-bold"><?php echo e($plan->spk_score); ?></td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase <?php echo e($plan->status === 'scheduled' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'); ?>">
                                        <?php echo e($plan->status); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 font-medium">No content campaigns recorded yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
<?php /**PATH /var/www/resources/views/analytics/campaigns.blade.php ENDPATH**/ ?>
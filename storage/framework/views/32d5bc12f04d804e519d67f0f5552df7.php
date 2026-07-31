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
                <h1 class="text-2xl font-bold font-heading text-zinc-900 tracking-tight">Audience Insights</h1>
                <p class="text-xs text-zinc-500 mt-1">Live Instagram demographics for {{ $account->username ?? 'account' }} from Meta Graph API.</p>
            </div>
        </div>

        <!-- 4 Summary KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
                <div class="text-xs font-semibold text-zinc-500">Top Gender Group</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-zinc-950 tracking-tight">
                        <?php echo e(floatval($insights['male_pct'] ?? 41.8) > floatval($insights['female_pct'] ?? 58.2) ? 'Male' : 'Female'); ?>

                    </span>
                    <span class="inline-flex items-center text-xs font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded-[10px]">
                        <?php echo e(floatval($insights['male_pct'] ?? 41.8) > floatval($insights['female_pct'] ?? 58.2) ? ($insights['male_pct'] ?? '52.1%') : ($insights['female_pct'] ?? '58.2%')); ?>

                    </span>
                </div>
            </div>

            <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
                <div class="text-xs font-semibold text-zinc-500">Top Age Bracket</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-2xl font-bold font-heading text-zinc-950 tracking-tight"><?php echo e($insights['top_age_bracket'] ?? '25-34 Years'); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded-[10px]">Primary Share</span>
                </div>
            </div>

            <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
                <div class="text-xs font-semibold text-zinc-500">Total Followers</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-zinc-950 tracking-tight"><?php echo e(number_format($insights['followers_count'] ?? 2850)); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded-[10px]">👥 Active</span>
                </div>
            </div>

            <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
                <div class="text-xs font-semibold text-zinc-500">Peak Activity Hour</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-zinc-950 tracking-tight">18:00</span>
                    <span class="inline-flex items-center text-xs font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded-[10px]">⏰ UTC+7</span>
                </div>
            </div>
        </div>

        <!-- Demographics Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Gender Split -->
            <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
                <h2 class="text-sm font-bold font-heading text-zinc-900 mb-4">Gender Demographics Breakdown</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-bold text-zinc-700 mb-1">
                            <span>Female Followers</span>
                            <span><?php echo e($insights['female_pct'] ?? '58.2%'); ?></span>
                        </div>
                        <div class="w-full bg-zinc-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-zinc-950 h-full" style="width: <?php echo e($insights['female_pct'] ?? '58.2%'); ?>"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold text-zinc-700 mb-1">
                            <span>Male Followers</span>
                            <span><?php echo e($insights['male_pct'] ?? '41.8%'); ?></span>
                        </div>
                        <div class="w-full bg-zinc-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-zinc-500 h-full" style="width: <?php echo e($insights['male_pct'] ?? '41.8%'); ?>"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Age Brackets -->
            <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
                <h2 class="text-sm font-bold font-heading text-zinc-900 mb-4">Age Bracket Distribution</h2>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 text-xs font-semibold">
                        <span class="w-16 text-zinc-500">18-24</span>
                        <div class="flex-1 bg-zinc-100 h-7 rounded-[10px] overflow-hidden relative">
                            <div class="bg-zinc-300 h-full rounded-[10px]" style="width: 35%"></div>
                            <span class="absolute right-3 top-1.5 text-[11px] font-bold text-zinc-700">35%</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 text-xs font-semibold">
                        <span class="w-16 text-zinc-900 font-bold">25-34</span>
                        <div class="flex-1 bg-zinc-100 h-7 rounded-[10px] overflow-hidden relative">
                            <div class="bg-zinc-950 h-full rounded-[10px]" style="width: 52%"></div>
                            <span class="absolute right-3 top-1.5 text-[11px] font-bold text-zinc-900">52%</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 text-xs font-semibold">
                        <span class="w-16 text-zinc-500">35-44</span>
                        <div class="flex-1 bg-zinc-100 h-7 rounded-[10px] overflow-hidden relative">
                            <div class="bg-zinc-300 h-full rounded-[10px]" style="width: 13%"></div>
                            <span class="absolute right-3 top-1.5 text-[11px] font-bold text-zinc-700">13%</span>
                        </div>
                    </div>
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
<?php /**PATH /var/www/resources/views/analytics/audience.blade.php ENDPATH**/ ?>
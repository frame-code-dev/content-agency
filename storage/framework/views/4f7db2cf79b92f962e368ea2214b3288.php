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
        <!-- Header Row -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-zinc-900 tracking-tight">Engagement Analytics</h1>
                <p class="text-xs text-zinc-500 mt-1">Real-time interaction trends, engagement rates, comment distribution, and audience activity patterns.</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="px-4 py-2 bg-white border border-zinc-200 rounded-[10px] shadow-sm text-xs font-bold text-zinc-800 flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-zinc-950"></span>
                    <span>Engagement Rate: <?php echo e($insights['engagement_rate'] ?? '6.48%'); ?></span>
                </div>
            </div>
        </div>

        <!-- 4 KPI Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
                <div class="text-xs font-semibold text-zinc-500">Average Engagement Rate</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-zinc-950 tracking-tight"><?php echo e($insights['engagement_rate'] ?? '6.48%'); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded-[10px]">↑ High</span>
                </div>
            </div>

            <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
                <div class="text-xs font-semibold text-zinc-500">Total Likes</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-zinc-950 tracking-tight"><?php echo e(number_format(array_sum(array_column($posts, 'like_count')))); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded-[10px]">❤️ Active</span>
                </div>
            </div>

            <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
                <div class="text-xs font-semibold text-zinc-500">Total Comments</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-zinc-950 tracking-tight"><?php echo e(number_format(array_sum(array_column($posts, 'comments_count')))); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded-[10px]">💬 Active</span>
                </div>
            </div>

            <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
                <div class="text-xs font-semibold text-zinc-500">Estimated Reach</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-zinc-950 tracking-tight"><?php echo e(is_numeric($insights['reach'] ?? null) ? number_format($insights['reach']) : ($insights['reach'] ?? '1.1M')); ?></span>
                    <span class="inline-flex items-center text-xs font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded-[10px]">📈 +14%</span>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Engagement Rate Trend Chart (8 cols) -->
            <div class="lg:col-span-8 bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold font-heading text-zinc-900">Engagement Rate History Trend</h3>
                    <span class="text-xs text-zinc-400 font-semibold font-mono">Last 6 Months</span>
                </div>
                <div class="relative w-full h-[320px]">
                    <canvas id="engagementRateCanvas"></canvas>
                </div>
            </div>

            <!-- Interactivity Breakdown (4 cols) -->
            <div class="lg:col-span-4 bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm flex flex-col justify-between">
                <h3 class="text-sm font-bold font-heading text-zinc-900 mb-4">Interaction Distribution</h3>
                
                <div class="relative w-full h-[220px] flex items-center justify-center">
                    <canvas id="interactionDonutCanvas"></canvas>
                </div>

                <div class="mt-4 space-y-2.5 text-xs font-semibold">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-zinc-950"></span>
                            <span class="text-zinc-600">Likes</span>
                        </div>
                        <span class="text-zinc-900 font-bold">84.2%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-zinc-500"></span>
                            <span class="text-zinc-600">Comments</span>
                        </div>
                        <span class="text-zinc-900 font-bold">12.5%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-zinc-300"></span>
                            <span class="text-zinc-600">Shares & Saves</span>
                        </div>
                        <span class="text-zinc-900 font-bold">3.3%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Post Engagement Audit Table -->
        <div class="bg-white border border-zinc-200 rounded-[10px] p-6 shadow-sm">
            <h3 class="text-base font-bold font-heading text-zinc-900 mb-4">Post Engagement Breakdown</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-200 text-zinc-400 font-bold uppercase tracking-wider">
                            <th class="py-3 px-4">Post Media</th>
                            <th class="py-3 px-4">Caption</th>
                            <th class="py-3 px-4">Likes</th>
                            <th class="py-3 px-4">Comments</th>
                            <th class="py-3 px-4">Engagement Score</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 font-semibold text-zinc-700">
                        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $likes = $post['like_count'] ?? 0;
                                $comments = $post['comments_count'] ?? 0;
                                $score = number_format(($likes + ($comments * 2.5)) / max($insights['followers_count'] ?? 85000, 1) * 100, 2);
                            ?>
                            <tr class="hover:bg-zinc-50 transition">
                                <td class="py-3.5 px-4 w-16">
                                    <?php if(isset($post['media_url'])): ?>
                                        <img src="<?php echo e($post['media_url']); ?>" class="w-10 h-10 rounded-[10px] object-cover ring-1 ring-zinc-200" alt="Post">
                                    <?php else: ?>
                                        <div class="w-10 h-10 rounded-[10px] bg-zinc-100 flex items-center justify-center font-bold text-[10px]">IG</div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 max-w-sm truncate text-zinc-900 font-medium"><?php echo e($post['caption'] ?? 'No caption'); ?></td>
                                <td class="py-3.5 px-4 text-zinc-900 font-bold">❤️ <?php echo e(number_format($likes)); ?></td>
                                <td class="py-3.5 px-4 text-zinc-900 font-bold">💬 <?php echo e(number_format($comments)); ?></td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-[10px] text-xs font-bold font-mono bg-zinc-100 text-zinc-900 border border-zinc-200">
                                        <?php echo e($score); ?>%
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-zinc-400 font-medium">No recent posts available for engagement analysis.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Line Chart
                const ctxLine = document.getElementById('engagementRateCanvas');
                if (ctxLine) {
                    const gradient = ctxLine.getContext('2d').createLinearGradient(0, 0, 0, 320);
                    gradient.addColorStop(0, 'rgba(24, 24, 27, 0.2)');
                    gradient.addColorStop(1, 'rgba(24, 24, 27, 0.0)');

                    new Chart(ctxLine, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                            datasets: [{
                                label: 'Engagement Rate %',
                                data: [5.2, 5.8, 6.1, 6.0, 6.4, 6.48],
                                borderColor: '#09090B',
                                borderWidth: 3,
                                backgroundColor: gradient,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 5,
                                pointBackgroundColor: '#09090B',
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: {
                                    min: 4,
                                    max: 8,
                                    ticks: { callback: v => v + '%', font: { family: 'Inter', size: 11, weight: '600' } }
                                }
                            }
                        }
                    });
                }

                // Donut Chart
                const ctxDonut = document.getElementById('interactionDonutCanvas');
                if (ctxDonut) {
                    new Chart(ctxDonut, {
                        type: 'doughnut',
                        data: {
                            labels: ['Likes', 'Comments', 'Shares'],
                            datasets: [{
                                data: [84.2, 12.5, 3.3],
                                backgroundColor: ['#09090B', '#71717A', '#E4E4E7'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '70%',
                            plugins: { legend: { display: false } }
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
<?php /**PATH /var/www/resources/views/analytics/engagement.blade.php ENDPATH**/ ?>
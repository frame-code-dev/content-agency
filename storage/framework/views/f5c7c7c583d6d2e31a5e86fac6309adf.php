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
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Messages & Comments Studio</h1>
                <p class="text-xs text-slate-500 mt-1">Direct message interactions, comment sentiment auditing, and automated reply workflows.</p>
            </div>
        </div>

        <!-- 4 Summary KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Unread Messages</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">12</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">📩 New</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Comments Audited</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">1,480</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">💬 Synced</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Positive Sentiment</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">92.4%</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">😃 Great</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Avg Response Speed</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">1.8 Min</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">⚡ Fast</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/70 rounded-3xl p-8 text-center shadow-sm max-w-3xl mx-auto my-6">
            <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 font-bold text-2xl">
                💬
            </div>
            <h2 class="text-xl font-bold font-heading text-slate-900">Instagram Direct Messages & Comments Hub</h2>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Connect your Meta Instagram Professional account to automatically sync incoming comments, perform AI sentiment analysis, and automate direct message responses.
            </p>
            <div class="mt-6">
                <a href="<?php echo e(route('instagram.connect')); ?>" class="inline-flex items-center space-x-2 px-8 py-3.5 bg-[#072215] text-[#A3E635] text-xs font-bold rounded-2xl shadow hover:scale-105 transition">
                    <span>Sync Meta Instagram DMs</span>
                </a>
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
<?php /**PATH /var/www/resources/views/analytics/messages.blade.php ENDPATH**/ ?>
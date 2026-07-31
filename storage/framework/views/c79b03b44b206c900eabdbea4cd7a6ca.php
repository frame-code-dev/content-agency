<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full bg-zinc-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Cineart Production - Media & AI Studio')); ?></title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CDN for fast dynamic styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            sidebar: '#09090B',
                            dark: '#000000',
                            cardBg: '#FFFFFF',
                            bg: '#F8F9FA',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Chart.js Engine -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body class="font-sans antialiased h-full text-zinc-900 bg-zinc-50 selection:bg-zinc-900 selection:text-white">
    <div class="flex h-screen overflow-hidden">

        <?php
            $currentUser = auth()->user();
            $currentAccount = $currentUser ? $currentUser->instagramAccount : null;
            $isSuperAdmin = $currentUser ? $currentUser->hasRole('super-admin') : false;
            $hasConnectedAccount = $currentAccount !== null || $isSuperAdmin;
        ?>

        <!-- Sidebar Navigation (Sleek Monochrome Dark Theme) -->
        <aside class="w-64 bg-[#09090B] text-white flex flex-col justify-between shrink-0 border-r border-zinc-800/80 shadow-xl z-20 transition-all duration-300">
            <div>
                <!-- Brand Header: Cineart Production -->
                <div class="h-20 flex items-center px-6 border-b border-zinc-800/80">
                    <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center space-x-3 group">
                        <div class="w-9 h-9 rounded-[10px] bg-white flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200">
                            <!-- Film Reel / Camera Icon for Cineart Production -->
                            <svg class="w-5 h-5 text-zinc-950" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H9l2 4H8L6 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-8v-2h8v2zm0-4h-8v-2h8v2zm0-4h-8V7h8v2z"/>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-heading font-bold text-base tracking-tight text-white leading-tight">Cineart Production</span>
                            <span class="text-[10px] text-zinc-400 font-semibold tracking-wider uppercase">Media & AI Studio</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Sections -->
                <nav class="px-4 py-6 space-y-6 overflow-y-auto max-h-[calc(100vh-160px)] custom-scrollbar">

                    <!-- SECTION: MENU -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">MENU</div>
                        <div class="space-y-1">
                            <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-[10px] font-semibold text-xs transition duration-150 <?php echo e(request()->routeIs('dashboard') ? 'bg-white text-zinc-950 shadow-md' : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'); ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                <span>Dashboard</span>
                            </a>

                            <?php if($hasConnectedAccount): ?>
                                <a href="<?php echo e(route('analytics.content')); ?>" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-[10px] font-semibold text-xs transition duration-150 <?php echo e(request()->routeIs('analytics.content') ? 'bg-white text-zinc-950 shadow-md' : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <span>Content Performance</span>
                                </a>

                                <a href="<?php echo e(route('analytics.engagement')); ?>" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-[10px] font-semibold text-xs transition duration-150 <?php echo e(request()->routeIs('analytics.engagement') ? 'bg-white text-zinc-950 shadow-md' : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                    <span>Engagement Analytics</span>
                                </a>

                                <a href="<?php echo e(route('analytics.reach')); ?>" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-[10px] font-semibold text-xs transition duration-150 <?php echo e(request()->routeIs('analytics.reach') ? 'bg-white text-zinc-950 shadow-md' : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>Reach & Impressions</span>
                                </a>

                                <a href="<?php echo e(route('analytics.audience')); ?>" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-[10px] font-semibold text-xs transition duration-150 <?php echo e(request()->routeIs('analytics.audience') ? 'bg-white text-zinc-950 shadow-md' : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span>Audience Insights</span>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('instagram.connect')); ?>" class="flex items-center justify-between px-3.5 py-2.5 rounded-[10px] font-semibold text-xs text-zinc-600 hover:bg-zinc-900/50 transition duration-150 group">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <span class="line-through opacity-70">Content Performance</span>
                                    </div>
                                    <span class="text-[9px] bg-zinc-800 text-zinc-300 px-2 py-0.5 rounded-[10px] font-mono">Connect IG</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- SECTION: MARKETING & CAMPAIGNS -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">MARKETING & CAMPAIGNS</div>
                        <div class="space-y-1">
                            <?php if($hasConnectedAccount): ?>
                                <a href="<?php echo e(route('campaigns.index')); ?>" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-[10px] font-semibold text-xs transition duration-150 <?php echo e(request()->routeIs('campaigns.*') ? 'bg-white text-zinc-950 shadow-md' : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 58l10-10V4L1 14v34l10 10zm0 0l10 10m-10-10v10"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3a1 1 0 011 1v4a1 1 0 01-1 1H7a1 1 0 01-1-1V4a1 1 0 011-1h4z"/>
                                    </svg>
                                    <span>Campaign Performance</span>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('instagram.connect')); ?>" class="flex items-center justify-between px-3.5 py-2.5 rounded-[10px] font-semibold text-xs text-zinc-600 hover:bg-zinc-900/50 transition duration-150 group">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <span class="line-through opacity-70">Campaign Performance</span>
                                    </div>
                                    <span class="text-[9px] bg-zinc-800 text-zinc-300 px-2 py-0.5 rounded-[10px] font-mono">Connect IG</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- SECTION: PUBLISHING & INTERACTION -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">PUBLISHING & INTERACTION</div>
                        <div class="space-y-1">
                            <?php if($hasConnectedAccount): ?>
                                <a href="<?php echo e(route('planner.index')); ?>" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-[10px] font-semibold text-xs transition duration-150 <?php echo e(request()->routeIs('planner.*') ? 'bg-white text-zinc-950 shadow-md' : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Post Scheduler</span>
                                </a>
                                <a href="<?php echo e(route('messages.index')); ?>" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-[10px] font-semibold text-xs transition duration-150 <?php echo e(request()->routeIs('messages.*') ? 'bg-white text-zinc-950 shadow-md' : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <span>Messages & Comments</span>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('instagram.connect')); ?>" class="flex items-center justify-between px-3.5 py-2.5 rounded-[10px] font-semibold text-xs text-zinc-600 hover:bg-zinc-900/50 transition duration-150 group">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <span class="line-through opacity-70">Post Scheduler</span>
                                    </div>
                                    <span class="text-[9px] bg-zinc-800 text-zinc-300 px-2 py-0.5 rounded-[10px] font-mono">Connect IG</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- SECTION: REPORTS & EXPORT -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">REPORTS & EXPORT</div>
                        <div class="space-y-1">
                            <?php if($hasConnectedAccount): ?>
                                <a href="<?php echo e(route('competitors.index')); ?>" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-[10px] font-semibold text-xs transition duration-150 <?php echo e(request()->routeIs('competitors.*') ? 'bg-white text-zinc-950 shadow-md' : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>Reports & Insights</span>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('instagram.connect')); ?>" class="flex items-center justify-between px-3.5 py-2.5 rounded-[10px] font-semibold text-xs text-zinc-600 hover:bg-zinc-900/50 transition duration-150 group">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <span class="line-through opacity-70">Reports & Insights</span>
                                    </div>
                                    <span class="text-[9px] bg-zinc-800 text-zinc-300 px-2 py-0.5 rounded-[10px] font-mono">Connect IG</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- SECTION: PROFILE & ACCOUNT -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">PROFILE & ACCOUNT</div>
                        <div class="space-y-1">
                            <a href="<?php echo e(route('settings')); ?>" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-[10px] font-semibold text-xs transition duration-150 <?php echo e(request()->routeIs('settings') ? 'bg-white text-zinc-950 shadow-md' : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'); ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>

                </nav>
            </div>

            <!-- Bottom User Profile Card -->
            <div class="p-4 border-t border-zinc-800/80 bg-zinc-950">
                <?php
                    $displayName = $currentAccount->name ?? $currentAccount->username ?? $currentUser->name ?? 'Cineart Client';
                    $displaySub = $currentAccount ? '@' . $currentAccount->username : ($currentUser->email ?? 'client@agency.com');
                    $avatarUrl = $currentAccount->profile_picture_url ?? null;
                ?>
                <div class="flex items-center justify-between p-2.5 rounded-[10px] bg-zinc-900 border border-zinc-800">
                    <div class="flex items-center space-x-3 truncate">
                        <?php if(!empty($avatarUrl)): ?>
                            <img src="<?php echo e($avatarUrl); ?>" alt="<?php echo e($displayName); ?>" class="w-8 h-8 rounded-[10px] object-cover border border-zinc-700">
                        <?php else: ?>
                            <div class="w-8 h-8 rounded-[10px] bg-zinc-800 border border-zinc-700 flex items-center justify-center font-bold text-white text-xs">
                                <?php echo e(strtoupper(substr($displayName, 0, 1))); ?>

                            </div>
                        <?php endif; ?>
                        <div class="truncate">
                            <div class="text-xs font-bold text-white truncate"><?php echo e($displayName); ?></div>
                            <div class="text-[10px] text-zinc-400 truncate"><?php echo e($displaySub); ?></div>
                        </div>
                    </div>
                    <?php if(auth()->check()): ?>
                        <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" title="Logout" class="p-1.5 text-zinc-400 hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-zinc-50">
            <?php if(isset($header)): ?>
                <div class="bg-white border-b border-zinc-200 px-8 py-5">
                    <?php echo e($header); ?>

                </div>
            <?php endif; ?>
            <?php echo e($slot); ?>

        </main>

    </div>
</body>
</html>
<?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>
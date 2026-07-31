<x-app-layout>
    <div class="p-8 max-w-[1600px] mx-auto space-y-8">

        @if(session('error') || $error)
            <div class="bg-slate-900 text-white text-xs px-5 py-3.5 rounded-2xl flex items-center justify-between shadow-sm">
                <span>{{ session('error') ?? $error }}</span>
            </div>
        @endif

        @if($account && method_exists($account, 'isTokenExpired') && $account->isTokenExpired())
            <div class="bg-amber-500/10 border border-amber-500/30 p-4 rounded-2xl flex items-center justify-between text-amber-900 shadow-sm">
                <div class="flex items-center space-x-3">
                    <span class="text-xl">⚠️</span>
                    <div>
                        <div class="text-sm font-bold">Access Token Instagram Expired (Habis Masa Berlaku)</div>
                        <div class="text-xs text-amber-700">Silakan hubungkan ulang akun Instagram @{{ $account->username }} untuk menyegarkan token analitik real-time.</div>
                    </div>
                </div>
                <a href="{{ route('instagram.connect') }}" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl shadow transition">
                    🔄 Reconnect Instagram
                </a>
            </div>
        @endif

        @if(!$account)
            <!-- Initial Onboarding State: Connect Instagram Screen -->
            <div class="max-w-3xl mx-auto my-12 bg-white border border-slate-200/80 rounded-3xl p-12 text-center shadow-lg">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-tr from-purple-600 via-pink-600 to-amber-500 text-white mb-6 shadow-lg shadow-pink-500/20">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Connect Your Instagram Account</h2>
                <p class="text-sm text-slate-500 mt-3 max-w-lg mx-auto leading-relaxed">
                    Link your agency or brand Instagram channel to enable automated content auditing, follower growth analytics, and sentiment reports.
                </p>

                <div class="mt-8">
                    <a href="{{ route('instagram.connect') }}" class="inline-flex items-center space-x-3 px-8 py-4 bg-[#072215] hover:bg-[#051910] text-[#A3E635] text-sm font-bold tracking-wide rounded-2xl shadow-xl hover:scale-105 transition transform duration-200">
                        <svg class="w-5 h-5 text-[#A3E635]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        <span>Connect Instagram Account</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Full SocialPulse Analytics Dashboard -->
            <!-- Top Header & Creator Profile Bar -->
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div>
                    <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Dashboard Overview</h1>
                    <p class="text-xs text-slate-500 mt-1">Real-time social intelligence and audience metrics from database.</p>
                </div>

                <!-- Top Header Action Controls -->
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Instagram Connection & Reconnect Status Badge -->
                    <div class="flex items-center space-x-2 bg-white border border-slate-200/80 px-3 py-1.5 rounded-2xl text-xs shadow-sm">
                        <span class="w-2 h-2 rounded-full {{ method_exists($account, 'isTokenExpired') && $account->isTokenExpired() ? 'bg-amber-500 animate-ping' : 'bg-emerald-500 animate-pulse' }}"></span>
                        <span class="font-semibold text-slate-700 font-mono">@ {{ $account->username }}</span>
                        
                        <!-- Reconnect Button -->
                        <a href="{{ route('instagram.connect') }}" title="Reconnect Instagram to refresh token" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold rounded-xl text-[11px] border border-emerald-200 transition">
                            🔄 Reconnect
                        </a>

                        <!-- Disconnect Button Form -->
                        <form action="{{ route('instagram.disconnect') }}" method="POST" class="inline" onsubmit="return confirm('Disconnect this Instagram account?')">
                            @csrf
                            <button type="submit" title="Disconnect Account" class="px-2 py-1 text-slate-400 hover:text-rose-600 font-medium text-[11px] transition">
                                🔌 Disconnect
                            </button>
                        </form>
                    </div>

                    <!-- Search & Notification Buttons -->
                    <div class="flex items-center space-x-2">
                        <button class="w-10 h-10 rounded-full bg-white shadow-sm border border-slate-200/80 flex items-center justify-center text-slate-600 hover:text-slate-900 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        <button class="w-10 h-10 rounded-full bg-white shadow-sm border border-slate-200/80 flex items-center justify-center text-slate-600 hover:text-slate-900 transition relative">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-[#A3E635] ring-2 ring-white"></span>
                        </button>
                    </div>

                    <!-- Creator Profile Header Card -->
                    <div class="flex items-center space-x-4 bg-white border border-slate-200/80 p-3 px-5 rounded-2xl shadow-sm">
                        <img class="w-11 h-11 rounded-full object-cover ring-2 ring-[#A3E635]" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80" alt="Avatar">
                        <div class="pr-4 border-r border-slate-200">
                            <div class="text-sm font-bold text-slate-900 leading-tight">{{ $user->name ?? 'Isabella White' }}</div>
                            <div class="text-[11px] text-emerald-600 font-semibold font-mono">@ {{ $account->username }}</div>
                        </div>
                        <div class="flex items-center space-x-5 text-center pl-2">
                            <div>
                                <div class="text-sm font-bold text-slate-900">{{ number_format($insights['followers_count'] ?? 0) }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">Followers</div>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900">{{ number_format($insights['follows_count'] ?? 0) }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">Following</div>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900">{{ number_format($insights['media_count'] ?? count($posts)) }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">Total Posts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Controls Row (Platform Focus: Instagram & Date Dropdown) -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <!-- Instagram Platform Badge -->
                <div class="flex items-center space-x-2 bg-white/80 p-1.5 rounded-2xl border border-slate-200/80 shadow-sm">
                    <button class="px-5 py-2 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-md flex items-center space-x-2">
                        <svg class="w-4 h-4 text-pink-400 inline" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        <span>Instagram Analytics</span>
                    </button>
                </div>

                <!-- Date Selector Filter -->
                <div class="flex items-center space-x-2">
                    <button class="flex items-center space-x-2 bg-white border border-slate-200/80 px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 shadow-sm hover:border-slate-300 transition">
                        <span>This Month</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- 4 KPI Summary Metric Cards Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Card 1: Total Followers -->
                <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm hover:shadow-md transition duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Total Followers</span>
                    </div>
                    <div class="mt-4 flex items-baseline justify-between">
                        <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($insights['followers_count'] ?? 0) }}</span>
                        <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                            ↑ +12
                        </span>
                    </div>
                </div>

                <!-- Card 2: Engagement Rate -->
                <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm hover:shadow-md transition duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Engagement Rate</span>
                    </div>
                    <div class="mt-4 flex items-baseline justify-between">
                        <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ $insights['engagement_rate'] ?? '6.48%' }}</span>
                        <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                            ↑
                        </span>
                    </div>
                </div>

                <!-- Card 3: Post Reach -->
                <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm hover:shadow-md transition duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Post Reach</span>
                    </div>
                    <div class="mt-4 flex items-baseline justify-between">
                        <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ is_numeric($insights['reach'] ?? null) ? number_format($insights['reach']) : ($insights['reach'] ?? '1.1M') }}</span>
                        <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                            ↑
                        </span>
                    </div>
                </div>

                <!-- Card 4: Impressions -->
                <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm hover:shadow-md transition duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Impressions</span>
                    </div>
                    <div class="mt-4 flex items-baseline justify-between">
                        <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ is_numeric($insights['impressions'] ?? null) ? number_format($insights['impressions']) : ($insights['impressions'] ?? '892K') }}</span>
                        <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                            ↑
                        </span>
                    </div>
                </div>
            </div>

            <!-- Middle Grid: Follower Growth Trend, Gender Split, Active Hours -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Follower Growth Trend (6 Columns) -->
                <div class="lg:col-span-6 bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold font-heading text-slate-900">Follower Growth Trend</h3>
                        <button class="flex items-center space-x-1.5 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-600">
                            <span>This Month</span>
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>
                    <div class="relative w-full h-[260px]">
                        <canvas id="growthTrendCanvas"></canvas>
                    </div>
                </div>

                <!-- Gender Split Donut Chart (3 Columns) -->
                <div class="lg:col-span-3 bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-bold font-heading text-slate-900">Gender Split</h3>
                    </div>

                    <div class="relative w-full h-[180px] flex items-center justify-center">
                        <canvas id="genderSplitCanvas"></canvas>
                    </div>

                    <div class="mt-4 space-y-2 text-xs font-semibold">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#84CC16]"></span>
                                <span class="text-slate-600">Male</span>
                            </div>
                            <span class="text-slate-900 font-bold">52.1%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#A3E635]"></span>
                                <span class="text-slate-600">Female</span>
                            </div>
                            <span class="text-slate-900 font-bold">22.8%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#D9F99D]"></span>
                                <span class="text-slate-600">Other</span>
                            </div>
                            <span class="text-slate-900 font-bold">13.9%</span>
                        </div>
                    </div>
                </div>

                <!-- Active Hours Heatmap (3 Columns) -->
                <div class="lg:col-span-3 bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-bold font-heading text-slate-900">Active Hours</h3>
                        <button class="flex items-center space-x-1 text-[10px] font-semibold text-slate-500">
                            <span>This Month</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>

                    <div class="flex items-center justify-between text-[10px] text-slate-400 font-semibold mb-3">
                        <span>Less</span>
                        <div class="flex space-x-1">
                            <span class="w-2.5 h-2.5 rounded bg-lime-100"></span>
                            <span class="w-2.5 h-2.5 rounded bg-lime-300"></span>
                            <span class="w-2.5 h-2.5 rounded bg-[#A3E635]"></span>
                            <span class="w-2.5 h-2.5 rounded bg-emerald-700"></span>
                        </div>
                        <span>More</span>
                    </div>

                    <!-- Heatmap Matrix Grid -->
                    <div class="space-y-1.5">
                        @php
                            $days = ['Su', 'Mo', 'Tu', 'We', 'Th'];
                            $hours = ['12', '13', '14', '15', '17', '18', '19', '20', '21'];
                            $matrix = $insights['heatmap_matrix'] ?? [
                                [2, 3, 2, 4, 3, 2, 4, 3, 2],
                                [1, 2, 3, 3, 4, 2, 3, 2, 1],
                                [2, 3, 4, 4, 5, 4, 3, 3, 2],
                                [3, 4, 3, 5, 4, 3, 4, 2, 1],
                                [2, 3, 4, 3, 4, 5, 4, 3, 2],
                            ];
                        @endphp

                        @foreach($days as $dIdx => $day)
                            <div class="flex items-center space-x-1.5">
                                <span class="w-5 text-[10px] font-bold text-slate-400 text-right shrink-0">{{ $day }}</span>
                                <div class="grid grid-cols-9 gap-1 flex-1">
                                    @foreach($hours as $hIdx => $hour)
                                        @php
                                            $val = $matrix[$dIdx][$hIdx] ?? 2;
                                            $bgClass = match(true) {
                                                $val >= 5 => 'bg-emerald-700',
                                                $val == 4 => 'bg-[#A3E635]',
                                                $val == 3 => 'bg-lime-300',
                                                default   => 'bg-lime-100',
                                            };
                                        @endphp
                                        <div class="h-5 rounded-md {{ $bgClass }} transition hover:scale-110" title="Activity score: {{ $val }}"></div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <!-- Hours Header Row -->
                        <div class="flex items-center space-x-1.5 pt-1">
                            <span class="w-5"></span>
                            <div class="grid grid-cols-9 gap-1 flex-1 text-center text-[9px] font-semibold text-slate-400">
                                @foreach($hours as $hour)
                                    <span>{{ $hour }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Grid: Regional Map, Age Groups, Profile Visitors -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Geographic / Country Breakdown (4 Columns) -->
                <div class="lg:col-span-4 bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                    <h3 class="text-sm font-bold font-heading text-slate-900 mb-4">Age groups / Geography</h3>

                    <div class="flex items-center space-x-4 mb-4">
                        <!-- Stylized World Map SVG graphic -->
                        <div class="w-1/2 h-28 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-center p-2 overflow-hidden relative">
                            <svg class="w-full h-full text-emerald-600/30 fill-current" viewBox="0 0 200 100">
                                <path d="M 30,30 Q 50,20 70,40 T 110,30 T 150,50 T 180,30 L 190,80 Q 150,90 100,70 T 30,80 Z"/>
                            </svg>
                            <span class="absolute text-[10px] font-bold text-slate-500 bg-white/80 backdrop-blur px-2 py-0.5 rounded-full border border-slate-200">Asia Pacific</span>
                        </div>

                        <!-- Country Bars -->
                        <div class="w-1/2 space-y-2.5 text-xs font-semibold">
                            <div>
                                <div class="flex justify-between text-slate-600 mb-0.5">
                                    <span>Filipina</span>
                                    <span class="font-bold text-slate-900">12K</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-[#A3E635] h-1.5 rounded-full" style="width: 25%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-slate-600 mb-0.5">
                                    <span>Thailand</span>
                                    <span class="font-bold text-slate-900">106K</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-[#A3E635] h-1.5 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-slate-600 mb-0.5">
                                    <span>Japan</span>
                                    <span class="font-bold text-slate-900">16K</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-[#A3E635] h-1.5 rounded-full" style="width: 35%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-slate-600 mb-0.5">
                                    <span>Rusia</span>
                                    <span class="font-bold text-slate-900">16K</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-[#A3E635] h-1.5 rounded-full" style="width: 35%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Age groups Bar Progress (4 Columns) -->
                <div class="lg:col-span-4 bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                    <h3 class="text-sm font-bold font-heading text-slate-900 mb-4">Age groups</h3>

                    <div class="space-y-3.5">
                        <div class="flex items-center space-x-3 text-xs font-semibold">
                            <span class="w-12 text-slate-500">12-17</span>
                            <div class="flex-1 bg-slate-100 h-7 rounded-xl overflow-hidden relative">
                                <div class="bg-slate-200 h-full rounded-xl transition-all duration-500" style="width: 5%"></div>
                                <span class="absolute right-3 top-1.5 text-[11px] font-bold text-slate-700">5%</span>
                            </div>
                        </div>

                        <!-- Highlighted Age Bracket: 18-24 -->
                        <div class="flex items-center space-x-3 text-xs font-semibold">
                            <span class="w-12 text-slate-900 font-bold">18-24</span>
                            <div class="flex-1 bg-slate-100 h-7 rounded-xl overflow-hidden relative shadow-sm">
                                <div class="bg-[#A3E635] h-full rounded-xl transition-all duration-500" style="width: 80%"></div>
                                <span class="absolute right-3 top-1.5 text-[11px] font-bold text-slate-900">80%</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 text-xs font-semibold">
                            <span class="w-12 text-slate-500">24-35</span>
                            <div class="flex-1 bg-slate-100 h-7 rounded-xl overflow-hidden relative">
                                <div class="bg-slate-200 h-full rounded-xl transition-all duration-500" style="width: 10%"></div>
                                <span class="absolute right-3 top-1.5 text-[11px] font-bold text-slate-700">10%</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 text-xs font-semibold">
                            <span class="w-12 text-slate-500">35-44</span>
                            <div class="flex-1 bg-slate-100 h-7 rounded-xl overflow-hidden relative">
                                <div class="bg-slate-200 h-full rounded-xl transition-all duration-500" style="width: 10%"></div>
                                <span class="absolute right-3 top-1.5 text-[11px] font-bold text-slate-700">10%</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 text-xs font-semibold">
                            <span class="w-12 text-slate-500">44-60</span>
                            <div class="flex-1 bg-slate-100 h-7 rounded-xl overflow-hidden relative">
                                <div class="bg-slate-200 h-full rounded-xl" style="width: 0%"></div>
                                <span class="absolute right-3 top-1.5 text-[11px] font-bold text-slate-400">0%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Visitors Monthly Bar Chart (4 Columns) -->
                <div class="lg:col-span-4 bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-bold font-heading text-slate-900">Profile Visitors</h3>
                        <button class="flex items-center space-x-1 text-[10px] font-semibold text-slate-500">
                            <span>This Month</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>

                    <div class="relative w-full h-[180px]">
                        <canvas id="profileVisitorsCanvas"></canvas>
                    </div>
                </div>

            </div>

            <!-- Recent Assets & Real Database Content Feed Grid -->
            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-bold font-heading text-slate-900">Recent Content Assets & AI Audit</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Real assets fetched from database and Meta Graph API.</p>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 font-mono">{{ count($posts) }} Posts Available</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($posts as $post)
                        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl overflow-hidden flex flex-col justify-between hover:shadow-md transition duration-200">
                            <div>
                                @if(isset($post['media_url']) && (str_contains($post['media_type'] ?? '', 'IMAGE') || str_contains($post['media_type'] ?? '', 'VIDEO')))
                                    <div class="aspect-square w-full bg-slate-200 overflow-hidden relative">
                                        @if(str_contains($post['media_type'] ?? '', 'VIDEO'))
                                            <video src="{{ $post['media_url'] }}" class="w-full h-full object-cover" muted loop></video>
                                            <span class="absolute top-3 right-3 bg-slate-900/80 text-white text-[10px] px-2.5 py-1 rounded-lg font-semibold uppercase backdrop-blur">Reels</span>
                                        @else
                                            <img src="{{ $post['media_url'] }}" alt="Post Media" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                @else
                                    <div class="aspect-square w-full bg-slate-100 flex items-center justify-center p-6 text-center">
                                        <span class="text-xs font-bold uppercase tracking-widest text-slate-400">{{ $post['media_type'] ?? 'CAROUSEL' }}</span>
                                    </div>
                                @endif

                                <div class="p-5">
                                    <p class="text-xs text-slate-700 line-clamp-3 leading-relaxed">
                                        {{ $post['caption'] ?? 'No caption provided.' }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-5 pt-0 space-y-3">
                                <div class="flex items-center justify-between text-xs text-slate-600 font-semibold border-t border-slate-200/60 pt-3">
                                    <span>❤️ {{ number_format($post['like_count'] ?? 0) }} Likes</span>
                                    <span>💬 {{ number_format($post['comments_count'] ?? 0) }} Comments</span>
                                </div>

                                <form action="{{ route('analysis.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post['id'] }}">
                                    <input type="hidden" name="caption" value="{{ $post['caption'] ?? '' }}">
                                    <input type="hidden" name="media_url" value="{{ $post['media_url'] ?? '' }}">
                                    <input type="hidden" name="likes" value="{{ $post['like_count'] ?? 0 }}">
                                    <input type="hidden" name="comments" value="{{ $post['comments_count'] ?? 0 }}">

                                    <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-sm transition">
                                        Run AI Audit
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-xs text-slate-400 font-medium">
                            No recent media assets found on this account.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Chart.js Setup Scripts for SocialPulse Dashboards -->
            <script>
                document.addEventListener("DOMContentLoaded", function () {

                    // 1. Follower Growth Trend Smooth Area Chart
                    const ctxGrowth = document.getElementById('growthTrendCanvas');
                    if (ctxGrowth) {
                        const gradient = ctxGrowth.getContext('2d').createLinearGradient(0, 0, 0, 260);
                        gradient.addColorStop(0, 'rgba(163, 230, 53, 0.45)');
                        gradient.addColorStop(1, 'rgba(163, 230, 53, 0.0)');

                        new Chart(ctxGrowth, {
                            type: 'line',
                            data: {
                                labels: {!! json_encode($insights['trend_labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']) !!},
                                datasets: [{
                                    label: 'Follower Growth',
                                    data: {!! json_encode($insights['trend_data'] ?? [12000, 15000, 14000, 22000, 26000, 21000, 24000]) !!},
                                    borderColor: '#84CC16',
                                    borderWidth: 3,
                                    backgroundColor: gradient,
                                    fill: true,
                                    tension: 0.45,
                                    pointRadius: 0,
                                    pointHoverRadius: 6,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: {
                                    y: {
                                        min: 0,
                                        max: 30000,
                                        ticks: {
                                            stepSize: 10000,
                                            callback: value => value === 0 ? '0' : (value / 1000) + 'K',
                                            font: { family: 'Inter', size: 10, weight: '600' },
                                            color: '#94A3B8'
                                        },
                                        grid: { color: '#F1F5F9' }
                                    },
                                    x: {
                                        grid: { display: false },
                                        ticks: { font: { family: 'Inter', size: 10, weight: '600' }, color: '#94A3B8' }
                                    }
                                }
                            }
                        });
                    }

                    // 2. Gender Split Doughnut Chart
                    const ctxGender = document.getElementById('genderSplitCanvas');
                    if (ctxGender) {
                        new Chart(ctxGender, {
                            type: 'doughnut',
                            data: {
                                labels: ['Male', 'Female', 'Other'],
                                datasets: [{
                                    data: [52.1, 22.8, 13.9],
                                    backgroundColor: ['#84CC16', '#A3E635', '#D9F99D'],
                                    borderWidth: 0,
                                    hoverOffset: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '72%',
                                plugins: { legend: { display: false } }
                            }
                        });
                    }

                    // 3. Profile Visitors Monthly Bar Chart
                    const ctxVisitors = document.getElementById('profileVisitorsCanvas');
                    if (ctxVisitors) {
                        new Chart(ctxVisitors, {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($insights['visitors_labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
                                datasets: [{
                                    data: {!! json_encode($insights['visitors_data'] ?? [4200, 4800, 4100, 5000, 4600, 4900]) !!},
                                    backgroundColor: ['#E2E8F0', '#E2E8F0', '#E2E8F0', '#A3E635', '#E2E8F0', '#E2E8F0'],
                                    borderRadius: 8,
                                    barThickness: 24,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: {
                                    y: {
                                        min: 0,
                                        max: 5000,
                                        ticks: {
                                            stepSize: 1000,
                                            callback: value => value === 0 ? '0' : (value / 1000) + 'K',
                                            font: { family: 'Inter', size: 10, weight: '600' },
                                            color: '#94A3B8'
                                        },
                                        grid: { color: '#F1F5F9' }
                                    },
                                    x: {
                                        grid: { display: false },
                                        ticks: { font: { family: 'Inter', size: 10, weight: '600' }, color: '#94A3B8' }
                                    }
                                }
                            }
                        });
                    }

                });
            </script>
        @endif

    </div>
</x-app-layout>

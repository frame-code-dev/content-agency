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
            <!-- Initial Onboarding State: Connect Instagram or Upload Meta Export ZIP -->
            <div class="max-w-4xl mx-auto my-8 bg-white border border-slate-200/80 rounded-3xl p-8 md:p-10 shadow-lg">
                <div class="text-center max-w-xl mx-auto">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-gradient-to-tr from-purple-600 via-pink-600 to-amber-500 text-white mb-4 shadow-lg shadow-pink-500/20">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Setup Analitik Instagram Anda</h2>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Pilih opsi terbaik untuk menghubungkan data kanal Instagram Anda ke dalam dashboard analitik Cineart Production.
                    </p>
                </div>

                <!-- 2 Integration Methods Card Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <!-- Method 1: Connect via OAuth Live API -->
                    <div class="bg-slate-50 border border-slate-200/90 rounded-2xl p-6 flex flex-col justify-between hover:border-slate-300 transition">
                        <div>
                            <div class="inline-flex items-center px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-lg text-[10px] font-bold uppercase tracking-wider mb-3">
                                Opsi 1: Direct OAuth
                            </div>
                            <h3 class="text-base font-bold text-slate-900">Hubungkan via Meta OAuth</h3>
                            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                                Hubungkan langsung akun Instagram Professional / Business Anda via login dialog resmi dari Meta Facebook.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200/60">
                            <a href="{{ route('instagram.connect') }}" class="w-full flex items-center justify-center space-x-2 px-5 py-3 bg-[#072215] hover:bg-[#051910] text-[#A3E635] text-xs font-bold rounded-xl shadow transition">
                                <svg class="w-4 h-4 text-[#A3E635]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                <span>Connect via Instagram OAuth</span>
                            </a>
                        </div>
                    </div>

                    <!-- Method 2: Import Instagram Data Export (.ZIP / .JSON) -->
                    <div class="bg-[#072215]/5 border border-emerald-900/20 rounded-2xl p-6 flex flex-col justify-between">
                        <div>
                            <div class="inline-flex items-center px-2.5 py-1 bg-purple-100 text-purple-800 rounded-lg text-[10px] font-bold uppercase tracking-wider mb-3">
                                Opsi 2: Upload Data Export (.ZIP / .JSON)
                            </div>
                            <h3 class="text-base font-bold text-slate-900">Import File Data Instagram</h3>
                            <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                Upload file ekspor data Instagram Anda jika tidak dapat terhubung langsung via Meta OAuth.
                            </p>
                            
                            <!-- Help Meta Accounts Center Notice -->
                            <div class="mt-3 p-3 bg-white border border-emerald-200/80 rounded-xl text-[11px] text-slate-600 leading-relaxed shadow-sm">
                                💡 <strong>Tips Ekspor Data:</strong> <em>"You can download your Instagram data through the Meta Accounts Center by going to your information settings."</em>
                            </div>
                        </div>

                        <!-- ZIP File Upload Form & Progress Bar Container -->
                        <div class="mt-6 pt-4 border-t border-slate-200/60 space-y-3">
                            <form id="igZipUploadForm" class="space-y-3">
                                @csrf
                                <div class="relative">
                                    <input type="file" id="export_file" name="export_file" accept=".zip,.json" class="hidden" onchange="handleFileSelected(this)">
                                    <label for="export_file" class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-white hover:bg-slate-50 border-2 border-dashed border-emerald-600/40 text-slate-700 text-xs font-bold rounded-xl cursor-pointer transition shadow-sm">
                                        <span class="text-lg">📁</span>
                                        <span id="selectedFileName">Pilih File .ZIP / .JSON Ekspor</span>
                                    </label>
                                </div>

                                <button type="submit" id="btnSubmitZip" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition hidden">
                                    🚀 Upload & Ekstrak Data Ke Database
                                </button>
                            </form>

                            <!-- Progress Bar Component -->
                            <div id="uploadProgressContainer" class="hidden space-y-2 pt-2">
                                <div class="flex items-center justify-between text-xs font-semibold">
                                    <span id="progressStatusText" class="text-slate-700 font-mono">Mengunggah file zip...</span>
                                    <span id="progressPercentText" class="text-emerald-700 font-bold">0%</span>
                                </div>
                                <div class="w-full bg-slate-200 h-3 rounded-full overflow-hidden shadow-inner">
                                    <div id="uploadProgressBar" class="bg-gradient-to-r from-emerald-500 to-[#A3E635] h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <div id="progressStepSubtext" class="text-[10px] text-slate-400 font-mono text-center">Proses ekstraksi JSON & penyimpanan ke database PostgreSQL</div>
                            </div>
                        </div>
                    </div>
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
                        <span class="font-semibold text-slate-700 font-mono">{{ '@' . ($account->username ?? 'account') }}</span>
                        
                        <!-- Sync API & DB Button -->
                        <form action="{{ route('instagram.sync') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" title="Sync API & Store to Database" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold rounded-xl text-[11px] border border-emerald-200 transition">
                                🔄 Sync DB
                            </button>
                        </form>

                        <!-- Import Meta Export ZIP Modal Button -->
                        <button type="button" onclick="openUploadModal()" title="Upload File Ekspor Meta Instagram (.ZIP / .JSON)" class="px-2.5 py-1 bg-purple-50 hover:bg-purple-100 text-purple-800 font-bold rounded-xl text-[11px] border border-purple-200 transition">
                            📁 Import ZIP
                        </button>

                        <!-- Reconnect Button -->
                        <a href="{{ route('instagram.connect') }}" title="Reconnect Instagram to refresh token" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-[11px] border border-slate-200 transition">
                            🔑 Reconnect
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
                        <img class="w-11 h-11 rounded-full object-cover ring-2 ring-[#A3E635]" src="{{ $account->profile_picture_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80' }}" alt="Avatar">
                        <div class="pr-4 border-r border-slate-200">
                            <div class="text-sm font-bold text-slate-900 leading-tight">{{ $account->name ?? $account->username ?? $user->name ?? 'Cineart Client' }}</div>
                            <div class="text-[11px] text-emerald-600 font-semibold font-mono">{{ '@' . ($account->username ?? 'account') }}</div>
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

            <!-- Development Status & API Explanation Notice Banner -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 text-white shadow-sm relative overflow-hidden">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center shrink-0 text-lg text-indigo-400">
                            ⚡
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h3 class="text-sm font-bold font-heading text-white">Status API Instagram & Mode Database Sync</h3>
                                @if($insights['is_live_api'] ?? false)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">Live Meta Graph API</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">Mode Database (Ekspor Meta / Simulasi)</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-300 mt-1 leading-relaxed max-w-3xl">
                                Postingan & metrik analitik di bawah bersumber dari <strong class="text-white font-semibold">Database PostgreSQL</strong>. 
                                @if(!($insights['is_live_api'] ?? false))
                                    Data ini diambil dari hasil ekstraksi file ekspor Meta (.zip / .json) atau data simulasi pengembangan.
                                @else
                                    Data terhubung secara langsung via Meta Graph API real-time.
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 shrink-0">
                        <div class="text-[11px] text-slate-400 font-mono hidden sm:block">
                            Terakhir di-sync: <span class="text-indigo-300 font-medium">{{ isset($insights['last_synced_at']) ? \Carbon\Carbon::parse($insights['last_synced_at'])->diffForHumans() : 'Baru saja' }}</span>
                        </div>
                        <button type="button" onclick="openUploadModal()" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs rounded-xl shadow transition flex items-center space-x-1.5">
                            <span>📁 Import ZIP / JSON</span>
                        </button>
                        <form action="{{ route('instagram.sync') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3.5 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-200 font-semibold text-xs rounded-xl border border-zinc-700 shadow transition flex items-center space-x-1.5">
                                <span>🔄 Sync DB</span>
                            </button>
                        </form>
                    </div>
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
                            <span class="text-slate-900 font-bold">{{ $insights['male_pct'] ?? '41.8%' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#A3E635]"></span>
                                <span class="text-slate-600">Female</span>
                            </div>
                            <span class="text-slate-900 font-bold">{{ $insights['female_pct'] ?? '58.2%' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#D9F99D]"></span>
                                <span class="text-slate-600">Other</span>
                            </div>
                            <span class="text-slate-900 font-bold">{{ $insights['other_pct'] ?? '0.0%' }}</span>
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
                            @foreach(($insights['countries'] ?? []) as $c)
                                <div>
                                    <div class="flex justify-between text-slate-600 mb-0.5">
                                        <span>{{ $c['name'] }}</span>
                                        <span class="font-bold text-slate-900">{{ $c['count'] }}</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-[#A3E635] h-1.5 rounded-full" style="width: {{ $c['pct'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Age groups Bar Progress (4 Columns) -->
                <div class="lg:col-span-4 bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                    <h3 class="text-sm font-bold font-heading text-slate-900 mb-4">Age groups</h3>

                    <div class="space-y-3.5">
                        @foreach(($insights['age_groups'] ?? []) as $group)
                            <div class="flex items-center space-x-3 text-xs font-semibold">
                                <span class="w-12 {{ ($group['active'] ?? false) ? 'text-slate-900 font-bold' : 'text-slate-500' }}">{{ $group['range'] }}</span>
                                <div class="flex-1 bg-slate-100 h-7 rounded-xl overflow-hidden relative {{ ($group['active'] ?? false) ? 'shadow-sm' : '' }}">
                                    <div class="{{ ($group['active'] ?? false) ? 'bg-[#A3E635]' : 'bg-slate-200' }} h-full rounded-xl transition-all duration-500" style="width: {{ $group['pct'] }}%"></div>
                                    <span class="absolute right-3 top-1.5 text-[11px] font-bold {{ ($group['active'] ?? false) ? 'text-slate-900' : 'text-slate-700' }}">{{ $group['pct'] }}%</span>
                                </div>
                            </div>
                        @endforeach
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
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-5 pb-4 border-b border-slate-100 gap-3">
                    <div>
                        <h3 class="text-base font-bold font-heading text-slate-900">Recent Content Assets & AI Audit</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Real assets fetched from database and Meta Graph API (10 per halaman).</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-xs font-semibold text-slate-400 font-mono">{{ isset($postsPaginator) ? $postsPaginator->total() : count($posts) }} Posts Available</span>
                        <form action="{{ route('analysis.portfolio') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-[#A3E635] text-xs font-bold rounded-xl shadow transition flex items-center space-x-1.5 font-mono">
                                <span>⚡ Audit Keseluruhan Post</span>
                            </button>
                        </form>
                    </div>
                </div>

                @php
                    $displayItems = isset($postsPaginator) && $postsPaginator->count() > 0 ? $postsPaginator : $posts;
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @forelse($displayItems as $postItem)
                        @php
                            $pId = is_array($postItem) ? ($postItem['id'] ?? '') : ($postItem->instagram_post_id ?? $postItem->id);
                            $pCap = is_array($postItem) ? ($postItem['caption'] ?? '') : ($postItem->caption ?? '');
                            $pType = is_array($postItem) ? ($postItem['media_type'] ?? '') : ($postItem->media_type ?? '');
                            $pUrl = is_array($postItem) ? ($postItem['media_url'] ?? '') : ($postItem->media_url ?? '');
                            $pLikes = is_array($postItem) ? ($postItem['like_count'] ?? 0) : ($postItem->like_count ?? 0);
                            $pComments = is_array($postItem) ? ($postItem['comments_count'] ?? 0) : ($postItem->comments_count ?? 0);
                            $fallbackImg = 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?auto=format&fit=crop&w=600&q=80';
                        @endphp
                        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl overflow-hidden flex flex-col justify-between hover:shadow-md transition duration-200">
                            <div>
                                @if(!empty($pUrl) && (str_contains($pType, 'IMAGE') || str_contains($pType, 'VIDEO')))
                                    <div class="aspect-[4/3] w-full bg-slate-200 overflow-hidden relative">
                                        @if(str_contains($pType, 'VIDEO'))
                                            <video src="{{ $pUrl }}" class="w-full h-full object-cover" muted loop></video>
                                            <span class="absolute top-2 right-2 bg-slate-900/80 text-white text-[9px] px-2 py-0.5 rounded font-semibold uppercase backdrop-blur">Reels</span>
                                        @else
                                            <img src="{{ $pUrl }}" alt="Post Media" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='{{ $fallbackImg }}';">
                                        @endif
                                    </div>
                                @else
                                    <div class="aspect-[4/3] w-full bg-slate-100 flex items-center justify-center p-3 text-center overflow-hidden">
                                        <img src="{{ $fallbackImg }}" alt="Post Media" class="w-full h-full object-cover">
                                    </div>
                                @endif

                                <div class="p-3">
                                    <p class="text-[11px] text-slate-700 line-clamp-2 leading-tight">
                                        {{ !empty($pCap) ? $pCap : 'No caption provided.' }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-3 pt-0 space-y-2">
                                <div class="flex items-center justify-between text-[10px] text-slate-600 font-semibold border-t border-slate-200/60 pt-2 font-mono">
                                    <span>❤️ {{ number_format($pLikes) }}</span>
                                    <span>💬 {{ number_format($pComments) }}</span>
                                </div>

                                <form action="{{ route('analysis.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $pId }}">
                                    <input type="hidden" name="caption" value="{{ $pCap }}">
                                    <input type="hidden" name="media_url" value="{{ $pUrl }}">
                                    <input type="hidden" name="likes" value="{{ $pLikes }}">
                                    <input type="hidden" name="comments" value="{{ $pComments }}">

                                    <button type="submit" class="w-full py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-[11px] font-bold rounded-lg shadow-sm transition">
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

                @if(isset($postsPaginator) && $postsPaginator->hasPages())
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        {{ $postsPaginator->links() }}
                    </div>
                @endif
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
                                    data: [
                                        parseFloat("{{ str_replace('%', '', $insights['male_pct'] ?? '41.8') }}"),
                                        parseFloat("{{ str_replace('%', '', $insights['female_pct'] ?? '58.2') }}"),
                                        parseFloat("{{ str_replace('%', '', $insights['other_pct'] ?? '0.0') }}")
                                    ],
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

    <!-- Upload Meta Export ZIP Modal -->
    <div id="modalUploadZip" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-2xl relative">
            <button type="button" onclick="closeUploadModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 font-bold text-lg p-2 rounded-xl transition">✕</button>
            
            <div class="flex items-center space-x-3.5 mb-5">
                <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center text-2xl shadow-sm shrink-0">📁</div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-heading">Import Data Ekspor Instagram</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Unggah file .ZIP / .JSON dari Meta Accounts Center (Hingga 2GB+)</p>
                </div>
            </div>

            <!-- Help Notice -->
            <div class="p-3 bg-purple-50/60 border border-purple-200/80 rounded-xl text-[11px] text-purple-900 leading-relaxed mb-4">
                💡 <strong>Tips Meta Accounts Center:</strong> <em>"You can download your Instagram data through the Meta Accounts Center by going to your information settings."</em>
            </div>

            <form id="igZipUploadFormModal" class="space-y-4">
                @csrf
                <div class="relative">
                    <input type="file" id="export_file_modal" name="export_file" accept=".zip,.json" class="hidden" onchange="handleModalFileSelected(this)">
                    <label for="export_file_modal" class="w-full flex flex-col items-center justify-center p-6 bg-slate-50 hover:bg-slate-100 border-2 border-dashed border-purple-500/40 text-slate-700 text-xs font-bold rounded-2xl cursor-pointer transition shadow-sm group">
                        <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📦</span>
                        <span id="selectedModalFileName" class="text-slate-800 font-bold text-center">Pilih File .ZIP / .JSON Ekspor (Ukuran Besar 700MB+)</span>
                        <span class="text-[10px] text-slate-400 font-normal mt-1">Sistem otomatis memotong & mengunggah bertahap (Chunked Resumable Upload)</span>
                    </label>
                </div>

                <button type="submit" id="btnSubmitZipModal" class="w-full py-3.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl shadow-lg transition hidden">
                    🚀 Upload & Ekstrak Data Ke Database
                </button>
            </form>

            <!-- Progress Bar Component for Modal -->
            <div id="uploadProgressContainerModal" class="hidden space-y-2 pt-3">
                <div class="flex items-center justify-between text-xs font-semibold">
                    <span id="progressStatusTextModal" class="text-slate-700 font-mono">Mengunggah file zip...</span>
                    <span id="progressPercentTextModal" class="text-purple-700 font-bold">0%</span>
                </div>
                <div class="w-full bg-slate-200 h-3 rounded-full overflow-hidden shadow-inner">
                    <div id="uploadProgressBarModal" class="bg-gradient-to-r from-purple-600 to-pink-500 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <div id="progressStepSubtextModal" class="text-[10px] text-slate-400 font-mono text-center">Proses ekstraksi JSON & penyimpanan ke database PostgreSQL</div>
            </div>
        </div>
    </div>

    <!-- JavaScript Upload Progress Bar & Meta Export ZIP Import Handler -->
    <script>
        function openUploadModal() {
            const modal = document.getElementById('modalUploadZip');
            if (modal) modal.classList.remove('hidden');
        }

        function closeUploadModal() {
            const modal = document.getElementById('modalUploadZip');
            if (modal) modal.classList.add('hidden');
        }

        function handleFileSelected(input) {
            const fileNameSpan = document.getElementById('selectedFileName');
            const btnSubmit = document.getElementById('btnSubmitZip');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (fileNameSpan) {
                    fileNameSpan.textContent = file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
                }
                if (btnSubmit) {
                    btnSubmit.classList.remove('hidden');
                }
            }
        }

        function handleModalFileSelected(input) {
            const fileNameSpan = document.getElementById('selectedModalFileName');
            const btnSubmit = document.getElementById('btnSubmitZipModal');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (fileNameSpan) {
                    fileNameSpan.textContent = file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
                }
                if (btnSubmit) {
                    btnSubmit.classList.remove('hidden');
                }
            }
        }

        async function executeChunkedUpload(fileInput, progressContainer, progressBar, progressPercent, progressStatus, progressSubtext, btnSubmit) {
            if (!fileInput || !fileInput.files[0]) {
                alert('Harap pilih file .zip atau .json terlebih dahulu.');
                return;
            }

            const file = fileInput.files[0];
            const csrfToken = document.querySelector('input[name="_token"]')?.value || '';

            if (progressContainer) progressContainer.classList.remove('hidden');
            if (btnSubmit) btnSubmit.disabled = true;

            const CHUNK_SIZE = 2 * 1024 * 1024; // 2 MB per chunk slice
            const totalChunks = Math.ceil(file.size / CHUNK_SIZE);
            const fileId = 'ig_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

            try {
                for (let i = 0; i < totalChunks; i++) {
                    const start = i * CHUNK_SIZE;
                    const end = Math.min(start + CHUNK_SIZE, file.size);
                    const chunkBlob = file.slice(start, end);

                    const formData = new FormData();
                    formData.append('_token', csrfToken);
                    formData.append('file_chunk', chunkBlob, file.name);
                    formData.append('file_id', fileId);
                    formData.append('chunk_index', i);
                    formData.append('total_chunks', totalChunks);
                    formData.append('file_name', file.name);

                    const response = await fetch('{{ route("instagram.upload-chunk") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        let errMessage = 'Gagal mengunggah bagian ' + (i + 1) + ' (Status: ' + response.status + ')';
                        try {
                            const errJson = await response.json();
                            if (errJson.message) errMessage = errJson.message;
                        } catch (e) {}
                        throw new Error(errMessage);
                    }

                    const result = await response.json();
                    const percentComplete = Math.round(((i + 1) / totalChunks) * 100);

                    if (progressBar) progressBar.style.width = percentComplete + '%';
                    if (progressPercent) progressPercent.textContent = percentComplete + '%';

                    if (i < totalChunks - 1) {
                        if (progressStatus) progressStatus.textContent = 'Mengunggah bagian ' + (i + 1) + ' dari ' + totalChunks + ' (' + percentComplete + '%)...';
                    } else {
                        if (progressStatus) progressStatus.textContent = '⚡ Ekstraksi ZIP & Simpan ke DB Sukses!';
                        if (progressSubtext) progressSubtext.textContent = 'Memuat ulang dashboard analitik...';

                        setTimeout(function () {
                            window.location.href = result.redirect || '{{ route("dashboard") }}';
                        }, 1200);
                    }
                }
            } catch (err) {
                alert('Gagal mengunggah file ZIP: ' + err.message);
                if (btnSubmit) btnSubmit.disabled = false;
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Onboarding Form Listener
            const uploadForm = document.getElementById('igZipUploadForm');
            if (uploadForm) {
                uploadForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    executeChunkedUpload(
                        document.getElementById('export_file'),
                        document.getElementById('uploadProgressContainer'),
                        document.getElementById('uploadProgressBar'),
                        document.getElementById('progressPercentText'),
                        document.getElementById('progressStatusText'),
                        document.getElementById('progressStepSubtext'),
                        document.getElementById('btnSubmitZip')
                    );
                });
            }

            // Modal Form Listener
            const uploadFormModal = document.getElementById('igZipUploadFormModal');
            if (uploadFormModal) {
                uploadFormModal.addEventListener('submit', function (e) {
                    e.preventDefault();
                    executeChunkedUpload(
                        document.getElementById('export_file_modal'),
                        document.getElementById('uploadProgressContainerModal'),
                        document.getElementById('uploadProgressBarModal'),
                        document.getElementById('progressPercentTextModal'),
                        document.getElementById('progressStatusTextModal'),
                        document.getElementById('progressStepSubtextModal'),
                        document.getElementById('btnSubmitZipModal')
                    );
                });
            }
        });
    </script>
</x-app-layout>

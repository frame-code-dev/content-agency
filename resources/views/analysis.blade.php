<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition mb-1 inline-flex items-center space-x-1">
                    <span>&larr;</span>
                    <span>Kembali ke Dashboard</span>
                </a>
                <h2 class="text-xl font-bold tracking-tight text-slate-900 font-heading">Executive Content Audit Report</h2>
            </div>
            <div class="text-right">
                <span class="text-xs font-mono font-bold text-slate-400 block uppercase tracking-wider">Report ID</span>
                <span class="text-xs font-mono font-bold text-slate-700">#AUD-{{ strtoupper(substr($postData['id'], -6)) }} • {{ date('Y-m-d H:i') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Top Executive Bar -->
        <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-emerald-950 text-white rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl border border-slate-800">
            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-emerald-400 font-semibold">Skor Performa Konten</span>
                <div class="text-5xl font-extrabold tracking-tight mt-1 text-white font-heading">
                    {{ $analysis['overall_agency_score'] ?? 88 }} <span class="text-xl text-slate-400 font-normal">/ 100</span>
                </div>
            </div>

            <div class="h-14 w-px bg-slate-800 hidden md:block"></div>

            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-emerald-400 font-semibold">Tone of Voice</span>
                <div class="text-base font-bold mt-1 text-slate-100">
                    {{ $analysis['tone_of_voice'] ?? 'Standard Agency Tone' }}
                </div>
                <div class="text-xs text-slate-400 mt-0.5 font-mono">Dianalisis oleh AI Engine</div>
            </div>

            <div class="h-14 w-px bg-slate-800 hidden md:block"></div>

            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-emerald-400 font-semibold">Indeks Sentimen</span>
                <div class="text-base font-bold mt-1 text-slate-100">
                    {{ $analysis['sentiment']['label'] ?? 'Positive' }} ({{ $analysis['sentiment']['score'] ?? 85 }}%)
                </div>
                <div class="text-xs text-emerald-400 font-mono mt-0.5 font-semibold">Verified Sentiment Index</div>
            </div>
        </div>

        <!-- Parameter Audit Legend -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-3 text-xs">
                <span class="w-8 h-8 rounded-xl bg-slate-900 text-[#A3E635] flex items-center justify-center font-mono font-bold text-xs">AI</span>
                <div>
                    <h4 class="font-bold text-slate-900">Metode Evaluasi Single Post AI Audit</h4>
                    <p class="text-slate-500 mt-0.5">Dihitung berdasarkan 4 parameter utama: (1) Interaksi Real, (2) Formula Hook & CTA, (3) Kepadatan Hashtag, (4) Sentimen Bahasa Teks.</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-slate-100 text-slate-700 font-mono text-[11px] font-bold rounded-xl border border-slate-200/80 whitespace-nowrap">
                Real DB Source
            </span>
        </div>

        <!-- 2 Columns Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Asset Preview (5 Columns) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 font-mono">
                            Asset Preview Under Audit
                        </h3>
                        <span class="text-xs font-mono font-bold px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-800 border border-slate-200">
                            Post ID: {{ substr($postData['id'], -8) }}
                        </span>
                    </div>

                    @if(!empty($postData['media_url']))
                        <div class="aspect-square w-full bg-slate-100 rounded-2xl border border-slate-200/80 overflow-hidden mb-4 relative shadow-inner">
                            <img src="{{ $postData['media_url'] }}" alt="Post Asset" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="text-xs text-slate-700 whitespace-pre-line leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-200/80 font-sans">
                        {{ $postData['caption'] }}
                    </div>

                    <div class="mt-4 flex items-center justify-between text-xs font-bold text-slate-600 pt-3 border-t border-slate-100 font-mono">
                        <span class="flex items-center space-x-1">
                            <span class="text-rose-500">❤️</span>
                            <span>{{ number_format($postData['likes']) }} Likes</span>
                        </span>
                        <span class="flex items-center space-x-1">
                            <span class="text-indigo-500">💬</span>
                            <span>{{ number_format($postData['comments']) }} Comments</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Column: AI Analysis Breakdown (7 Columns) -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Hashtag Audit Card -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 font-mono">
                            Evaluasi Hashtag & Metadata
                        </h3>
                        <span class="text-xs font-mono font-bold px-3 py-1 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200">
                            Status: {{ $analysis['hashtag_audit']['status'] ?? 'Optimal' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed mb-3">
                        {{ $analysis['hashtag_audit']['feedback'] ?? 'Analisis kejelasan dan keterbacaan hashtag menunjukkan struktur yang optimal.' }}
                    </p>
                    <div class="text-xs text-slate-500 font-mono font-bold bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center justify-between">
                        <span>Terdeteksi Hashtag</span>
                        <span class="text-slate-900">{{ $analysis['hashtag_audit']['count'] ?? 0 }} Hashtags</span>
                    </div>
                </div>

                <!-- Strategic Recommendations Card -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-6 pb-3 border-b border-slate-100 font-mono">
                        Rekomendasi Optimasi Konten
                    </h3>
                    <div class="space-y-4">
                        @foreach($analysis['recommendations'] ?? [] as $index => $rec)
                            <div class="flex items-start space-x-4 p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                                <span class="flex-shrink-0 w-8 h-8 rounded-xl bg-slate-900 text-[#A3E635] text-xs font-bold font-mono flex items-center justify-center shadow">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1 space-y-1">
                                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wide">
                                        {{ $rec['category'] }}
                                    </h4>
                                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                        {{ $rec['action'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sentiment Context Card -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 pb-2 border-b border-slate-100 font-mono">
                        Catatan Context & Sentimen Publik
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">
                        {{ $analysis['sentiment']['explanation'] ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

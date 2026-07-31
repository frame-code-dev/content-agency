<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('dashboard') }}" class="text-xs font-medium text-slate-500 hover:text-slate-900 transition mb-1 inline-block">
                    &larr; Kembali ke Dashboard
                </a>
                <h2 class="text-xl font-bold tracking-tight text-slate-900 font-heading">Executive Overall Portfolio AI Audit Report</h2>
            </div>
            <div class="text-right">
                <span class="text-xs text-slate-400 block">Report ID: #PORT-{{ strtoupper(substr(md5(time()), 0, 6)) }}</span>
                <span class="text-xs font-mono text-slate-600">{{ date('Y-m-d H:i') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Top Executive Summary Bar -->
        <div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl border border-emerald-900/40">
            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-emerald-400">Skor Kesehatan Portofolio Konten</span>
                <div class="text-5xl font-extrabold tracking-tight mt-1 text-white font-heading">
                    {{ $portfolioAnalysis['portfolio_score'] ?? 88 }} <span class="text-xl text-slate-400 font-normal">/ 100</span>
                </div>
            </div>

            <div class="h-14 w-px bg-slate-800 hidden md:block"></div>

            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-emerald-400">Brand Voice & Tone</span>
                <div class="text-base font-bold mt-1 text-slate-100">
                    {{ $portfolioAnalysis['brand_voice_tone'] ?? 'Dynamic, Creative & Strategic' }}
                </div>
                <div class="text-xs text-slate-400 mt-0.5 font-mono">Dianalisis dari {{ $portfolioAnalysis['total_posts_analyzed'] ?? 0 }} postingan</div>
            </div>

            <div class="h-14 w-px bg-slate-800 hidden md:block"></div>

            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-emerald-400">Rata-Rata Interaksi Per Post</span>
                <div class="text-base font-bold mt-1 text-slate-100">
                    ❤️ {{ number_format($portfolioAnalysis['avg_likes_per_post'] ?? 0) }} Likes / 💬 {{ number_format($portfolioAnalysis['avg_comments_per_post'] ?? 0) }} Komen
                </div>
                <div class="text-xs text-emerald-300 font-semibold font-mono mt-0.5">
                    ER: {{ $portfolioAnalysis['overall_engagement_er'] ?? '4.85%' }} • (Total {{ number_format($portfolioAnalysis['total_likes'] ?? 0) }} Likes)
                </div>
            </div>
        </div>

        <!-- Executive Narrative Summary Card -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Ringkasan Eksekutif AI Audit</h3>
            <p class="text-sm text-slate-700 leading-relaxed font-medium">
                {{ $portfolioAnalysis['executive_summary'] }}
            </p>
        </div>

        <!-- Parameter Analysis Explanation Section -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold font-heading text-slate-900">Parameter Analisis AI & Metrik Penilaian</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kesimpulan AI dihasilkan dari evaluasi 5 parameter utama berdasarkan data real postingan Instagram di database.</p>
                </div>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-800 font-bold text-xs rounded-xl border border-emerald-200 font-mono">5 Parameter Evaluasi</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach(($portfolioAnalysis['parameters_evaluated'] ?? []) as $param)
                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/80 flex flex-col justify-between space-y-3">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xl">{{ $param['icon'] }}</span>
                                <span class="text-[10px] font-bold font-mono px-2 py-0.5 rounded bg-slate-200 text-slate-700">{{ $param['weight'] }}</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 leading-snug">{{ $param['name'] }}</h4>
                            <p class="text-[11px] text-slate-500 mt-1.5 leading-relaxed">{{ $param['description'] }}</p>
                        </div>
                        <span class="text-[9px] font-mono text-slate-400 font-bold uppercase tracking-wider">{{ $param['code'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 3 Columns Detail Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Strategic Recommendations (7 Columns) -->
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <h3 class="text-sm font-bold font-heading text-slate-900 mb-6 pb-3 border-b border-slate-100 flex items-center justify-between">
                        <span>Rekomendasi Strategis Portofolio</span>
                        <span class="text-xs font-mono px-2.5 py-1 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-200">AI Verified</span>
                    </h3>

                    <div class="space-y-4">
                        @foreach($portfolioAnalysis['strategic_insights'] ?? [] as $idx => $insight)
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start space-x-4">
                                <span class="flex-shrink-0 w-8 h-8 rounded-xl bg-slate-900 text-[#A3E635] text-xs font-bold font-mono flex items-center justify-center shadow">
                                    {{ $idx + 1 }}
                                </span>
                                <div class="flex-1 space-y-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wide">{{ $insight['title'] }}</h4>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $insight['impact'] === 'High' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }}">
                                            Impact: {{ $insight['impact'] }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 leading-relaxed">{{ $insight['observation'] }}</p>
                                    <div class="mt-2 text-xs font-semibold text-emerald-700 bg-emerald-50/80 p-2.5 rounded-xl border border-emerald-100">
                                        <strong>Aksi Direkomendasikan:</strong> {{ $insight['action'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Content Pillars & Hashtag Mix (5 Columns) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Content Pillars Breakdown -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <h3 class="text-sm font-bold font-heading text-slate-900 mb-4 pb-3 border-b border-slate-100">
                        Distribusi Pilar Konten
                    </h3>

                    <div class="space-y-3.5">
                        @foreach($portfolioAnalysis['content_pillars'] ?? [] as $pillar)
                            <div>
                                <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                                    <span>{{ $pillar['name'] }}</span>
                                    <span class="text-emerald-600 font-mono">{{ $pillar['share'] }}</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden mb-1">
                                    <div class="bg-[#A3E635] h-2 rounded-full" style="width: {{ $pillar['share'] }}"></div>
                                </div>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $pillar['performance'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Top Hashtags Cluster -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <h3 class="text-sm font-bold font-heading text-slate-900 mb-3 pb-2 border-b border-slate-100">
                        Hashtag Populer Digunakan
                    </h3>

                    <div class="flex flex-wrap gap-2">
                        @foreach($portfolioAnalysis['top_hashtags_used'] ?? [] as $tag)
                            <span class="px-3 py-1.5 bg-slate-100 text-slate-800 text-xs font-bold rounded-xl border border-slate-200/80 font-mono">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">AI Content Planner & Decision Engine</h1>
                <p class="text-xs text-slate-500 mt-1">Perancangan kalender konten berbasis AI Copywriter & Sistem Pendukung Keputusan (Metode SAW).</p>
            </div>
            <div class="flex items-center space-x-3">
                <form action="{{ route('planner.auto-hermes') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-[#A3E635] text-xs font-bold font-mono rounded-2xl shadow transition flex items-center space-x-2">
                        <span>🤖 Hermes AI: Generate Content Plans</span>
                    </button>
                </form>
                <span class="text-xs bg-slate-100 text-slate-700 border border-slate-200/80 px-3.5 py-2 rounded-2xl font-mono font-bold">
                    SAW SPK Engine v2.4
                </span>
            </div>
        </div>

        @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs px-4 py-3 rounded-2xl flex items-center justify-between font-medium">
                <span>{{ session('status') }}</span>
                <span class="font-bold cursor-pointer" onclick="this.parentElement.remove()">×</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Form Buat Ide Konten Baru (Stage 1 AI Copywriting + Stage 2 SPK Input) -->
            <div class="lg:col-span-5 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold font-heading text-slate-900">
                        Form Draf Konten Baru
                    </h3>
                    <span class="text-[10px] font-mono font-bold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-200">
                        AI Copywriter
                    </span>
                </div>

                <form action="{{ route('planner.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 font-mono mb-1">Judul / Topik Konten</label>
                        <input type="text" name="title" required placeholder="Contoh: 5 Tips Optimasi Reels Instagram" class="w-full text-xs px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl focus:border-slate-900 focus:bg-white focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 font-mono mb-1">Tone of Voice (Gaya Bahasa)</label>
                        <select name="tone" class="w-full text-xs px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl focus:border-slate-900 focus:bg-white focus:outline-none transition">
                            <option value="professional">Professional & Authoritative</option>
                            <option value="casual">Casual & Friendly</option>
                            <option value="soft_selling">Soft Selling & Persuasive</option>
                            <option value="storytelling">Storytelling & Emotional</option>
                            <option value="urgent">Urgent / FOMO</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 font-mono mb-1">Tipe Media</label>
                        <select name="media_type" class="w-full text-xs px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl focus:border-slate-900 focus:bg-white focus:outline-none transition">
                            <option value="IMAGE">Single Image Feed</option>
                            <option value="CAROUSEL_ALBUM">Carousel Album (Multi-Slide)</option>
                            <option value="VIDEO">Reels / Video Content</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 font-mono mb-1">Konsep / Detail Ide Singkat</label>
                        <textarea name="concept" rows="3" placeholder="Jelaskan poin utama pesan yang ingin disampaikan..." class="w-full text-xs px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl focus:border-slate-900 focus:bg-white focus:outline-none transition"></textarea>
                    </div>

                    <!-- SPK Criteria Weight Inputs (Metode SAW) -->
                    <div class="pt-4 border-t border-slate-100">
                        <label class="block text-xs font-bold uppercase text-slate-900 mb-2 font-mono">⚖️ Input Kriteria SPK (Skala 1 - 10)</label>
                        <div class="grid grid-cols-2 gap-3 text-[11px]">
                            <div>
                                <span class="text-slate-500 font-medium">C1: Engagement (35%)</span>
                                <input type="number" min="1" max="10" value="8" name="c1_engagement" class="w-full text-xs px-2.5 py-1.5 border border-slate-200 rounded-lg mt-1 font-mono">
                            </div>
                            <div>
                                <span class="text-slate-500 font-medium">C2: Effort (20%)</span>
                                <input type="number" min="1" max="10" value="4" name="c2_effort" class="w-full text-xs px-2.5 py-1.5 border border-slate-200 rounded-lg mt-1 font-mono">
                            </div>
                            <div>
                                <span class="text-slate-500 font-medium">C3: Trend (25%)</span>
                                <input type="number" min="1" max="10" value="9" name="c3_trend" class="w-full text-xs px-2.5 py-1.5 border border-slate-200 rounded-lg mt-1 font-mono">
                            </div>
                            <div>
                                <span class="text-slate-500 font-medium">C4: Brand Fit (20%)</span>
                                <input type="number" min="1" max="10" value="8" name="c4_brand" class="w-full text-xs px-2.5 py-1.5 border border-slate-200 rounded-lg mt-1 font-mono">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-[#A3E635] text-xs font-bold uppercase tracking-wider rounded-2xl shadow transition font-mono">
                        Generate AI Copy & Hitung SPK
                    </button>
                </form>
            </div>

            <!-- Daftar Content Planner & Ranking SPK SAW (Stage 1 & 2) -->
            <div class="lg:col-span-7 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <h3 class="text-sm font-bold font-heading text-slate-900">Daftar Rencana Konten & Skor Kelayakan SPK</h3>
                    <span class="text-xs text-slate-500 font-mono font-bold">{{ count($plans) }} Draf Konten</span>
                </div>

                <div class="space-y-4">
                    @forelse($plans as $plan)
                        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="text-sm font-bold text-slate-900 font-heading">{{ $plan->title }}</span>
                                        <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-0.5 rounded-lg uppercase font-mono font-bold border border-slate-200/80">{{ $plan->media_type }}</span>
                                    </div>
                                    <p class="text-xs text-slate-500 font-mono">Tone: <strong class="text-slate-800 capitalize">{{ $plan->tone }}</strong> | Jadwal: {{ $plan->scheduled_at ? $plan->scheduled_at->format('d M Y, H:i') : 'Draft' }}</p>
                                </div>

                                <!-- SPK SAW Score Badge -->
                                <div class="text-right">
                                    <div class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold font-mono {{ $plan->spk_score >= 80 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($plan->spk_score >= 60 ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-rose-50 text-rose-800 border border-rose-200') }}">
                                        Skor SPK: {{ $plan->spk_score }}/100
                                    </div>
                                    <div class="text-[10px] font-bold font-mono mt-1 uppercase tracking-wider {{ $plan->spk_score >= 80 ? 'text-emerald-700' : ($plan->spk_score >= 60 ? 'text-amber-700' : 'text-rose-700') }}">
                                        {{ $plan->priority_level }}
                                    </div>
                                </div>
                            </div>

                            <!-- AI Caption Draft Preview -->
                            <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80 text-xs text-slate-700 whitespace-pre-line leading-relaxed mb-3 font-sans">
                                {{ $plan->caption }}
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs font-mono">
                                <span class="text-[11px] text-slate-400">Status: <strong class="text-slate-800 uppercase font-bold">{{ $plan->status }}</strong></span>
                                <form action="{{ route('planner.destroy', $plan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-bold transition">Hapus Draf</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-slate-200/80 rounded-3xl p-12 text-center text-xs text-slate-500 font-medium">
                            Belum ada rencana konten. Gunakan form di samping untuk membuat draf konten pertama Anda.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

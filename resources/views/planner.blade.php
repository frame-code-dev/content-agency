<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Page Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-neutral-900 tracking-tight">AI Content Planner & SPK Decision Engine</h1>
                <p class="text-xs text-neutral-500 mt-1">Perancangan kalender konten berbasis AI Copywriter & Sistem Pendukung Keputusan (Metode SAW).</p>
            </div>
            <div class="flex items-center space-x-3">
                <form action="{{ route('planner.auto-hermes') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-3 py-1.5 rounded uppercase tracking-wider transition shadow-sm">
                        🤖 Hermes AI Agent: Generate Live Content Plans
                    </button>
                </form>
                <span class="text-xs bg-neutral-900 text-white px-3 py-1.5 rounded font-mono font-medium shadow-sm">
                    Hermes AI Agent v2.4 Engine
                </span>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs px-4 py-3 rounded flex items-center justify-between">
                <span>{{ session('status') }}</span>
                <span class="font-bold cursor-pointer" onclick="this.parentElement.remove()">×</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Buat Ide Konten Baru (Stage 1 AI Copywriting + Stage 2 SPK Input) -->
            <div class="bg-white border border-neutral-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-neutral-900 mb-4 pb-3 border-b border-neutral-100 flex items-center justify-between">
                    <span>✨ Form Draf Konten Baru</span>
                    <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded font-medium uppercase">AI Powered</span>
                </h3>

                <form action="{{ route('planner.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold uppercase text-neutral-700 mb-1">Judul / Topik Konten</label>
                        <input type="text" name="title" required placeholder="Contoh: 5 Tips Optimasi Reels Instagram" class="w-full text-xs px-3 py-2 border border-neutral-300 rounded focus:border-neutral-900 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-neutral-700 mb-1">Tone of Voice (Gaya Bahasa)</label>
                        <select name="tone" class="w-full text-xs px-3 py-2 border border-neutral-300 rounded focus:border-neutral-900 focus:outline-none">
                            <option value="professional">Professional & Authoritative</option>
                            <option value="casual">Casual & Friendly</option>
                            <option value="soft_selling">Soft Selling & Persuasive</option>
                            <option value="storytelling">Storytelling & Emotional</option>
                            <option value="urgent">Urgent / FOMO</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-neutral-700 mb-1">Tipe Media</label>
                        <select name="media_type" class="w-full text-xs px-3 py-2 border border-neutral-300 rounded focus:border-neutral-900 focus:outline-none">
                            <option value="IMAGE">Single Image Feed</option>
                            <option value="CAROUSEL_ALBUM">Carousel Album (Multi-Slide)</option>
                            <option value="VIDEO">Reels / Video Content</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-neutral-700 mb-1">Konsep / Detail Ide Singkat</label>
                        <textarea name="concept" rows="3" placeholder="Jelaskan poin utama pesan yang ingin disampaikan..." class="w-full text-xs px-3 py-2 border border-neutral-300 rounded focus:border-neutral-900 focus:outline-none"></textarea>
                    </div>

                    <!-- SPK Criteria Weight Inputs (Metode SAW) -->
                    <div class="pt-3 border-t border-neutral-100">
                        <label class="block text-xs font-bold uppercase text-neutral-900 mb-2">⚖️ Input Kriteria SPK (Skala 1 - 10)</label>
                        <div class="grid grid-cols-2 gap-3 text-[11px]">
                            <div>
                                <span class="text-neutral-600">C1: Potensi Engagement (35%)</span>
                                <input type="number" min="1" max="10" value="8" name="c1_engagement" class="w-full text-xs px-2.5 py-1.5 border border-neutral-300 rounded mt-1">
                            </div>
                            <div>
                                <span class="text-neutral-600">C2: Effort Produksi (20%)</span>
                                <input type="number" min="1" max="10" value="4" name="c2_effort" class="w-full text-xs px-2.5 py-1.5 border border-neutral-300 rounded mt-1">
                            </div>
                            <div>
                                <span class="text-neutral-600">C3: Trending Topic (25%)</span>
                                <input type="number" min="1" max="10" value="9" name="c3_trend" class="w-full text-xs px-2.5 py-1.5 border border-neutral-300 rounded mt-1">
                            </div>
                            <div>
                                <span class="text-neutral-600">C4: Brand Voice Fit (20%)</span>
                                <input type="number" min="1" max="10" value="8" name="c4_brand" class="w-full text-xs px-2.5 py-1.5 border border-neutral-300 rounded mt-1">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-neutral-900 hover:bg-neutral-800 text-white text-xs font-semibold uppercase tracking-wider rounded transition">
                        Generate AI Copy & Hitung SPK
                    </button>
                </form>
            </div>

            <!-- Daftar Content Planner & Ranking SPK SAW (Stage 1 & 2) -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-neutral-200">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-neutral-900">Daftar Rencana Konten & Skor Kelayakan SPK</h3>
                    <span class="text-xs text-neutral-500">{{ count($plans) }} Draf Konten</span>
                </div>

                <div class="space-y-4">
                    @forelse($plans as $plan)
                        <div class="bg-white border border-neutral-200 rounded-lg p-5 shadow-sm hover:border-neutral-400 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="text-xs font-bold text-neutral-900">{{ $plan->title }}</span>
                                        <span class="text-[10px] bg-neutral-100 text-neutral-700 px-2 py-0.5 rounded uppercase font-mono">{{ $plan->media_type }}</span>
                                    </div>
                                    <p class="text-xs text-neutral-500">Tone: <strong class="text-neutral-800 capitalize">{{ $plan->tone }}</strong> | Jadwal: {{ $plan->scheduled_at ? $plan->scheduled_at->format('d M Y, H:i') : 'Draft' }}</p>
                                </div>

                                <!-- SPK SAW Score Badge -->
                                <div class="text-right">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded text-xs font-bold font-mono {{ $plan->spk_score >= 80 ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : ($plan->spk_score >= 60 ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-rose-100 text-rose-800 border border-rose-200') }}">
                                        Skor SPK: {{ $plan->spk_score }}/100
                                    </div>
                                    <div class="text-[10px] font-semibold mt-1 uppercase tracking-wider {{ $plan->spk_score >= 80 ? 'text-emerald-600' : ($plan->spk_score >= 60 ? 'text-amber-600' : 'text-rose-600') }}">
                                        🌟 {{ $plan->priority_level }}
                                    </div>
                                </div>
                            </div>

                            <!-- AI Caption Draft Preview -->
                            <div class="bg-neutral-50 p-3.5 rounded border border-neutral-100 text-xs text-neutral-700 whitespace-pre-line leading-relaxed mb-3">
                                {{ $plan->caption }}
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between pt-2 border-t border-neutral-100 text-xs">
                                <span class="text-[11px] text-neutral-400">Status: <strong class="text-neutral-700 uppercase">{{ $plan->status }}</strong></span>
                                <form action="{{ route('planner.destroy', $plan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-medium">Hapus Draf</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-neutral-200 rounded-lg p-12 text-center text-xs text-neutral-500">
                            Belum ada rencana konten. Gunakan form di samping untuk membuat draf konten pertama Anda.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

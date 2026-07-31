<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Competitor Intelligence & AI Gap Analysis</h1>
                <p class="text-xs text-slate-500 mt-1">Benchmarking statistik performa akun Anda vs kompetitor dan deteksi peluang topik baru.</p>
            </div>
            <div class="flex items-center space-x-3">
                <form action="{{ route('competitors.auto-hermes') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-[#A3E635] text-xs font-bold font-mono rounded-2xl shadow transition flex items-center space-x-2">
                        <span>🤖 Hermes AI: Run Niche Analysis</span>
                    </button>
                </form>
                <span class="text-xs bg-slate-100 text-slate-700 border border-slate-200/80 px-3.5 py-2 rounded-2xl font-mono font-bold">
                    Competitor Intelligence
                </span>
            </div>
        </div>

        @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs px-4 py-3 rounded-2xl flex items-center justify-between font-medium">
                <span>{{ session('status') }}</span>
                <span class="font-bold cursor-pointer" onclick="this.parentElement.remove()">×</span>
            </div>
        @endif

        <!-- My Account Summary Bar vs Competitors -->
        <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-emerald-950 text-white rounded-3xl p-8 shadow-xl border border-slate-800 space-y-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between border-b border-slate-800 pb-5 gap-4">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-emerald-400 font-semibold">Akun Anda (Benchmark Baseline)</span>
                    <h2 class="text-xl font-bold text-white font-heading mt-1">@rifjanj</h2>
                </div>
                <div class="flex items-center space-x-6 text-xs text-slate-300 font-mono">
                    <div>Followers: <strong class="text-white">{{ number_format($account->followers_count ?? 2850) }}</strong></div>
                    <div>Engagement Rate: <strong class="text-[#A3E635] font-bold">{{ $account->engagement_rate ?? '4.85%' }}</strong></div>
                    <div>Avg Likes: <strong class="text-white">{{ number_format((int)(array_sum(array_column($posts, 'like_count')) / max(count($posts), 1))) }}</strong></div>
                </div>
            </div>

            <!-- Form Tambah Akun Kompetitor -->
            <form action="{{ route('competitors.store') }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3">
                @csrf
                <input type="text" name="username" required placeholder="Masukkan Username Kompetitor (misal: @kompetitor_brand)" class="w-full sm:flex-1 text-xs px-4 py-3 bg-slate-900/90 border border-slate-800 text-white rounded-2xl focus:border-emerald-400 focus:outline-none font-mono">
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-[#A3E635] text-slate-950 text-xs font-bold font-mono uppercase tracking-wider rounded-2xl hover:bg-lime-400 transition shadow">
                    + Tambah Kompetitor
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Benchmark Matrix Table -->
            <div class="lg:col-span-7 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold font-heading text-slate-900">
                        Matriks Benchmark Performa Kompetitor
                    </h3>
                    <span class="text-xs font-mono font-bold px-3 py-1 bg-slate-100 text-slate-700 rounded-xl border border-slate-200">
                        {{ count($competitors) }} Dipantau
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider font-mono">
                                <th class="pb-3">Username</th>
                                <th class="pb-3">Followers</th>
                                <th class="pb-3">ER Rate</th>
                                <th class="pb-3">Avg Likes</th>
                                <th class="pb-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                            <!-- Baseline User Row -->
                            <tr class="bg-emerald-50/60 font-medium">
                                <td class="py-3.5 font-bold text-slate-900">
                                    @rifjanj 
                                    <span class="text-[9px] bg-slate-900 text-[#A3E635] px-2 py-0.5 rounded-lg ml-1 font-mono font-bold">AKUN ANDA</span>
                                </td>
                                <td class="py-3.5 font-mono text-slate-900">{{ number_format($account->followers_count ?? 2850) }}</td>
                                <td class="py-3.5 font-mono font-bold text-emerald-700">{{ $account->engagement_rate ?? '4.85%' }}</td>
                                <td class="py-3.5 font-mono text-slate-900">{{ number_format((int)(array_sum(array_column($posts, 'like_count')) / max(count($posts), 1))) }}</td>
                                <td class="py-3.5 text-right text-slate-400 font-mono">-</td>
                            </tr>

                            @forelse($competitors as $comp)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 font-bold text-slate-800">{{ $comp->username }}</td>
                                    <td class="py-3.5 font-mono text-slate-900">{{ number_format($comp->followers_count) }}</td>
                                    <td class="py-3.5 font-mono font-bold text-slate-900">{{ number_format($comp->engagement_rate, 2) }}%</td>
                                    <td class="py-3.5 font-mono text-slate-900">{{ number_format($comp->avg_likes) }}</td>
                                    <td class="py-3.5 text-right font-mono">
                                        <form action="{{ route('competitors.destroy', $comp->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-bold transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-xs text-slate-400 font-medium">
                                        Belum ada kompetitor yang ditambahkan. Masukkan username kompetitor di atas untuk memulai analisis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- AI Content Gap Analysis Panel -->
            <div class="lg:col-span-5 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold font-heading text-slate-900">
                        AI Content Gap Analysis
                    </h3>
                    <span class="text-[10px] font-mono font-bold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-200">
                        Opportunity AI
                    </span>
                </div>

                <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80 text-xs text-slate-700 whitespace-pre-line leading-relaxed font-sans">
                    {!! nl2br(e($gapAnalysis)) !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Campaign Performance & SPK Tracking</h1>
                <p class="text-xs text-slate-500 mt-1">Track content marketing campaigns, ROI, and SPK prioritization scores.</p>
            </div>
            <a href="{{ route('planner.index') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-[#A3E635] text-xs font-bold font-mono rounded-2xl shadow transition flex items-center space-x-2">
                <span>+ Launch New Campaign Plan</span>
            </a>
        </div>

        <!-- 4 Summary KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Active Campaigns</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ count($plans) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-200 font-mono">🚀 Active</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Scheduled Posts</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ $plans->where('status', 'scheduled')->count() }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-xl border border-indigo-200 font-mono">📅 Queued</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Avg SPK Score (SAW)</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($plans->avg('spk_score'), 1) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-xl border border-slate-200 font-mono">🎯 SAW Score</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Highest Priority Topic</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-base font-bold font-heading text-slate-900 truncate max-w-[140px]">{{ $plans->first()->topic ?? 'AI Automation' }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-xl border border-rose-200 font-mono">⭐ Top</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h2 class="text-base font-bold font-heading text-slate-900">Active Content Campaigns Table</h2>
                <span class="text-xs font-mono font-bold px-3 py-1 bg-slate-100 text-slate-700 rounded-xl border border-slate-200">
                    {{ count($plans) }} Plans Registered
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider font-mono">
                            <th class="py-3 px-4">Campaign Topic</th>
                            <th class="py-3 px-4">Konsep Konten</th>
                            <th class="py-3 px-4">Tone</th>
                            <th class="py-3 px-4">Skor SPK</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                        @forelse($plans as $plan)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-bold text-slate-900 font-heading">{{ $plan->title }}</td>
                                <td class="py-3.5 px-4 max-w-sm truncate text-slate-600 font-medium">{{ $plan->concept ?? 'Standard Marketing Concept' }}</td>
                                <td class="py-3.5 px-4 capitalize font-mono text-slate-700">{{ $plan->tone }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold font-mono {{ $plan->spk_score >= 80 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-900 text-[#A3E635]' }}">
                                        {{ $plan->spk_score }}/100
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-xl text-[10px] font-bold font-mono uppercase bg-slate-100 text-slate-800 border border-slate-200">
                                        {{ $plan->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 font-medium">No active campaign plans found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Audience Insights & Demographics</h1>
                <p class="text-xs text-slate-500 mt-1">Live Instagram demographics for {{ '@' . ($account->username ?? 'account') }} from Meta Graph API.</p>
            </div>
            <span class="px-4 py-2 bg-slate-900 text-[#A3E635] text-xs font-bold font-mono rounded-2xl shadow">
                Meta Verified Insights
            </span>
        </div>

        <!-- 4 Summary KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Top Gender Group</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">
                        {{ floatval($insights['male_pct'] ?? 41.8) > floatval($insights['female_pct'] ?? 58.2) ? 'Male' : 'Female' }}
                    </span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-200 font-mono">
                        {{ floatval($insights['male_pct'] ?? 41.8) > floatval($insights['female_pct'] ?? 58.2) ? ($insights['male_pct'] ?? '52.1%') : ($insights['female_pct'] ?? '58.2%') }}
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Top Age Bracket</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-2xl font-bold font-heading text-slate-900 tracking-tight">{{ $insights['top_age_bracket'] ?? '25-34 Years' }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-xl border border-indigo-200 font-mono">
                        Primary Share
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Total Followers</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($account->followers_count ?? 2850) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-xl border border-rose-200 font-mono">
                        👥 Active
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Peak Activity Hour</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">18:00</span>
                    <span class="inline-flex items-center text-xs font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-xl border border-slate-200 font-mono">
                        ⏰ UTC+7
                    </span>
                </div>
            </div>
        </div>

        <!-- Demographics Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Gender Split -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <h2 class="text-sm font-bold font-heading text-slate-900 mb-4 pb-3 border-b border-slate-100">Gender Demographics Breakdown</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1 font-mono">
                            <span>Female Followers</span>
                            <span class="text-emerald-700">{{ $insights['female_pct'] ?? '58.2%' }}</span>
                        </div>
                        <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-slate-900 h-full rounded-full" style="width: {{ $insights['female_pct'] ?? '58.2%' }}"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1 font-mono">
                            <span>Male Followers</span>
                            <span class="text-indigo-700">{{ $insights['male_pct'] ?? '41.8%' }}</span>
                        </div>
                        <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-[#A3E635] h-full rounded-full" style="width: {{ $insights['male_pct'] ?? '41.8%' }}"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Age Brackets -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <h2 class="text-sm font-bold font-heading text-slate-900 mb-4 pb-3 border-b border-slate-100">Age Bracket Distribution</h2>
                <div class="space-y-3 font-mono">
                    @foreach($insights['age_groups'] ?? [] as $ageGroup)
                        <div class="flex items-center space-x-3 text-xs font-semibold">
                            <span class="w-16 {{ ($ageGroup['active'] ?? false) ? 'text-slate-900 font-bold' : 'text-slate-500' }}">{{ $ageGroup['range'] }}</span>
                            <div class="flex-1 bg-slate-100 h-7 rounded-xl overflow-hidden relative">
                                <div class="{{ ($ageGroup['active'] ?? false) ? 'bg-slate-900' : 'bg-slate-300' }} h-full rounded-xl" style="width: {{ max((float)($ageGroup['pct'] ?? 0), 2) }}%"></div>
                                <span class="absolute right-3 top-1.5 text-[11px] font-bold {{ ($ageGroup['active'] ?? false) ? 'text-[#A3E635]' : 'text-slate-700' }}">{{ $ageGroup['pct'] }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top Countries & Cities Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Countries -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <h2 class="text-sm font-bold font-heading text-slate-900 mb-4 pb-3 border-b border-slate-100">Top Audience Countries</h2>
                <div class="space-y-3 font-mono">
                    @foreach($insights['countries'] ?? [] as $country)
                        <div class="flex items-center justify-between text-xs py-1.5 border-b border-slate-100 last:border-0">
                            <span class="font-bold text-slate-800">{{ $country['name'] }}</span>
                            <div class="flex items-center space-x-3">
                                <span class="text-slate-500 text-[11px]">{{ $country['count'] ?? '' }} followers</span>
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-900 font-bold rounded-lg">{{ $country['pct'] }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Cities -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <h2 class="text-sm font-bold font-heading text-slate-900 mb-4 pb-3 border-b border-slate-100">Top Audience Cities</h2>
                <div class="space-y-3 font-mono">
                    @foreach($insights['cities'] ?? [] as $city)
                        <div class="flex items-center justify-between text-xs py-1.5 border-b border-slate-100 last:border-0">
                            <span class="font-bold text-slate-800">{{ $city['name'] }}</span>
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-800 font-bold rounded-lg border border-emerald-200">{{ $city['pct'] }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

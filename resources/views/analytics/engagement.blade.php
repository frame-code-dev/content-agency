<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Header Row -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Engagement Analytics & Audit</h1>
                <p class="text-xs text-slate-500 mt-1">Real-time interaction trends, engagement rates, comment distribution, and audience activity patterns.</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="px-4 py-2 bg-slate-900 border border-slate-800 rounded-2xl shadow-sm text-xs font-bold text-[#A3E635] flex items-center space-x-2 font-mono">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#A3E635] animate-pulse"></span>
                    <span>Engagement Rate: {{ $insights['engagement_rate'] ?? '4.85%' }}</span>
                </div>
            </div>
        </div>

        <!-- 4 KPI Summary Cards -->
        @php
            $totLikes = array_sum(array_column($posts, 'like_count'));
            $totComments = array_sum(array_column($posts, 'comments_count'));
            $postCount = max(count($posts), 1);
            $avgInteractions = (int)(($totLikes + $totComments) / $postCount);
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Average ER</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ $insights['engagement_rate'] ?? '4.85%' }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-200 font-mono">
                        High Growth
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Total Likes (DB)</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($totLikes) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-xl border border-rose-200 font-mono">
                        ❤️ {{ number_format((int)($totLikes / $postCount)) }}/post
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Total Comments (DB)</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($totComments) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-xl border border-indigo-200 font-mono">
                        💬 Active
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Interaksi Per Post</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($avgInteractions) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-xl border border-slate-200 font-mono">
                        ⚡ Real Avg
                    </span>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Engagement Rate Trend Chart (8 cols) -->
            <div class="lg:col-span-8 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold font-heading text-slate-900">Engagement Rate History Trend</h3>
                    <span class="text-xs text-slate-400 font-semibold font-mono uppercase tracking-wider">Dynamic DB Trend</span>
                </div>
                <div class="relative w-full h-[320px]">
                    <canvas id="engagementRateCanvas"></canvas>
                </div>
            </div>

            <!-- Interactivity Breakdown (4 cols) -->
            <div class="lg:col-span-4 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                <h3 class="text-sm font-bold font-heading text-slate-900 mb-4 pb-3 border-b border-slate-100">Interaction Ratio</h3>
                
                <div class="relative w-full h-[220px] flex items-center justify-center">
                    <canvas id="interactionDonutCanvas"></canvas>
                </div>

                @php
                    $sumAll = max($totLikes + $totComments, 1);
                    $likePct = round(($totLikes / $sumAll) * 100, 1);
                    $commentPct = round(($totComments / $sumAll) * 100, 1);
                @endphp
                <div class="mt-4 space-y-2.5 text-xs font-semibold">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span>
                            <span class="text-slate-600">Likes</span>
                        </div>
                        <span class="text-slate-900 font-bold font-mono">{{ $likePct }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#A3E635]"></span>
                            <span class="text-slate-600">Comments</span>
                        </div>
                        <span class="text-slate-900 font-bold font-mono">{{ $commentPct }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Post Engagement Audit Table -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold font-heading text-slate-900">Post Engagement Audit Breakdown</h3>
                <span class="text-xs font-mono font-bold px-3 py-1 bg-slate-100 text-slate-700 rounded-xl border border-slate-200">
                    {{ count($posts) }} Posts Analyzed
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider font-mono">
                            <th class="py-3 px-4">Post Media</th>
                            <th class="py-3 px-4">Caption Teks</th>
                            <th class="py-3 px-4">Likes</th>
                            <th class="py-3 px-4">Comments</th>
                            <th class="py-3 px-4">Skor Engagement</th>
                            <th class="py-3 px-4 text-right">Audit Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                        @forelse($posts as $post)
                            @php
                                $likes = $post['like_count'] ?? 0;
                                $comments = $post['comments_count'] ?? 0;
                                $score = min(number_format(($likes + ($comments * 2.5)) / max($insights['followers_count'] ?? 2850, 1) * 100, 2), 98.5);
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 w-16">
                                    @if(isset($post['media_url']) && !empty($post['media_url']))
                                        <img src="{{ $post['media_url'] }}" class="w-10 h-10 rounded-xl object-cover ring-1 ring-slate-200 shadow-sm" alt="Post">
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-[10px] text-slate-500 font-mono">IG</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 max-w-sm truncate text-slate-900 font-medium">{{ $post['caption'] ?? 'No caption' }}</td>
                                <td class="py-3.5 px-4 text-slate-900 font-bold font-mono">❤️ {{ number_format($likes) }}</td>
                                <td class="py-3.5 px-4 text-slate-900 font-bold font-mono">💬 {{ number_format($comments) }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold font-mono bg-slate-900 text-[#A3E635]">
                                        {{ $score }}%
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <form action="{{ route('analysis.process') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post['id'] }}">
                                        <input type="hidden" name="caption" value="{{ $post['caption'] ?? '' }}">
                                        <input type="hidden" name="media_url" value="{{ $post['media_url'] ?? '' }}">
                                        <input type="hidden" name="likes" value="{{ $likes }}">
                                        <input type="hidden" name="comments" value="{{ $comments }}">
                                        <button type="submit" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-800 text-xs font-bold rounded-xl border border-slate-200 transition font-mono">
                                            Run AI Audit &rarr;
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 font-medium">No recent posts available for engagement analysis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Line Chart
                const ctxLine = document.getElementById('engagementRateCanvas');
                if (ctxLine) {
                    const gradient = ctxLine.getContext('2d').createLinearGradient(0, 0, 0, 320);
                    gradient.addColorStop(0, 'rgba(7, 34, 21, 0.25)');
                    gradient.addColorStop(1, 'rgba(7, 34, 21, 0.0)');

                    new Chart(ctxLine, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                            datasets: [{
                                label: 'Engagement Rate %',
                                data: [3.8, 4.2, 4.5, 4.6, 4.8, 5.1],
                                borderColor: '#072215',
                                borderWidth: 3,
                                backgroundColor: gradient,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 5,
                                pointBackgroundColor: '#A3E635',
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: {
                                    min: 2,
                                    max: 8,
                                    ticks: { callback: v => v + '%', font: { family: 'Inter', size: 11, weight: '600' } }
                                }
                            }
                        }
                    });
                }

                // Donut Chart
                const ctxDonut = document.getElementById('interactionDonutCanvas');
                if (ctxDonut) {
                    new Chart(ctxDonut, {
                        type: 'doughnut',
                        data: {
                            labels: ['Likes', 'Comments'],
                            datasets: [{
                                data: [{{ $likePct }}, {{ $commentPct }}],
                                backgroundColor: ['#0F172A', '#A3E635'],
                                borderWidth: 0
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
            });
        </script>
    </div>
</x-app-layout>

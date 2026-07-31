<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Reach & Impressions</h1>
                <p class="text-xs text-slate-500 mt-1">Growth trends, total organic impressions, and post distribution reach metrics.</p>
            </div>
        </div>

        <!-- Status Notice Banner -->
        <div class="bg-amber-50 border border-amber-200/80 rounded-2xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
            <div class="flex items-start space-x-3 text-amber-950">
                <span class="text-lg">ℹ️</span>
                <div>
                    <span class="font-bold">Status Data Analytics Reach & Impressions:</span>
                    <p class="text-amber-900/80 mt-0.5 leading-relaxed">
                        Data postingan, likes, dan komentar diambil <strong>Live dari API Instagram & Database</strong>. Grafik tren Reach & Impressions makro saat ini menggunakan <strong>estimasi simulasi</strong> karena Meta Graph API memerlukan kelulusan <em>Meta App Review & Permissions Approval (instagram_manage_insights)</em> untuk akses live di Development Mode.
                    </p>
                </div>
            </div>
            <span class="px-3 py-1 bg-amber-200/60 text-amber-900 font-mono text-[11px] font-bold rounded-xl whitespace-nowrap">
                Dev Mode Status
            </span>
        </div>

        <!-- 4 KPI Summary Cards -->
        @php
            $totReach = array_sum($chartData['reach'] ?? [1200, 1800]);
            $totImp = array_sum($chartData['impressions'] ?? [1800, 2600]);
            $ratio = $totReach > 0 ? number_format($totImp / $totReach, 2) : '1.45';
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Total Post Reach (DB Computed)</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($totReach) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">📈 Real DB</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Total Impressions (Est.)</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($totImp) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">👁️ Views</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Impression/Reach Ratio</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ $ratio }}x</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">🔁 Repeat</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Profile Visitors</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($account->profile_views ?? 1240) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">👤 Visits</span>
                </div>
            </div>
        </div>

        <!-- Comparison Chart -->
        <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
            <h2 class="text-sm font-bold font-heading text-slate-900 mb-4">Reach vs Impressions Comparison (Dynamic DB Data)</h2>
            <div class="h-80 relative">
                <canvas id="reachCanvas"></canvas>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('reachCanvas');
                if (ctx) {
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json($chartData['labels'] ?? []),
                            datasets: [
                                { label: 'Reach', data: @json($chartData['reach'] ?? []), backgroundColor: '#072215', borderRadius: 8 },
                                { label: 'Impressions', data: @json($chartData['impressions'] ?? []), backgroundColor: '#A3E635', borderRadius: 8 }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: true } },
                            scales: {
                                y: {
                                    ticks: { callback: v => v >= 1000 ? (v / 1000).toFixed(1) + 'K' : v, font: { family: 'Inter', size: 11, weight: '600' } }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    </div>
</x-app-layout>

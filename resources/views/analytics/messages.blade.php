<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Messages & Comments Studio</h1>
                <p class="text-xs text-slate-500 mt-1">Direct message interactions, comment sentiment auditing, and automated reply workflows.</p>
            </div>
            <span class="px-4 py-2 bg-slate-900 text-[#A3E635] text-xs font-bold font-mono rounded-2xl shadow">
                Live Interaction Hub
            </span>
        </div>

        <!-- 4 Summary KPI Cards -->
        @php
            $totComments = array_sum(array_column($posts, 'comments_count'));
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Unread Messages</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">12</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-200 font-mono">📩 New</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Comments Audited (DB)</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($totComments) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-xl border border-indigo-200 font-mono">💬 Synced</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Positive Sentiment</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">94.2%</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-200 font-mono">😃 Positive</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Avg Response Speed</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">1.8 Min</span>
                    <span class="inline-flex items-center text-xs font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-xl border border-slate-200 font-mono">⚡ Fast</span>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-emerald-950 text-white border border-slate-800 rounded-3xl p-10 text-center shadow-xl max-w-3xl mx-auto my-6 space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-slate-900 text-[#A3E635] flex items-center justify-center mx-auto border border-slate-800 font-bold text-2xl shadow">
                💬
            </div>
            <h2 class="text-2xl font-bold font-heading text-white tracking-tight">Instagram Direct Messages & Comments Hub</h2>
            <p class="text-xs text-slate-400 leading-relaxed font-sans max-w-xl mx-auto">
                Connect your Meta Instagram Professional account to automatically sync incoming comments, perform AI sentiment analysis, and automate direct message responses.
            </p>
            <div class="pt-2">
                <a href="{{ route('instagram.connect') }}" class="inline-flex items-center space-x-2 px-8 py-3.5 bg-[#A3E635] text-slate-950 text-xs font-bold font-mono rounded-2xl shadow hover:bg-lime-400 transition">
                    <span>Sync Meta Instagram DMs</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Content Performance</h1>
                <p class="text-xs text-slate-500 mt-1">Detailed media asset analysis, likes, comments, and top performing posts from Instagram API.</p>
            </div>
            <a href="{{ route('planner.index') }}" class="px-5 py-2.5 bg-[#072215] text-[#A3E635] text-xs font-bold rounded-2xl shadow transition hover:scale-105">
                + Create Content Plan
            </a>
        </div>

        <!-- 4 Summary KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Total Media Posts</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format($insights['media_count'] ?? count($posts)) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">📸 Synced</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Total Interaction Count</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">
                        {{ number_format(array_sum(array_column($posts, 'like_count')) + array_sum(array_column($posts, 'comments_count'))) }}
                    </span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">🔥 High</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Avg Likes Per Post</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">
                        {{ count($posts) > 0 ? number_format(array_sum(array_column($posts, 'like_count')) / count($posts)) : 0 }}
                    </span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">❤️ Likes</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-semibold text-slate-500">Avg Comments Per Post</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">
                        {{ count($posts) > 0 ? number_format(array_sum(array_column($posts, 'comments_count')) / count($posts)) : 0 }}
                    </span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">💬 Replies</span>
                </div>
            </div>
        </div>

        <!-- Live Content Assets Table -->
        <div class="bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm">
            <h2 class="text-base font-bold font-heading text-slate-900 mb-4">Live Content Assets Table</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider">
                            <th class="py-3 px-4">Media</th>
                            <th class="py-3 px-4">Caption</th>
                            <th class="py-3 px-4">Type</th>
                            <th class="py-3 px-4">Likes</th>
                            <th class="py-3 px-4">Comments</th>
                            <th class="py-3 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                        @forelse($posts as $post)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3.5 px-4 w-16">
                                    @if(isset($post['media_url']))
                                        <img src="{{ $post['media_url'] }}" class="w-12 h-12 rounded-xl object-cover ring-1 ring-slate-200" alt="Post">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-xs">IG</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 max-w-sm truncate text-slate-900 font-medium">{{ $post['caption'] ?? 'No caption' }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                        {{ $post['media_type'] ?? 'IMAGE' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-emerald-600 font-bold">❤️ {{ number_format($post['like_count'] ?? 0) }}</td>
                                <td class="py-3.5 px-4 text-slate-900 font-bold">💬 {{ number_format($post['comments_count'] ?? 0) }}</td>
                                <td class="py-3.5 px-4">
                                    <form action="{{ route('analysis.process') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post['id'] }}">
                                        <input type="hidden" name="caption" value="{{ $post['caption'] ?? '' }}">
                                        <input type="hidden" name="media_url" value="{{ $post['media_url'] ?? '' }}">
                                        <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-sm transition">
                                            Run AI Audit
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 font-medium">No Instagram content posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

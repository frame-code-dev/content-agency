<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Content Performance & Audit</h1>
                <p class="text-xs text-slate-500 mt-1">Detailed media asset analysis, likes, comments, and top performing posts from Instagram API & Database.</p>
            </div>
            <a href="{{ route('planner.index') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-[#A3E635] text-xs font-bold rounded-2xl shadow transition flex items-center space-x-2 font-mono">
                <span>+ Create Content Plan</span>
            </a>
        </div>

        <!-- 4 Summary KPI Cards -->
        @php
            $totLikes = array_sum(array_column($posts, 'like_count'));
            $totComments = array_sum(array_column($posts, 'comments_count'));
            $postCount = max(count($posts), 1);
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Total Media Posts</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">{{ number_format(count($posts)) }}</span>
                    <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-200 font-mono">
                        DB Synced
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Total Akumulasi Interaksi</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">
                        {{ number_format($totLikes + $totComments) }}
                    </span>
                    <span class="inline-flex items-center text-xs font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-xl border border-slate-200 font-mono">
                        🔥 High Engagement
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Rata-Rata Likes Per Post</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">
                        {{ number_format((int)($totLikes / $postCount)) }}
                    </span>
                    <span class="inline-flex items-center text-xs font-bold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-xl border border-rose-200 font-mono">
                        ❤️ Likes
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase font-mono">Rata-Rata Komen Per Post</div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-bold font-heading text-slate-900 tracking-tight">
                        {{ number_format((int)($totComments / $postCount)) }}
                    </span>
                    <span class="inline-flex items-center text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-xl border border-indigo-200 font-mono">
                        💬 Comments
                    </span>
                </div>
            </div>
        </div>

        <!-- Live Content Assets Table -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h2 class="text-base font-bold font-heading text-slate-900">Live Content Assets Table</h2>
                <span class="text-xs font-mono font-bold px-3 py-1 bg-slate-100 text-slate-700 rounded-xl border border-slate-200">
                    {{ isset($postsPaginator) ? $postsPaginator->total() : count($posts) }} Posts Ready (5 per halaman)
                </span>
            </div>

            @php
                $tableItems = isset($postsPaginator) && $postsPaginator->count() > 0 ? $postsPaginator : $posts;
                $fallbackImg = 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?auto=format&fit=crop&w=600&q=80';
            @endphp

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider font-mono">
                            <th class="py-3 px-4">Media</th>
                            <th class="py-3 px-4">Caption Teks</th>
                            <th class="py-3 px-4">Format</th>
                            <th class="py-3 px-4">Likes</th>
                            <th class="py-3 px-4">Comments</th>
                            <th class="py-3 px-4 text-right">Audit Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                        @forelse($tableItems as $postItem)
                            @php
                                $pId = is_array($postItem) ? ($postItem['id'] ?? '') : ($postItem->instagram_post_id ?? $postItem->id);
                                $pCap = is_array($postItem) ? ($postItem['caption'] ?? '') : ($postItem->caption ?? '');
                                $pType = is_array($postItem) ? ($postItem['media_type'] ?? '') : ($postItem->media_type ?? '');
                                $pUrl = is_array($postItem) ? ($postItem['media_url'] ?? '') : ($postItem->media_url ?? '');
                                $pLikes = is_array($postItem) ? ($postItem['like_count'] ?? 0) : ($postItem->like_count ?? 0);
                                $pComments = is_array($postItem) ? ($postItem['comments_count'] ?? 0) : ($postItem->comments_count ?? 0);
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 w-16">
                                    <img src="{{ !empty($pUrl) ? $pUrl : $fallbackImg }}" class="w-12 h-12 rounded-xl object-cover ring-1 ring-slate-200 shadow-sm" alt="Post Media" onerror="this.onerror=null; this.src='{{ $fallbackImg }}';">
                                </td>
                                <td class="py-3.5 px-4 max-w-sm truncate text-slate-900 font-medium">{{ !empty($pCap) ? $pCap : 'No caption' }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-xl text-[10px] font-bold font-mono uppercase bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ !empty($pType) ? $pType : 'IMAGE' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-slate-900 font-bold font-mono">❤️ {{ number_format($pLikes) }}</td>
                                <td class="py-3.5 px-4 text-slate-900 font-bold font-mono">💬 {{ number_format($pComments) }}</td>
                                <td class="py-3.5 px-4 text-right">
                                    <form action="{{ route('analysis.process') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $pId }}">
                                        <input type="hidden" name="caption" value="{{ $pCap }}">
                                        <input type="hidden" name="media_url" value="{{ $pUrl }}">
                                        <input type="hidden" name="likes" value="{{ $pLikes }}">
                                        <input type="hidden" name="comments" value="{{ $pComments }}">
                                        <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-sm transition font-mono">
                                            Run AI Audit &rarr;
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

            @if(isset($postsPaginator) && $postsPaginator->hasPages())
                <div class="mt-6 pt-4 border-t border-slate-100">
                    {{ $postsPaginator->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

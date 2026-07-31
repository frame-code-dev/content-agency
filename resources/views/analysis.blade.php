<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('dashboard') }}" class="text-xs font-medium text-neutral-500 hover:text-neutral-900 transition mb-1 inline-block">
                    &larr; Back to Asset Library
                </a>
                <h2 class="text-xl font-semibold tracking-tight text-neutral-900">Executive Content Audit Report</h2>
            </div>
            <div class="text-right">
                <span class="text-xs text-neutral-400 block">Report ID: #AUD-{{ strtoupper(substr($postData['id'], -6)) }}</span>
                <span class="text-xs font-mono text-neutral-600">{{ date('Y-m-d H:i') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top Summary Bar -->
        <div class="bg-neutral-900 text-white rounded-lg p-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-neutral-400">Overall Audit Score</span>
                <div class="text-4xl font-light tracking-tight mt-1">
                    {{ $analysis['overall_agency_score'] ?? 'N/A' }} <span class="text-lg text-neutral-500">/ 100</span>
                </div>
            </div>
            <div class="h-12 w-px bg-neutral-800 hidden md:block"></div>
            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-neutral-400">Tone Profile</span>
                <div class="text-base font-medium mt-1 text-neutral-200">
                    {{ $analysis['tone_of_voice'] ?? 'Standard Agency Tone' }}
                </div>
            </div>
            <div class="h-12 w-px bg-neutral-800 hidden md:block"></div>
            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-neutral-400">Sentiment Index</span>
                <div class="text-base font-medium mt-1 text-neutral-200">
                    {{ $analysis['sentiment']['label'] ?? 'Neutral' }} ({{ $analysis['sentiment']['score'] ?? 0 }}%)
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Original Asset -->
            <div class="space-y-6">
                <div class="bg-white border border-neutral-200 rounded-lg p-6">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-neutral-900 mb-4 pb-2 border-b border-neutral-100">
                        Asset Under Review
                    </h3>
                    @if(!empty($postData['media_url']))
                        <div class="aspect-square w-full bg-neutral-100 rounded border border-neutral-200 overflow-hidden mb-4">
                            <img src="{{ $postData['media_url'] }}" alt="Post Asset" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="text-xs text-neutral-600 whitespace-pre-line leading-relaxed bg-neutral-50 p-4 rounded border border-neutral-100">
                        {{ $postData['caption'] }}
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs text-neutral-500 pt-3 border-t border-neutral-100">
                        <span>Likes: {{ number_format($postData['likes']) }}</span>
                        <span>Comments: {{ number_format($postData['comments']) }}</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: AI Analysis Breakdown -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Hashtag Audit Card -->
                <div class="bg-white border border-neutral-200 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4 pb-2 border-b border-neutral-100">
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-neutral-900">
                            Hashtag & Metadata Evaluation
                        </h3>
                        <span class="text-xs font-mono px-2 py-0.5 rounded bg-neutral-100 text-neutral-800 border border-neutral-200">
                            {{ $analysis['hashtag_audit']['status'] ?? 'Audit Complete' }}
                        </span>
                    </div>
                    <p class="text-xs text-neutral-700 leading-relaxed mb-3">
                        {{ $analysis['hashtag_audit']['feedback'] ?? 'No feedback generated.' }}
                    </p>
                    <div class="text-xs text-neutral-500 font-mono">
                        Detected Hashtags: {{ $analysis['hashtag_audit']['count'] ?? 0 }}
                    </div>
                </div>

                <!-- Strategic Recommendations Card -->
                <div class="bg-white border border-neutral-200 rounded-lg p-6">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-neutral-900 mb-6 pb-2 border-b border-neutral-100">
                        Actionable Content Optimizations
                    </h3>
                    <div class="space-y-4">
                        @foreach($analysis['recommendations'] ?? [] as $index => $rec)
                            <div class="flex items-start space-x-4 p-4 rounded bg-neutral-50 border border-neutral-200">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-neutral-900 text-white text-xs font-mono flex items-center justify-center">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h4 class="text-xs font-semibold text-neutral-900 uppercase tracking-wide">
                                        {{ $rec['category'] }}
                                    </h4>
                                    <p class="text-xs text-neutral-600 mt-1 leading-relaxed">
                                        {{ $rec['action'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sentiment Context Card -->
                <div class="bg-white border border-neutral-200 rounded-lg p-6">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-neutral-900 mb-2 pb-2 border-b border-neutral-100">
                        Sentiment & Context Notes
                    </h3>
                    <p class="text-xs text-neutral-600 leading-relaxed">
                        {{ $analysis['sentiment']['explanation'] ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

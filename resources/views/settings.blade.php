<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-neutral-900">Studio Settings</h2>
                <p class="text-xs text-neutral-500 mt-0.5">Manage agency profile, API connections, and Instagram integration.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-xs font-medium text-neutral-600 hover:text-neutral-900 transition flex items-center space-x-1">
                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Dashboard</span>
            </a>
        </div>
    </x-slot>

    <div class="p-8 w-full space-y-8">
        @if(session('success'))
            <div class="bg-emerald-900 text-white text-xs px-4 py-3 rounded border border-emerald-800 flex items-center justify-between">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Instagram Integration Status Card -->
        <div class="bg-white border border-neutral-200 rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-neutral-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-neutral-900">Instagram Integration</h3>
                        <p class="text-xs text-neutral-500">OAuth Channel Connection Status</p>
                    </div>
                </div>
                @if($account)
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Connected
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-neutral-100 text-neutral-600 border border-neutral-200">
                        Disconnected
                    </span>
                @endif
            </div>

            <div class="mt-4 pt-2">
                @if($account)
                    <div class="flex items-center justify-between bg-neutral-50 p-4 rounded border border-neutral-200">
                        <div>
                            <p class="text-xs font-semibold text-neutral-800">@ {{ $account->username }}</p>
                            <p class="text-xs text-neutral-500 mt-0.5">Account ID: {{ $account->instagram_account_id }}</p>
                        </div>
                        <form action="{{ route('instagram.disconnect') }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('Disconnect Instagram account?')" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-medium border border-rose-200 rounded transition">
                                Disconnect Account
                            </button>
                        </form>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-xs text-neutral-500 mb-3">No Instagram account currently linked.</p>
                        <a href="{{ route('instagram.connect') }}" class="inline-flex items-center px-4 py-2 bg-neutral-900 hover:bg-neutral-800 text-white text-xs font-medium uppercase tracking-wider rounded transition">
                            Connect Instagram
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- API & Platform Configuration -->
        <div class="bg-white border border-neutral-200 rounded-lg p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-neutral-900 border-b border-neutral-100 pb-3 mb-4">Platform Configuration</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div class="p-4 bg-neutral-50 rounded border border-neutral-200">
                    <span class="text-neutral-500 font-medium block">Instagram Client ID</span>
                    <span class="font-mono text-neutral-800 font-semibold mt-1 block">{{ $config['instagram_client_id'] ?? 'Not Configured' }}</span>
                </div>
                <div class="p-4 bg-neutral-50 rounded border border-neutral-200">
                    <span class="text-neutral-500 font-medium block">OpenAI API Key</span>
                    <span class="font-mono text-neutral-800 font-semibold mt-1 block">{{ $config['openai_api_key'] }}</span>
                </div>
                <div class="p-4 bg-neutral-50 rounded border border-neutral-200">
                    <span class="text-neutral-500 font-medium block">Environment Mode</span>
                    <span class="font-semibold text-neutral-800 mt-1 block uppercase">{{ app()->environment() }}</span>
                </div>
                <div class="p-4 bg-neutral-50 rounded border border-neutral-200">
                    <span class="text-neutral-500 font-medium block">Mock Mode Status</span>
                    <span class="font-semibold {{ $config['instagram_mock_mode'] ? 'text-amber-600' : 'text-emerald-600' }} mt-1 block uppercase">
                        {{ $config['instagram_mock_mode'] ? 'Enabled (Demo Mode)' : 'Disabled (Live API)' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Agency Profile Settings Form -->
        <div class="bg-white border border-neutral-200 rounded-lg p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-neutral-900 border-b border-neutral-100 pb-3 mb-4">Agency Profile Details</h3>
            
            <form action="{{ route('settings.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="agency_name" class="block text-xs font-medium text-neutral-700 mb-1">Agency / Studio Name</label>
                    <input type="text" name="agency_name" id="agency_name" value="{{ $user->name ?? 'Agency Admin' }}" class="w-full max-w-md px-3 py-2 border border-neutral-300 rounded text-xs focus:ring-1 focus:ring-neutral-900 focus:outline-none">
                </div>

                <div>
                    <button type="submit" class="px-4 py-2 bg-neutral-900 hover:bg-neutral-800 text-white text-xs font-medium uppercase tracking-wider rounded transition">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

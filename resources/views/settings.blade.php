<x-app-layout>
    <div class="p-8 w-full space-y-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 tracking-tight">Studio & System Settings</h1>
                <p class="text-xs text-slate-500 mt-1">Manage agency profile, API connections, and Instagram integration.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-xs font-mono font-bold text-slate-600 hover:text-slate-900 transition flex items-center space-x-1">
                <span>&larr; Back to Dashboard</span>
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs px-4 py-3 rounded-2xl flex items-center justify-between font-medium">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Instagram Integration Status Card -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-slate-100 gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 flex items-center justify-center text-white shadow-md">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold font-heading text-slate-900">Instagram Meta Integration</h3>
                        <p class="text-xs text-slate-500 font-mono">OAuth Channel Connection & Token Synchronization</p>
                    </div>
                </div>
                @if($account)
                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold font-mono bg-emerald-50 text-emerald-800 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-ping"></span> Connected Live
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold font-mono bg-slate-100 text-slate-600 border border-slate-200">
                        Disconnected
                    </span>
                @endif
            </div>

            <div class="mt-6">
                @if($account)
                    <div class="flex items-center justify-between bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80">
                        <div>
                            <p class="text-xs font-bold font-mono text-slate-900">@ {{ $account->username }}</p>
                            <p class="text-[11px] font-mono text-slate-500 mt-0.5">Account ID: {{ $account->instagram_account_id }}</p>
                        </div>
                        <form action="{{ route('instagram.disconnect') }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('Disconnect Instagram account?')" class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold border border-rose-200 rounded-xl transition font-mono">
                                Disconnect Account
                            </button>
                        </form>
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-xs text-slate-500 mb-3 font-medium">No Instagram account currently linked.</p>
                        <a href="{{ route('instagram.connect') }}" class="inline-flex items-center px-6 py-3 bg-slate-900 hover:bg-slate-800 text-[#A3E635] text-xs font-bold font-mono rounded-2xl shadow transition">
                            Connect Instagram Meta Channel
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- API & Platform Configuration -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
            <h3 class="text-sm font-bold font-heading text-slate-900 border-b border-slate-100 pb-3 mb-4">Platform Configuration Engine</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-mono">
                <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200/80">
                    <span class="text-slate-500 font-bold block text-[11px] uppercase tracking-wider">Instagram Client ID</span>
                    <span class="font-bold text-slate-900 mt-1 block">{{ $config['instagram_client_id'] ?? 'Not Configured' }}</span>
                </div>
                <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200/80">
                    <span class="text-slate-500 font-bold block text-[11px] uppercase tracking-wider">OpenAI API Key</span>
                    <span class="font-bold text-slate-900 mt-1 block">{{ $config['openai_api_key'] }}</span>
                </div>
                <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200/80">
                    <span class="text-slate-500 font-bold block text-[11px] uppercase tracking-wider">Environment Mode</span>
                    <span class="font-bold text-slate-900 mt-1 block uppercase">{{ app()->environment() }}</span>
                </div>
                <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200/80">
                    <span class="text-slate-500 font-bold block text-[11px] uppercase tracking-wider">Mock Mode Status</span>
                    <span class="font-bold {{ $config['instagram_mock_mode'] ? 'text-amber-600' : 'text-emerald-700' }} mt-1 block uppercase">
                        {{ $config['instagram_mock_mode'] ? 'Enabled (Demo Mode)' : 'Disabled (Live API)' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Agency Profile Settings Form -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
            <h3 class="text-sm font-bold font-heading text-slate-900 border-b border-slate-100 pb-3 mb-4">Agency Studio Profile Details</h3>
            
            <form action="{{ route('settings.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="agency_name" class="block text-xs font-bold font-mono text-slate-500 uppercase tracking-wider mb-1">Agency / Studio Name</label>
                    <input type="text" name="agency_name" id="agency_name" value="{{ $user->name ?? 'Agency Admin' }}" class="w-full max-w-md px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:border-slate-900 focus:bg-white focus:outline-none transition">
                </div>

                <div>
                    <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-[#A3E635] text-xs font-bold font-mono uppercase tracking-wider rounded-2xl shadow transition">
                        Save Studio Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

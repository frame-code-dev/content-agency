<x-guest-layout>
    <div class="mb-6 text-center">
        <span class="inline-flex items-center space-x-1.5 px-3 py-1 bg-amber-500/10 text-amber-600 rounded-full text-xs font-bold font-mono border border-amber-500/20">
            <span>👑</span>
            <span>SUPER ADMIN PORTAL</span>
        </span>
        <h1 class="text-xl font-bold font-heading text-slate-900 mt-2">Agency Admin Login</h1>
        <p class="text-xs text-slate-500 mt-1">Authorized Agency Managers & Super-Admins</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-xs text-slate-500 hover:text-slate-800 underline font-medium" href="{{ route('login') }}">
                ← Switch to Client Login
            </a>

            <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow transition">
                Login as Super-Admin
            </button>
        </div>
    </form>
</x-guest-layout>

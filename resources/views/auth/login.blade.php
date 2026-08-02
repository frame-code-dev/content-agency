<x-guest-layout>
    <div class="mb-6 text-center">
        <span class="inline-flex items-center space-x-1.5 px-3 py-1 bg-zinc-950 text-white rounded-[10px] text-xs font-bold font-mono shadow-sm">
            <span>Cineart Production Studio</span>
        </span>
        <h1 class="text-xl font-bold font-heading text-zinc-900 mt-3">Client Portal Access</h1>
        <p class="text-xs text-zinc-500 mt-1 max-w-xs mx-auto leading-relaxed">
            Connect your Instagram Business account via Meta OAuth to enter Cineart Production Analytics.
        </p>
    </div>

    <!-- Session Status & Error Alerts -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-[10px] flex items-start space-x-3 shadow-sm">
            <span class="text-base">⚠️</span>
            <div class="flex-1">
                <div class="font-bold text-red-800 uppercase tracking-wider text-[10px]">OAuth Connection Error</div>
                <div class="mt-0.5 leading-relaxed">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    <!-- PRIMARY ACTION: Login / Connect with Instagram OAuth -->
    <div class="space-y-4 my-6">
        <a href="{{ route('instagram.connect') }}" class="w-full flex items-center justify-center space-x-3 px-6 py-4 bg-zinc-950 hover:bg-zinc-900 text-white text-sm font-bold rounded-[10px] shadow-lg transition transform duration-200">
            <svg class="w-5 h-5 text-white fill-current" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
            <span>Login / Connect with Instagram</span>
        </a>
    </div>

    <!-- Divider -->
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-zinc-200"></div></div>
        <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-3 text-zinc-400 font-semibold font-mono">Or Username / Email Login</span></div>
    </div>

    <!-- Email or Username Login Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address or Username -->
        <div>
            <x-input-label for="email" :value="__('Email or Username')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-[10px]" type="text" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="username or email@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full rounded-[10px]"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-[4px] border-zinc-300 text-zinc-950 focus:ring-zinc-950" name="remember">
                <span class="ms-2 text-sm text-zinc-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-xs text-zinc-500 hover:text-zinc-900 rounded-[10px]" href="{{ route('register') }}">
                {{ __('Register account') }}
            </a>

            <x-primary-button class="ms-3 bg-zinc-950 hover:bg-zinc-800 rounded-[10px]">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

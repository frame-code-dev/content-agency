<x-guest-layout>
    <div class="mb-6 text-center">
        <span class="inline-flex items-center space-x-1.5 px-3 py-1 bg-zinc-950 text-white rounded-[10px] text-xs font-bold font-mono shadow-sm">
            <span>Cineart Production Studio</span>
        </span>
        <h1 class="text-xl font-bold font-heading text-zinc-900 mt-3">Create Client Account</h1>
        <p class="text-xs text-zinc-500 mt-1 max-w-xs mx-auto leading-relaxed">
            Register with your Name, Username, Email, and Password to access Cineart Production Analytics.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full rounded-[10px]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full rounded-[10px]" type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="johndoe" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-[10px]" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="john@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full rounded-[10px]"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-[10px]"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-xs text-zinc-500 hover:text-zinc-900 rounded-[10px]" href="{{ route('login') }}">
                {{ __('Already registered? Log in') }}
            </a>

            <x-primary-button class="ms-3 bg-zinc-950 hover:bg-zinc-800 rounded-[10px]">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

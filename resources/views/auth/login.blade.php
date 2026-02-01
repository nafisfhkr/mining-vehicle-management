<x-guest-layout>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">
            Selamat Datang
        </h2>
        <p class="text-sm text-gray-500">
            Sistem Monitoring Kendaraan Tambang
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- EMAIL --}}
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input
                id="email"
                type="email"
                name="email"
                class="block mt-1 w-full"
                :value="old('email')"
                required
                autofocus
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- PASSWORD --}}
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input
                id="password"
                type="password"
                name="password"
                class="block mt-1 w-full"
                required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- REMEMBER --}}
        <div class="mt-4 flex items-center">
            <input id="remember_me"
                   type="checkbox"
                   name="remember"
                   class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">
                Ingat Saya
            </label>
        </div>

        {{-- ACTION --}}
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-gray-600 hover:text-indigo-600 underline">
                    Lupa Password?
                </a>
            @endif

            <button type="submit"
                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700
                           text-black font-semibold text-sm rounded
                           shadow transition">
                Masuk
            </button>
        </div>
    </form>

</x-guest-layout>

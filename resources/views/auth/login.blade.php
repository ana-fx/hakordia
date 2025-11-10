<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-200 via-emerald-100 to-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full bg-white/90 rounded-3xl shadow-2xl border border-green-100 flex flex-col md:flex-row overflow-hidden">
            <!-- Left: Admin Info Only, Modern & Creative -->
            <div class="hidden md:flex flex-col justify-center items-center w-1/2 relative overflow-hidden p-0">
                <!-- Decorative SVG -->
                <svg class="absolute -top-10 -left-10 w-60 h-60 opacity-30 blur-lg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                  <path fill="#34d399" d="M44.8,-67.2C57.6,-59.2,66.7,-44.2,71.2,-28.2C75.7,-12.2,75.6,4.8,70.2,19.6C64.8,34.4,54.1,47,41.2,56.7C28.3,66.4,13.1,73.2,-2.2,75.7C-17.5,78.2,-34.9,76.4,-48.2,67.2C-61.5,58,-70.7,41.4,-74.2,24.2C-77.7,7,-75.5,-10.8,-68.2,-25.7C-60.9,-40.6,-48.5,-52.6,-34.2,-60.7C-19.9,-68.8,-4,-73,12.7,-75.2C29.4,-77.4,58.1,-75.2,44.8,-67.2Z" transform="translate(100 100)" />
                </svg>
                <div class="flex flex-col items-center justify-center h-full w-full z-10 px-10 py-16" style="backdrop-filter: blur(8px); background: rgba(255,255,255,0.25); border-radius: 2rem; box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);">
                    <div class="bg-gradient-to-br from-green-400 via-emerald-400 to-green-600 p-5 rounded-full shadow-lg mb-6 animate-bounce-slow">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/></svg>
                    </div>
                    <div class="font-extrabold text-green-800 text-2xl mb-2 text-center tracking-tight drop-shadow">Halaman Admin</div>
                    <ul class="text-green-700 text-base leading-relaxed text-left font-medium mb-2 space-y-4">
                        <li class="flex items-start gap-2">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>Halaman ini <b>khusus untuk admin</b> dan bukan untuk pendaftaran peserta.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>Peserta <b>tidak perlu membuat akun</b> atau login di halaman ini.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>Peserta cukup <b>mengisi form pendaftaran event</b> dan melakukan <b>verifikasi pembayaran ke admin</b> setelahnya.</span>
                        </li>
                    </ul>
                    <div class="mt-6 text-xs text-green-900/60 text-center">© {{ date('Y') }} Pandalungan Festival</div>
                </div>
            </div>
            <!-- Right: Login Form -->
            <div class="w-full md:w-1/2 flex flex-col justify-center p-8 md:p-12">
                <h2 class="text-2xl font-bold text-green-800 mb-6 text-center md:text-left">Login Admin</h2>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full rounded-lg border-green-300 focus:border-green-500 focus:ring-green-500 shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
                    <div>
            <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full rounded-lg border-green-300 focus:border-green-500 focus:ring-green-500 shadow-sm" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Remember Me -->
                    <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-green-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                            <span class="ml-2 text-sm text-green-700">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                            <a class="underline text-sm text-green-700 hover:text-green-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-lg text-lg font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
    @keyframes bounce-slow {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-12px); }
    }
    .animate-bounce-slow {
      animation: bounce-slow 2.5s infinite;
    }
    </style>
</x-guest-layout>

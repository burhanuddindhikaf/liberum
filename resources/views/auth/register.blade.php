<x-base-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl w-full">
            <div class="flex flex-col lg:flex-row gap-20 items-stretch">

                {{-- Kolom Kiri: Deskripsi Website --}}
                <div class="hidden lg:flex lg:flex-1 mr-8">
                    <div class="bg-white rounded-lg shadow-sm p-8 w-full flex flex-col justify-center">
                        <h1 class="text-4xl font-bold text-gray-900 mb-6">
                            Selamat datang di <span class="text-blue-600">Liberum</span>
                        </h1>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            Platform diskusi terbuka untuk berbagi ide, pemikiran, dan pengalaman dengan komunitas yang beragam.
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Diskusi Berkualitas</h3>
                                    <p class="text-gray-600">Bergabunglah dalam diskusi yang bermakna dengan topik yang beragam</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Komunitas Terbuka</h3>
                                    <p class="text-gray-600">Temukan orang-orang dengan minat yang sama dari berbagai latar belakang</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Bebas Berekspresi</h3>
                                    <p class="text-gray-600">Suarakan pendapat Anda dalam lingkungan yang aman dan mendukung</p>
                                </div>
                            </div>

                        {{-- Team Illustration --}}
                        <div class="mt-8 text-center">
                            <img src="{{ asset('img/team-illustration-new.png') }}"
                                 alt="Tim Liberum"
                                 class="w-64 h-auto mx-auto rounded-lg shadow-sm">
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Form Register --}}
                <div class="flex-1 flex items-center justify-center lg:justify-start ml-8">
                    <div class="w-full max-w-md">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            {{-- Logo --}}
                            <div class="flex items-center justify-center w-full py-4 bg-white border-b">
                                <a href="{{ route('home') }}">
                                    <x-logos.main class="w-32" />
                                </a>
                            </div>

                            {{-- Form Container --}}
                            <div class="px-6 py-6">
                                <x-jet-validation-errors class="mb-4" />        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Nama') }}" />
                <x-jet-input id="name" class="block w-80 mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="username" value="{{ __('Username') }}" />
                <x-jet-input id="username" class="block w-full mt-1" type="text" name="username" :value="old('username')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Konfirmasi Password') }}" />
                <x-jet-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-jet-label for="terms">
                    <div class="flex items-center">
                        <x-jet-checkbox name="terms" id="terms" />

                        <div class="ml-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-sm text-gray-600 underline hover:text-gray-900">'.__('Terms of Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-sm text-gray-600 underline hover:text-gray-900">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-jet-label>
            </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Sudah punya akun?') }}
                </a>

                <x-buttons.primary class="ml-4">
                    {{ __('Daftar') }}
                </x-buttons.primary>
            </div>
        </form>

        {{-- Tombol Lanjutkan Tanpa Daftar --}}
        <div class="mt-6 text-center">
            <a href="{{ route('threads.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 disabled:opacity-25 transition">
                {{ __('Lanjutkan tanpa daftar') }}
            </a>
        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>

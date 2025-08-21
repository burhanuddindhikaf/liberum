<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Ini adalah dashboard Anda. Anda dapat melihat notifikasi terbaru di bawah ini.</p>
                </div>
            </div>

            <!-- Notifications Section -->
            <div id="notifications" class="mt-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Notifikasi</h3>
                    </div>
                    <div class="p-6">
                        @livewire('notifications.index')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

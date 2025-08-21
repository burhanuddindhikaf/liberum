<x-admin-layout>
    {{-- Header --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Thread Menunggu Persetujuan') }}
        </h2>
    </x-slot>

    <section class="px-6">
        @if($threads->count() > 0)
            <div class="space-y-4">
                @foreach($threads as $thread)
                    <div class="bg-white border rounded-lg p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full font-medium">
                                        Menunggu Persetujuan
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        {{ method_exists($thread->created_at, 'diffForHumans') ? $thread->created_at->diffForHumans() : $thread->created_at }}
                                    </span>
                                </div>

                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('admin.threads.show', $thread) }}" class="hover:text-blue-600">
                                        {{ $thread->title }}
                                    </a>
                                </h3>

                                <div class="text-sm text-gray-600 mb-3">
                                    <span class="font-medium">Penulis:</span> {{ $thread->author()->name }} |
                                    <span class="font-medium">Kategori:</span> {{ $thread->category->name }}
                                </div>

                                <div class="text-gray-700 mb-4">
                                    {{ Str::limit(strip_tags($thread->body), 200) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t">
                            <a href="{{ route('admin.threads.show', $thread) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat Detail
                            </a>

                            <div class="flex space-x-3">
                                <form action="{{ route('admin.threads.approve', $thread) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyetujui thread ini?')"
                                            class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                                        ✓ Setujui
                                    </button>
                                </form>

                                <form action="{{ route('admin.threads.reject', $thread) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button" onclick="openRejectModal('{{ $thread->id }}')"
                                            class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                        ✗ Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $threads->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-500 text-lg">
                    🎉 Tidak ada thread yang menunggu persetujuan
                </div>
                <p class="text-gray-400 mt-2">Semua thread sudah diproses.</p>
            </div>
        @endif
    </section>

    {{-- Modal untuk Penolakan --}}
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Alasan Penolakan Thread</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Berikan alasan penolakan:
                        </label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Masukkan alasan mengapa thread ini ditolak..."
                                required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRejectModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Tolak Thread
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(threadId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/admin/threads/${threadId}/reject`;
            modal.classList.remove('hidden');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
            document.getElementById('rejection_reason').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-admin-layout>

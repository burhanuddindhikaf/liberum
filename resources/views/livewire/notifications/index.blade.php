<div class="space-y-4">
    @if (!$notifications->isEmpty())
        @foreach ($notifications as $notification)
            <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-start space-x-3">
                    @if(isset($notification->data['type']))
                        @if($notification->data['type'] == 'thread_approved')
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-green-800">Thread Disetujui</p>
                                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $notification->data['message'] }}</p>
                            </div>
                        @elseif($notification->data['type'] == 'thread_rejected')
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-red-800">Thread Ditolak</p>
                                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $notification->data['message'] }}</p>
                                @if(isset($notification->data['rejection_reason']))
                                    <p class="text-xs text-red-600 mt-2 bg-red-50 px-2 py-1 rounded">
                                        Alasan: {{ $notification->data['rejection_reason'] }}
                                    </p>
                                @endif
                            </div>
                        @else
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 0 0-15 0v5h5l-5 5-5-5h5V7a9 9 0 1 1 18 0v10z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-800">Notifikasi</p>
                                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">
                                    @if(isset($notification->data['replyable_id']))
                                        A new reply was added to
                                        <a href="{{ route('replies.replyAble', [$notification->data['replyable_id'], $notification->data['replyable_type']]) }}" class="text-blue-500 hover:text-blue-700 font-medium">
                                            {{ $notification->data['replyable_subject'] ?? 'Thread' }}
                                        </a>
                                    @else
                                        {{ $notification->data['message'] ?? 'Notification' }}
                                    @endif
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 0 0-15 0v5h5l-5 5-5-5h5V7a9 9 0 1 1 18 0v10z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-800">Notifikasi</p>
                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                @if(isset($notification->data['replyable_id']))
                                    A new reply was added to
                                    <a href="{{ route('replies.replyAble', [$notification->data['replyable_id'], $notification->data['replyable_type']]) }}" class="text-blue-500 hover:text-blue-700 font-medium">
                                        {{ $notification->data['replyable_subject'] ?? 'Thread' }}
                                    </a>
                                @else
                                    Notification
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-12">
            <div class="text-gray-500 text-lg">📭 Tidak ada notifikasi</div>
            <p class="text-gray-400 mt-2">Semua notifikasi sudah dibaca atau belum ada notifikasi baru.</p>
        </div>
    @endif
</div>

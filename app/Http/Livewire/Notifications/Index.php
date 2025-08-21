<?php

namespace App\Http\Livewire\Notifications;

use Livewire\Component;
use Livewire\WithPagination;
use App\Policies\NotificationPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Index extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public function mount()
    {
        // Otomatis mark all unread notifications as read ketika halaman dimuat
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.notifications.index', [
            'notifications' => Auth::user()->notifications()->latest()->paginate(10),
        ]);
    }
}

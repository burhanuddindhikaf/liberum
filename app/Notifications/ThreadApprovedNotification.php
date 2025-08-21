<?php

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ThreadApprovedNotification extends Notification
{
    use Queueable;

    protected $thread;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'thread_id' => $this->thread->id,
            'thread_title' => $this->thread->title,
            'thread_slug' => $this->thread->slug,
            'message' => 'Thread Anda "' . $this->thread->title . '" telah disetujui dan dipublikasikan.',
            'type' => 'thread_approved',
            'approved_at' => $this->thread->approved_at,
        ];
    }
}

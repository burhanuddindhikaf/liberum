<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING NOTIFICATIONS ===\n";

// Dapatkan user pertama (non-admin)
$user = App\Models\User::where('type', '!=', 3)->first();

if (!$user) {
    echo "Tidak ada user non-admin ditemukan.\n";
    exit;
}

echo "Testing notifications untuk user: {$user->name} (ID: {$user->id})\n";

// Buat thread baru
$thread = new App\Models\Thread([
    'title' => 'Test Thread untuk Notifikasi',
    'slug' => 'test-thread-untuk-notifikasi-' . time(),
    'body' => 'Ini adalah thread test untuk menguji sistem notifikasi.',
    'category_id' => 1,
    'status' => 'pending',
]);

$thread->authoredBy($user);
$thread->save();

echo "Thread dibuat: {$thread->title} (ID: {$thread->id})\n";

// Test notification approved
echo "\n--- Testing ThreadApprovedNotification ---\n";
$thread->update([
    'status' => 'approved',
    'approved_at' => now(),
    'approved_by' => 1,
]);

$approvedNotification = new App\Notifications\ThreadApprovedNotification($thread);
$user->notify($approvedNotification);

echo "✅ ThreadApprovedNotification sent!\n";

// Test notification rejected
echo "\n--- Testing ThreadRejectedNotification ---\n";
$thread->update([
    'status' => 'rejected',
    'rejection_reason' => 'Konten tidak sesuai dengan aturan komunitas.',
]);

$rejectedNotification = new App\Notifications\ThreadRejectedNotification($thread);
$user->notify($rejectedNotification);

echo "❌ ThreadRejectedNotification sent!\n";

// Cek notifications
echo "\n--- Checking User Notifications ---\n";
$notifications = $user->notifications()->latest()->take(5)->get();

foreach ($notifications as $notification) {
    echo "- {$notification->data['type']}: {$notification->data['message']}\n";
    if (isset($notification->data['rejection_reason'])) {
        echo "  Alasan: {$notification->data['rejection_reason']}\n";
    }
    echo "  Created: {$notification->created_at}\n\n";
}

echo "Total unread notifications: " . $user->unreadNotifications->count() . "\n";
echo "\nTest selesai! Silakan cek di browser: http://127.0.0.1:8000/dashboard/notifications\n";

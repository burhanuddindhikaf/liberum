<?php
// Test Notification Button in Navigation
require_once __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use App\Models\Thread;
use App\Notifications\ThreadApprovedNotification;
use App\Notifications\ThreadRejectedNotification;

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing Notification Button Implementation...\n";

// 1. Test user with notifications
$user = User::where('email', 'user@example.com')->first();
if (!$user) {
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
    ]);
    echo "✓ Created test user: {$user->email}\n";
} else {
    echo "✓ Using existing test user: {$user->email}\n";
}

// 2. Create test thread for notifications
$thread = Thread::create([
    'author_id' => $user->id,
    'title' => 'Test Thread for Navigation Notification',
    'slug' => 'test-thread-nav-' . time(),
    'body' => 'This is a test thread for navigation notification button',
    'category_id' => 1,
    'status' => 'pending',
    'approved' => false,
]);
echo "✓ Created test thread: {$thread->title}\n";

// 3. Create notifications for testing
// Approved notification
$user->notify(new ThreadApprovedNotification($thread));
echo "✓ Sent approval notification\n";

// Rejected notification
$thread->update(['rejection_reason' => 'Test rejection reason for navigation']);
$user->notify(new ThreadRejectedNotification($thread));
echo "✓ Sent rejection notification\n";

// 4. Check notification count
$unreadCount = $user->unreadNotifications->count();
echo "✓ User has {$unreadCount} unread notifications\n";

// 5. Test navigation data
echo "\n--- Navigation Test Data ---\n";
echo "User ID: {$user->id}\n";
echo "User Name: {$user->name}\n";
echo "Unread Notifications: {$unreadCount}\n";
echo "Dashboard URL: /dashboard/notifications\n";

// 6. Show notification details
echo "\n--- Notification Details ---\n";
foreach ($user->unreadNotifications as $notification) {
    echo "- ID: {$notification->id}\n";
    echo "  Type: {$notification->type}\n";
    echo "  Data: " . json_encode($notification->data) . "\n";
    echo "  Created: {$notification->created_at}\n\n";
}

echo "✓ Notification button test data prepared successfully!\n";
echo "\nTo test:\n";
echo "1. Login as user@example.com (password: password)\n";
echo "2. Check navigation bar for notification button with badge\n";
echo "3. Click notification button to go to /dashboard/notifications\n";
echo "4. Verify notifications are auto-marked as read\n";

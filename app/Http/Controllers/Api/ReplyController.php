<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyResource;
use App\Models\ReplyApi as Reply;
use App\Models\ReplyAble;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Tampilkan semua reply
     */
    public function index()
    {
        $replies = Reply::with(['author', 'media'])->get();

    return response()->json([
        'data' => $replies
    ]);
    }

    /**
     * Simpan reply barua
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'replyable_type' => 'required|string', // Nama model seperti App\Models\Post
            'replyable_id'   => 'required|integer',
        ]);

        // Buat reply
$map = [
    'thread'  => \App\Models\Thread::class,
    'threads' => \App\Models\Thread::class, // kalau kamu pakai plural
    'reply'   => \App\Models\Reply::class,
    'replies' => \App\Models\Reply::class,
];

// Pastikan type yang dikirim ada di mapping
$type = strtolower($request->replyable_type);

if (!array_key_exists($type, $map)) {
    return response()->json([
        'error' => "Invalid replyable_type"
    ], 400);
}

// Cari model target
$modelClass = $map[$type];
$model = $modelClass::findOrFail($request->replyable_id);

// Buat reply baru
$reply = new Reply([
    'body' => $request->body,
]);

$reply->author()->associate(auth()->user());
$reply->replyAbleRelation()->associate($model);
$reply->save();

        return response()->json([
            'message' => 'Reply berhasil dibuat',
            'data' => $reply
        ], 201);
    }

    /**
     * Tampilkan detail reply
     */
    public function show($id)
{
    $reply = reply::with(['media', 'author', 'category'])->findOrFail($id);
    return response()->json([
        'data' => $reply
    ]);
}


    /**
     * Update reply
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $reply = Reply::findOrFail($id);
        $reply->update([
            'body' => $request->body
        ]);

        return response()->json([
            'message' => 'Reply berhasil diperbarui',
            'data' => $reply
        ]);
    }

    /**
     * Hapus reply
     */
    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);
        $reply->delete();

        return response()->json([
            'message' => 'Reply berhasil dihapus'
        ]);
    }
}

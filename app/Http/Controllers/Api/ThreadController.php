<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ThreadResource;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::with(['user', 'media'])->where('status', 'approved')->latest()->paginate(10);
return ThreadResource::collection($threads);

    }

    public function store(Request $request)
{
    $data = $request->validate([
        'title'       => 'required|string|max:255',
        'body'        => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'images'      => 'nullable|array', // validasi array file
        'images.*'    => 'nullable|image|max:2048', // setiap file harus image
    ]);

    $thread = Thread::create([
        'title'      => $data['title'],
        'body'       => $data['body'],
        'category_id'=> $data['category_id'],
        'slug'       => Str::slug($data['title']), // slug otomatis
        'author_id'  => $request->user()->id
    ]);

    // Jika ada banyak file upload
    if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Nama file random (misal pakai uuid + extension)
                $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();

                // Nama file asli
                $originalFilename = $image->getClientOriginalName();

                // Simpan ke storage/app/public/uploads/thread_images/
                $path = $image->storeAs('threads', $filename, 'public');
                 if ($index === 0) {
                    $image->storeAs('threads/thumbnails', $filename, 'public');
                }

                // Simpan ke DBa
                DB::table('media')->insert([
                    'mediable_id'         => $thread->id,
                    'filename'          => $filename,
                    'original_filename' => $originalFilename,
                    'path'              => $path,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                    'mime_type'        => $image->getClientMimeType(),
                    'size'             => $image->getSize(),
                    'mediable_type'    => "threads"
                ]);
            }
}


    return new ThreadResource($thread);
}



    public function show(Thread $thread)
    {
        return new ThreadResource($thread->load('user','media'));
    }

    public function update(Request $request, Thread $thread)
    {
        $this->authorize('update', $thread);

        $data = $request->validate([
            'title' => 'string|max:255',
            'body' => 'string'
        ]);

        $thread->update($data);
        return new ThreadResource($thread);
    }

    public function destroy(Thread $thread)
    {
        $this->authorize('delete', $thread);
        $thread->delete();

        return response()->json(['message' => 'Thread deleted']);
    }
}

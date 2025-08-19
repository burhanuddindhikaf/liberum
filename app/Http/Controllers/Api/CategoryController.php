<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Menampilkan semua kategori
     */
    public function index()
    {
        return response()->json([
            'data' => Category::latest()->get()
        ], 200);
    }

    /**
     * Menyimpan kategori barua
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name'])
        ]);

        return response()->json([
            'message' => 'Kategori berhasil dibuat',
            'data' => $category
        ], 201);
    }

    /**
     * Menampilkan kategori berdasarkan ID
     */
    public function show($id)
    {
        $category = Category::with('threads')->findOrFail($id);

        return response()->json([
            'data' => $category
        ], 200);
    }

    /**
     * Mengupdate kategori
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name'])
        ]);

        return response()->json([
            'message' => 'Kategori berhasil diperbarui',
            'data' => $category
        ], 200);
    }

    /**
     * Menghapus kategori
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Kategori berhasil dihapus'
        ], 200);
    }
}

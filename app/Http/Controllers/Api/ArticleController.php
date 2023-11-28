<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        return response()->json($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            // Validasi gambar
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            // Upload gambar dan dapatkan path gambar yang diupload
            $imagePath = $request->file('image')->store('public/images');

            $validated['image'] = $imagePath;
        }

        $article = Article::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'category_id' => $validated['category_id'],
            'image' => $validated['image'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
        ]);

        if ($request->has('tags')) {
            $article->tags()->attach($request->input('tags'));
        }

        return response()->json($article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return response()->json($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imagePath = $request->file('image')->store('public/images');

            if ($article->image) {
                Storage::delete($article->image);
            }

            $validated['image'] = $imagePath;
        }

        $article->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'published_at' => $request->has('is_published') ? Carbon::now() : null,
            'image' => $validated['image'] ?? $article->image,
            'category_id' => $validated['category_id'] ?? $article->category_id,
        ]);

        if ($request->has('tags')) {
            $article->tags()->sync($request->input('tags'));
        }

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::delete($article->image);
        }
        $article->delete();
        return response()->json($article);
    }
}

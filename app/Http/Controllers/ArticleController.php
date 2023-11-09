<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$articles = Article::all();
        $articles = Article::paginate(10);
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string'
        ]);

        if ($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,gif,svg|max:2048'
            ]);

           // Upload gambar dan dapatkan path gambar yang diupload
           $imagePath = $request->file('image')->store('public/images');

           $validated['image'] = $imagePath;
        }
        // Buat artikel baru
        $article = Article::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'image' => $validated['image'] ?? null,
            'published_at' => $request->has('is_published') ? Carbon::now() : false,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article Created.');
    }
public function __construct()
    {
        //Hanya user yang sudah login yang bsa akses ini
        $this->middleware('auth')->except(['show', 'methhodSatu']);
        //Hanya admin yang bisa akses route ini
        $this->middleware('admin')->except(['show']);
    }


    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string'
        ]);

        if ($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,gif,svg|max:2048'
            ]);

           // Upload gambar dan dapatkan path gambar yang diupload
           $imagePath = $request->file('image')->store('public/images');

           // Hapus gambar lama jika ada
           if ($article->image) {
            Storage::delete($article->image);
           }

           $validated['image'] = $imagePath;
        }
        // Update artikel
        $article->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'image' => $validated['image'] ?? $article->image,
            //Jika tidak ada gambar baru, gunakan gambar lama
            'published_at' => $request->has('is_published') ? Carbon::now() : null,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
       // Hapus gambar jika ada
        if ($article->image) {
            Storage::delete($article->image);
        }
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::paginate(20);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Store the category
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
        ]);

        //Ubah menjadi lowercase
        $validated['slug'] = strtolower($validated['slug']);
        //Ganti spasi dengan dash (jika ada)
        $validated['slug'] = str_replace(' ', '-', $validated['slug']);

        // Menyimpan Category
        $category = Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //Update the category
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //Update the category
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|string|min:3|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        //Ubah menjadi lowercase
        $validated['slug'] = strtolower($validated['slug']);
        //Ganti spasi dengan dash (jika ada)
        $validated['slug'] = str_replace(' ', '-', $validated['slug']);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}

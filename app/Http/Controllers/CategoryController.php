<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\CategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('items')->paginate(5);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'division_pj' => 'required|in:Tata Usaha,Sarpras,Tefa'
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'division_pj' => 'required|in:Tata Usaha,Sarpras,Tefa'
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil diupdate');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new CategoriesExport, 'categories.xlsx');
    }
}

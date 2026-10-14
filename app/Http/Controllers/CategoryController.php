<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    private function rules(?Category $item = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($item?->id)],
            'description' => ['nullable', 'string'],
        ];
    }

    public function index(Request $request)
    {
        $items = Category::withCount('products')
            ->when($request->q, fn ($query, $s) => $query->where('name', 'like', "%{$s}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('items'));
    }

    public function create()
    {
        return view('categories.create', ['item' => new Category]);
    }

    public function store(Request $request)
    {
        Category::create($request->validate($this->rules()));

        return redirect()->route('categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', ['item' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->validate($this->rules($category)));

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete(); // products keep existing; their link is set to null

        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}

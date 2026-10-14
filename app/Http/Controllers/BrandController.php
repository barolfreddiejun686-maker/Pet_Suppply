<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    private function rules(?Brand $item = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('brands', 'name')->ignore($item?->id)],
            'description' => ['nullable', 'string'],
        ];
    }

    public function index(Request $request)
    {
        $items = Brand::withCount('products')
            ->when($request->q, fn ($query, $s) => $query->where('name', 'like', "%{$s}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('brands.index', compact('items'));
    }

    public function create()
    {
        return view('brands.create', ['item' => new Brand]);
    }

    public function store(Request $request)
    {
        Brand::create($request->validate($this->rules()));

        return redirect()->route('brands.index')->with('success', 'Brand created.');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', ['item' => $brand]);
    }

    public function update(Request $request, Brand $brand)
    {
        $brand->update($request->validate($this->rules($brand)));

        return redirect()->route('brands.index')->with('success', 'Brand updated.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete(); // products keep existing; their link is set to null

        return redirect()->route('brands.index')->with('success', 'Brand deleted.');
    }
}

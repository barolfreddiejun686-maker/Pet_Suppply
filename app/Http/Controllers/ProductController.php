<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private function rules(?Product $product = null): array
    {
        return [
            'category_id'   => ['nullable', 'exists:categories,id'],
            'brand_id'      => ['nullable', 'exists:brands,id'],
            'supplier_id'   => ['nullable', 'exists:suppliers,id'],
            'name'          => ['required', 'string', 'max:255'],
            'sku'           => ['required', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($product?->id)],
            'pet_type'      => ['nullable', Rule::in(array_keys(Product::PET_TYPES))],
            'description'   => ['nullable', 'string'],
            'cost_price'    => ['required', 'numeric', 'min:0'],
            'price'         => ['required', 'numeric', 'min:0'],
            'reorder_level' => ['nullable', 'integer', 'min:0'],
            'expiry_date'   => ['nullable', 'date'],
        ];
    }

    private function formData(Product $product): array
    {
        return [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
            'brands'     => Brand::orderBy('name')->get(),
            'suppliers'  => Supplier::orderBy('name')->get(),
        ];
    }

    public function index(Request $request)
    {
        $products = Product::with(['category', 'brand', 'supplier'])
            ->when($request->q, fn ($query, $s) => $query->where(
                fn ($w) => $w->where('name', 'like', "%{$s}%")->orWhere('sku', 'like', "%{$s}%")
            ))
            ->when($request->category_id, fn ($query, $v) => $query->where('category_id', $v))
            ->when($request->brand_id, fn ($query, $v) => $query->where('brand_id', $v))
            ->when($request->pet_type, fn ($query, $v) => $query->where('pet_type', $v))
            ->when($request->boolean('low'), fn ($query) => $query->lowStock())
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', [
            'products'   => $products,
            'categories' => Category::orderBy('name')->get(),
            'brands'     => Brand::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('products.create', $this->formData(new Product(['stock' => 0, 'reorder_level' => 5])));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules() + [
            'stock' => ['required', 'integer', 'min:0'],
        ]);
        $data['reorder_level'] ??= 5;

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Pet supply added.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', $this->formData($product));
    }

    public function update(Request $request, Product $product)
    {
        // Stock is intentionally not editable here: change it with a transaction
        // so every movement is recorded.
        $data = $request->validate($this->rules($product));
        $data['reorder_level'] ??= 5;

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Pet supply updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->transactionItems()->exists()) {
            return back()->withErrors(['product' => "Cannot delete \"{$product->name}\" because it has transaction history."]);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Pet supply deleted.');
    }
}

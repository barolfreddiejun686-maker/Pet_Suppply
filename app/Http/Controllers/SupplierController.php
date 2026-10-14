<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    private function rules(?Supplier $item = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('suppliers', 'name')->ignore($item?->id)],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
        ];
    }

    public function index(Request $request)
    {
        $items = Supplier::withCount('products')
            ->when($request->q, fn ($query, $s) => $query->where('name', 'like', "%{$s}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('suppliers.index', compact('items'));
    }

    public function create()
    {
        return view('suppliers.create', ['item' => new Supplier]);
    }

    public function store(Request $request)
    {
        Supplier::create($request->validate($this->rules()));

        return redirect()->route('suppliers.index')->with('success', 'Supplier created.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', ['item' => $supplier]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier->update($request->validate($this->rules($supplier)));

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete(); // products keep existing; their link is set to null

        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted.');
    }
}

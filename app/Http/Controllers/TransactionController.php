<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('supplier')
            ->withCount('items')
            ->when($request->type, fn ($q, $t) => $q->where('type', $t))
            ->when($request->q, fn ($q, $s) => $q->where('reference_no', 'like', "%{$s}%"))
            ->latest('transacted_at')
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create', [
            'products'  => Product::orderBy('name')->get(['id', 'name', 'sku', 'stock', 'cost_price', 'price']),
            'suppliers' => Supplier::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'                => ['required', Rule::in(array_keys(Transaction::TYPES))],
            'supplier_id'         => ['nullable', 'exists:suppliers,id'],
            'customer_name'       => ['nullable', 'string', 'max:255'],
            'notes'               => ['nullable', 'string'],
            'transacted_at'       => ['nullable', 'date'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.product_id'  => ['required', 'distinct', 'exists:products,id'],
            'items.*.quantity'    => ['required', 'integer', 'min:1'],
            'items.*.unit_price'  => ['required', 'numeric', 'min:0'],
        ], [
            'items.*.product_id.distinct' => 'Each product can only appear once per transaction.',
            'items.required'              => 'Add at least one item.',
        ]);

        $isIn = $data['type'] === 'stock_in';

        $transaction = DB::transaction(function () use ($data, $isIn) {
            $transaction = Transaction::create([
                'reference_no'  => ($isIn ? 'IN-' : 'OUT-') . now()->format('Ymd') . '-' . Str::upper(Str::random(5)),
                'type'          => $data['type'],
                'supplier_id'   => $isIn ? ($data['supplier_id'] ?? null) : null,
                'customer_name' => $isIn ? null : ($data['customer_name'] ?? null),
                'notes'         => $data['notes'] ?? null,
                'total'         => 0,
                'transacted_at' => $data['transacted_at'] ?? now(),
            ]);

            $total = 0;

            foreach ($data['items'] as $row) {
                $product = Product::lockForUpdate()->findOrFail($row['product_id']);
                $qty = (int) $row['quantity'];

                if ($isIn) {
                    $product->increment('stock', $qty);
                } else {
                    if ($product->stock < $qty) {
                        throw ValidationException::withMessages([
                            'items' => "Not enough stock for {$product->name} (available: {$product->stock}, requested: {$qty}).",
                        ]);
                    }
                    $product->decrement('stock', $qty);
                }

                $subtotal = round($qty * (float) $row['unit_price'], 2);
                $total += $subtotal;

                $transaction->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'unit_price' => $row['unit_price'],
                    'subtotal'   => $subtotal,
                ]);
            }

            $transaction->update(['total' => $total]);

            return $transaction;
        });

        return redirect()->route('transactions.show', $transaction)->with('success', 'Transaction recorded and stock updated.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('items.product', 'supplier');

        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            foreach ($transaction->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);

                if ($transaction->type === 'stock_in') {
                    // Undoing a restock removes stock, which must not go negative.
                    if ($product->stock < $item->quantity) {
                        throw ValidationException::withMessages([
                            'transaction' => "Cannot delete: {$product->name} has only {$product->stock} in stock, but this restock added {$item->quantity}.",
                        ]);
                    }
                    $product->decrement('stock', $item->quantity);
                } else {
                    $product->increment('stock', $item->quantity);
                }
            }

            $transaction->delete(); // items are removed by the cascade
        });

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted and stock restored.');
    }
}

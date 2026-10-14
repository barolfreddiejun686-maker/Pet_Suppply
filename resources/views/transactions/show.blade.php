@extends('layouts.app')
@section('title', $transaction->reference_no)

@section('content')
<div class="top">
    <h1>{{ $transaction->reference_no }}</h1>
    <div class="actions">
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Back</a>
        <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" onsubmit="return confirm('Delete this transaction and reverse its stock changes?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="grid" style="margin-bottom:16px">
        <div><div class="muted">Type</div><span class="badge {{ $transaction->type === 'stock_in' ? 'badge-blue' : 'badge-green' }}">{{ $transaction->type_label }}</span></div>
        <div><div class="muted">Date</div>{{ $transaction->transacted_at->format('M d, Y h:i A') }}</div>
        <div>
            <div class="muted">{{ $transaction->type === 'stock_in' ? 'Supplier' : 'Customer' }}</div>
            {{ $transaction->type === 'stock_in' ? ($transaction->supplier?->name ?? '—') : ($transaction->customer_name ?: 'Walk-in') }}
        </div>
        <div><div class="muted">Notes</div>{{ $transaction->notes ?: '—' }}</div>
    </div>

    <table>
        <thead><tr><th>SKU</th><th>Product</th><th>Qty</th><th>Unit price</th><th class="right">Subtotal</th></tr></thead>
        <tbody>
            @foreach ($transaction->items as $item)
                <tr>
                    <td>{{ $item->product->sku }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱{{ number_format($item->unit_price, 2) }}</td>
                    <td class="right">₱{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr><th colspan="4" class="right">Total</th><th class="right">₱{{ number_format($transaction->total, 2) }}</th></tr>
        </tfoot>
    </table>
</div>
@endsection

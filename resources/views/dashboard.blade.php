@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h1>Dashboard</h1>

<div class="stats">
    <a class="stat" href="{{ route('products.index') }}"><span>{{ $productCount }}</span>Pet supplies</a>
    <a class="stat" href="{{ route('categories.index') }}"><span>{{ $categoryCount }}</span>Categories</a>
    <a class="stat" href="{{ route('brands.index') }}"><span>{{ $brandCount }}</span>Brands</a>
    <a class="stat" href="{{ route('suppliers.index') }}"><span>{{ $supplierCount }}</span>Suppliers</a>
    <div class="stat"><span>₱{{ number_format($stockValue, 2) }}</span>Stock value (at cost)</div>
</div>

<div class="two-col">
    <div class="card">
        <div class="top"><h2>Low stock</h2><a href="{{ route('products.index', ['low' => 1]) }}">View all</a></div>
        <table>
            <thead><tr><th>Product</th><th>Stock</th><th>Reorder at</th></tr></thead>
            <tbody>
            @forelse ($lowStock as $p)
                <tr>
                    <td><a href="{{ route('products.edit', $p) }}">{{ $p->name }}</a><div class="muted">{{ $p->sku }}</div></td>
                    <td><span class="badge badge-red">{{ $p->stock }}</span></td>
                    <td>{{ $p->reorder_level }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="muted">Everything is stocked.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2>Expiring within 30 days</h2>
        <table>
            <thead><tr><th>Product</th><th>Expires</th><th>Stock</th></tr></thead>
            <tbody>
            @forelse ($expiring as $p)
                <tr>
                    <td><a href="{{ route('products.edit', $p) }}">{{ $p->name }}</a></td>
                    <td>{{ $p->expiry_date->format('M d, Y') }}</td>
                    <td>{{ $p->stock }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="muted">Nothing expiring soon.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card" style="margin-top:20px">
    <div class="top"><h2>Recent transactions</h2><a href="{{ route('transactions.create') }}" class="btn btn-sm">+ New transaction</a></div>
    <table>
        <thead><tr><th>Reference</th><th>Type</th><th>Items</th><th>Total</th><th>Date</th></tr></thead>
        <tbody>
        @forelse ($recent as $t)
            <tr>
                <td><a href="{{ route('transactions.show', $t) }}">{{ $t->reference_no }}</a></td>
                <td><span class="badge {{ $t->type === 'stock_in' ? 'badge-blue' : 'badge-green' }}">{{ $t->type_label }}</span></td>
                <td>{{ $t->items_count }}</td>
                <td>₱{{ number_format($t->total, 2) }}</td>
                <td>{{ $t->transacted_at->format('M d, Y h:i A') }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="muted">No transactions yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

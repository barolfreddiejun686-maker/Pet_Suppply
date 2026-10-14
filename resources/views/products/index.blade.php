@extends('layouts.app')
@section('title', 'Pet Supplies')

@section('content')
<div class="top">
    <h1>Pet Supplies</h1>
    <a href="{{ route('products.create') }}" class="btn">+ Add Pet Supply</a>
</div>

<div class="card">
    <form method="GET" class="filters">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or SKU...">
        <select name="category_id">
            <option value="">All categories</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        <select name="brand_id">
            <option value="">All brands</option>
            @foreach ($brands as $b)
                <option value="{{ $b->id }}" @selected(request('brand_id') == $b->id)>{{ $b->name }}</option>
            @endforeach
        </select>
        <select name="pet_type">
            <option value="">All pets</option>
            @foreach (\App\Models\Product::PET_TYPES as $value => $label)
                <option value="{{ $value }}" @selected(request('pet_type') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <label style="display:flex;align-items:center;gap:6px;margin:0;font-weight:400">
            <input type="checkbox" name="low" value="1" @checked(request()->boolean('low'))> Low stock only
        </label>
        <button class="btn btn-secondary">Filter</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>SKU</th><th>Name</th><th>Category</th><th>Brand</th>
                <th>Cost</th><th>Price</th><th>Stock</th><th>Expiry</th><th class="right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $p)
                <tr>
                    <td>{{ $p->sku }}</td>
                    <td>
                        {{ $p->name }}
                        @if ($p->pet_type)<div class="muted">{{ \App\Models\Product::PET_TYPES[$p->pet_type] ?? $p->pet_type }}</div>@endif
                    </td>
                    <td>{{ $p->category?->name ?? '—' }}</td>
                    <td>{{ $p->brand?->name ?? '—' }}</td>
                    <td>₱{{ number_format($p->cost_price, 2) }}</td>
                    <td>₱{{ number_format($p->price, 2) }}</td>
                    <td><span class="badge {{ $p->is_low_stock ? 'badge-red' : 'badge-green' }}">{{ $p->stock }}</span></td>
                    <td>{{ $p->expiry_date?->format('M d, Y') ?? '—' }}</td>
                    <td class="right actions">
                        <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('products.destroy', $p) }}" onsubmit="return confirm('Delete this pet supply?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="muted">No pet supplies found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="pager">{{ $products->links() }}</div>
</div>
@endsection

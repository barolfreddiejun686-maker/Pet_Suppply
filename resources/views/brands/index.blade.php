@extends('layouts.app')
@section('title', 'Brands')

@section('content')
<div class="top">
    <h1>Brands</h1>
    <a href="{{ route('brands.create') }}" class="btn">+ Add Brand</a>
</div>

<div class="card">
    <form method="GET" class="filters">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name...">
        <button class="btn btn-secondary">Search</button>
    </form>

    <table>
        <thead>
            <tr><th>Name</th><th>Description</th><th>Products</th><th class="right">Actions</th></tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($item->description, 70) ?: '—' }}</td>
                    <td>{{ $item->products_count }}</td>
                    <td class="right actions">
                        <a href="{{ route('brands.edit', $item) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('brands.destroy', $item) }}" onsubmit="return confirm('Delete this brand?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="muted">Nothing here yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="pager">{{ $items->links() }}</div>
</div>
@endsection

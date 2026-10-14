@extends('layouts.app')
@section('title', 'Suppliers')

@section('content')
<div class="top">
    <h1>Suppliers</h1>
    <a href="{{ route('suppliers.create') }}" class="btn">+ Add Supplier</a>
</div>

<div class="card">
    <form method="GET" class="filters">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name...">
        <button class="btn btn-secondary">Search</button>
    </form>

    <table>
        <thead>
            <tr><th>Name</th><th>Contact</th><th>Phone</th><th>Email</th><th>Products</th><th class="right">Actions</th></tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->contact_person ?: '—' }}</td>
                    <td>{{ $item->phone ?: '—' }}</td>
                    <td>{{ $item->email ?: '—' }}</td>
                    <td>{{ $item->products_count }}</td>
                    <td class="right actions">
                        <a href="{{ route('suppliers.edit', $item) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('suppliers.destroy', $item) }}" onsubmit="return confirm('Delete this supplier?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">Nothing here yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="pager">{{ $items->links() }}</div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Transactions')

@section('content')
<div class="top">
    <h1>Transactions</h1>
    <a href="{{ route('transactions.create') }}" class="btn">+ New Transaction</a>
</div>

<div class="card">
    <form method="GET" class="filters">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search reference...">
        <select name="type">
            <option value="">All types</option>
            @foreach (\App\Models\Transaction::TYPES as $value => $label)
                <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="btn btn-secondary">Filter</button>
    </form>

    <table>
        <thead>
            <tr><th>Reference</th><th>Type</th><th>Supplier / Customer</th><th>Items</th><th>Total</th><th>Date</th><th class="right">Actions</th></tr>
        </thead>
        <tbody>
            @forelse ($transactions as $t)
                <tr>
                    <td><a href="{{ route('transactions.show', $t) }}">{{ $t->reference_no }}</a></td>
                    <td><span class="badge {{ $t->type === 'stock_in' ? 'badge-blue' : 'badge-green' }}">{{ $t->type_label }}</span></td>
                    <td>{{ $t->type === 'stock_in' ? ($t->supplier?->name ?? '—') : ($t->customer_name ?: 'Walk-in') }}</td>
                    <td>{{ $t->items_count }}</td>
                    <td>₱{{ number_format($t->total, 2) }}</td>
                    <td>{{ $t->transacted_at->format('M d, Y h:i A') }}</td>
                    <td class="right actions">
                        <a href="{{ route('transactions.show', $t) }}" class="btn btn-sm btn-secondary">View</a>
                        <form method="POST" action="{{ route('transactions.destroy', $t) }}" onsubmit="return confirm('Delete this transaction and reverse its stock changes?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="muted">No transactions yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="pager">{{ $transactions->links() }}</div>
</div>
@endsection

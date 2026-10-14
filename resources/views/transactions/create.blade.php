@extends('layouts.app')
@section('title', 'New Transaction')

@section('content')
<div class="card">
    <h1>New Transaction</h1>

    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf
        <div class="grid">
            <div class="field">
                <label for="type">Type *</label>
                <select id="type" name="type" required>
                    @foreach (\App\Models\Transaction::TYPES as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', 'stock_out') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="transacted_at">Date &amp; time</label>
                <input type="datetime-local" id="transacted_at" name="transacted_at" value="{{ old('transacted_at', now()->format('Y-m-d\TH:i')) }}">
            </div>

            <div class="field" id="supplier-box">
                <label for="supplier_id">Supplier</label>
                <select id="supplier_id" name="supplier_id">
                    <option value="">-- None --</option>
                    @foreach ($suppliers as $s)
                        <option value="{{ $s->id }}" @selected(old('supplier_id') == $s->id)>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field" id="customer-box">
                <label for="customer_name">Customer name</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" placeholder="Leave blank for walk-in">
            </div>

            <div class="full field">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
            </div>
        </div>

        <h3>Items</h3>
        <table>
            <thead><tr><th style="width:45%">Pet supply</th><th>Qty</th><th>Unit price (₱)</th><th>Subtotal</th><th></th></tr></thead>
            <tbody id="rows"></tbody>
            <tfoot>
                <tr><th colspan="3" class="right">Total</th><th id="total">₱0.00</th><th></th></tr>
            </tfoot>
        </table>
        <p><button type="button" id="add-row" class="btn btn-secondary btn-sm">+ Add item</button></p>

        <p class="form-actions">
            <button type="submit" class="btn">Save Transaction</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
        </p>
    </form>
</div>

{{-- Template for the product dropdown in each row --}}
<select id="product-template" hidden>
    <option value="">-- Select pet supply --</option>
    @foreach ($products as $p)
        <option value="{{ $p->id }}" data-cost="{{ $p->cost_price }}" data-price="{{ $p->price }}">
            {{ $p->name }} ({{ $p->sku }}) · stock {{ $p->stock }}
        </option>
    @endforeach
</select>

<script>
    const initialRows = @json(old('items', [['product_id' => '', 'quantity' => 1, 'unit_price' => '']]));
    const rows = document.getElementById('rows');
    const typeSelect = document.getElementById('type');
    const template = document.getElementById('product-template');
    let counter = 0;

    const money = n => '₱' + n.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    function defaultPrice(option) {
        if (!option || !option.value) return '';
        return typeSelect.value === 'stock_in' ? option.dataset.cost : option.dataset.price;
    }

    function recalc() {
        let total = 0;
        rows.querySelectorAll('tr').forEach(tr => {
            const sub = (parseFloat(tr.querySelector('.qty').value) || 0) * (parseFloat(tr.querySelector('.price').value) || 0);
            tr.querySelector('.sub').textContent = money(sub);
            total += sub;
        });
        document.getElementById('total').textContent = money(total);
    }

    function addRow(data = {}) {
        const i = counter++;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><select name="items[${i}][product_id]" class="prod" required>${template.innerHTML}</select></td>
            <td><input type="number" min="1" name="items[${i}][quantity]" class="qty" required></td>
            <td><input type="number" min="0" step="0.01" name="items[${i}][unit_price]" class="price" required></td>
            <td class="sub">₱0.00</td>
            <td><button type="button" class="btn btn-sm btn-danger remove">×</button></td>`;
        rows.appendChild(tr);

        const select = tr.querySelector('.prod');
        select.value = data.product_id ?? '';
        tr.querySelector('.qty').value = data.quantity ?? 1;
        tr.querySelector('.price').value = data.unit_price ?? defaultPrice(select.selectedOptions[0]);

        select.addEventListener('change', () => {
            tr.querySelector('.price').value = defaultPrice(select.selectedOptions[0]);
            recalc();
        });
        tr.querySelectorAll('.qty, .price').forEach(el => el.addEventListener('input', recalc));
        tr.querySelector('.remove').addEventListener('click', () => {
            if (rows.children.length > 1) { tr.remove(); recalc(); }
        });
        recalc();
    }

    function syncType() {
        const isIn = typeSelect.value === 'stock_in';
        document.getElementById('supplier-box').style.display = isIn ? '' : 'none';
        document.getElementById('customer-box').style.display = isIn ? 'none' : '';
        rows.querySelectorAll('tr').forEach(tr => {
            const select = tr.querySelector('.prod');
            if (select.value) tr.querySelector('.price').value = defaultPrice(select.selectedOptions[0]);
        });
        recalc();
    }

    document.getElementById('add-row').addEventListener('click', () => addRow());
    typeSelect.addEventListener('change', syncType);

    initialRows.forEach(r => addRow(r));
    syncType();
</script>
@endsection

<div class="grid">
    <div class="full field">
        <label for="name">Product name *</label>
        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        @error('name') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="sku">SKU *</label>
        <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
        @error('sku') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="pet_type">Pet type</label>
        <select id="pet_type" name="pet_type">
            <option value="">-- Select --</option>
            @foreach (\App\Models\Product::PET_TYPES as $value => $label)
                <option value="{{ $value }}" @selected(old('pet_type', $product->pet_type) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('pet_type') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="category_id">Category</label>
        <select id="category_id" name="category_id">
            <option value="">-- None --</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        @error('category_id') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="brand_id">Brand</label>
        <select id="brand_id" name="brand_id">
            <option value="">-- None --</option>
            @foreach ($brands as $b)
                <option value="{{ $b->id }}" @selected(old('brand_id', $product->brand_id) == $b->id)>{{ $b->name }}</option>
            @endforeach
        </select>
        @error('brand_id') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="full field">
        <label for="supplier_id">Supplier</label>
        <select id="supplier_id" name="supplier_id">
            <option value="">-- None --</option>
            @foreach ($suppliers as $s)
                <option value="{{ $s->id }}" @selected(old('supplier_id', $product->supplier_id) == $s->id)>{{ $s->name }}</option>
            @endforeach
        </select>
        @error('supplier_id') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="cost_price">Cost price (₱) *</label>
        <input type="number" step="0.01" min="0" id="cost_price" name="cost_price" value="{{ old('cost_price', $product->cost_price ?? '0.00') }}" required>
        @error('cost_price') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="price">Selling price (₱) *</label>
        <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price', $product->price ?? '0.00') }}" required>
        @error('price') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="stock">Stock {{ $product->exists ? '' : '*' }}</label>
        @if ($product->exists)
            <input type="number" id="stock" value="{{ $product->stock }}" disabled>
            <div class="hint">Change stock by creating a transaction.</div>
        @else
            <input type="number" min="0" id="stock" name="stock" value="{{ old('stock', 0) }}" required>
            @error('stock') <div class="error">{{ $message }}</div> @enderror
        @endif
    </div>

    <div class="field">
        <label for="reorder_level">Reorder level</label>
        <input type="number" min="0" id="reorder_level" name="reorder_level" value="{{ old('reorder_level', $product->reorder_level) }}">
        <div class="hint">Flagged as low stock at or below this number.</div>
        @error('reorder_level') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="full field">
        <label for="expiry_date">Expiry date</label>
        <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $product->expiry_date?->format('Y-m-d')) }}">
        @error('expiry_date') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="full field">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
        @error('description') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>

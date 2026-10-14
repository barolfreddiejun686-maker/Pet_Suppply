<div class="field">
    <label for="name">Name *</label>
    <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" required>
    @error('name') <div class="error">{{ $message }}</div> @enderror
</div>
<div class="field">
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="3">{{ old('description', $item->description) }}</textarea>
    @error('description') <div class="error">{{ $message }}</div> @enderror
</div>

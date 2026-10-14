<div class="field">
    <label for="name">Company name *</label>
    <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" required>
    @error('name') <div class="error">{{ $message }}</div> @enderror
</div>
<div class="field">
    <label for="contact_person">Contact person</label>
    <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person', $item->contact_person) }}">
    @error('contact_person') <div class="error">{{ $message }}</div> @enderror
</div>
<div class="field">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email', $item->email) }}">
    @error('email') <div class="error">{{ $message }}</div> @enderror
</div>
<div class="field">
    <label for="phone">Phone</label>
    <input type="text" id="phone" name="phone" value="{{ old('phone', $item->phone) }}">
    @error('phone') <div class="error">{{ $message }}</div> @enderror
</div>
<div class="field">
    <label for="address">Address</label>
    <textarea id="address" name="address" rows="3">{{ old('address', $item->address) }}</textarea>
    @error('address') <div class="error">{{ $message }}</div> @enderror
</div>

@extends('layouts.app')
@section('title', 'Edit Supplier')

@section('content')
<div class="card narrow">
    <h1>Edit Supplier</h1>
    <form method="POST" action="{{ route('suppliers.update', $item) }}">
        @csrf @method('PUT')
        @include('suppliers._form')
        <p class="form-actions">
            <button type="submit" class="btn">Update</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
        </p>
    </form>
</div>
@endsection

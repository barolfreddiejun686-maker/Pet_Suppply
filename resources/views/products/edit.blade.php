@extends('layouts.app')
@section('title', 'Edit Pet Supply')

@section('content')
<div class="card" style="max-width:760px">
    <h1>Edit Pet Supply</h1>
    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf @method('PUT')
        @include('products._form')
        <p class="form-actions">
            <button type="submit" class="btn">Update</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </p>
    </form>
</div>
@endsection

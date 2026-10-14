@extends('layouts.app')
@section('title', 'Edit Category')

@section('content')
<div class="card narrow">
    <h1>Edit Category</h1>
    <form method="POST" action="{{ route('categories.update', $item) }}">
        @csrf @method('PUT')
        @include('categories._form')
        <p class="form-actions">
            <button type="submit" class="btn">Update</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
        </p>
    </form>
</div>
@endsection

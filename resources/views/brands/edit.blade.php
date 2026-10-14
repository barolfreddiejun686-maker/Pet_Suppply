@extends('layouts.app')
@section('title', 'Edit Brand')

@section('content')
<div class="card narrow">
    <h1>Edit Brand</h1>
    <form method="POST" action="{{ route('brands.update', $item) }}">
        @csrf @method('PUT')
        @include('brands._form')
        <p class="form-actions">
            <button type="submit" class="btn">Update</button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
        </p>
    </form>
</div>
@endsection

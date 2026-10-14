@extends('layouts.app')
@section('title', 'Add Category')

@section('content')
<div class="card narrow">
    <h1>Add Category</h1>
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        @include('categories._form')
        <p class="form-actions">
            <button type="submit" class="btn">Save</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
        </p>
    </form>
</div>
@endsection

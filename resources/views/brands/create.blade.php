@extends('layouts.app')
@section('title', 'Add Brand')

@section('content')
<div class="card narrow">
    <h1>Add Brand</h1>
    <form method="POST" action="{{ route('brands.store') }}">
        @csrf
        @include('brands._form')
        <p class="form-actions">
            <button type="submit" class="btn">Save</button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
        </p>
    </form>
</div>
@endsection

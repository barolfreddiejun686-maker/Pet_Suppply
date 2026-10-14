@extends('layouts.app')
@section('title', 'Add Pet Supply')

@section('content')
<div class="card" style="max-width:760px">
    <h1>Add Pet Supply</h1>
    <form method="POST" action="{{ route('products.store') }}">
        @csrf 
        @include('products._form')
        <p class="form-actions">
            <button type="submit" class="btn">Save</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </p>
    </form>
</div>
@endsection

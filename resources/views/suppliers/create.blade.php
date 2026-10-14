@extends('layouts.app')
@section('title', 'Add Supplier')

@section('content')
<div class="card narrow">
    <h1>Add Supplier</h1>
    <form method="POST" action="{{ route('suppliers.store') }}">
        @csrf
        @include('suppliers._form')
        <p class="form-actions">
            <button type="submit" class="btn">Save</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
        </p>
    </form>
</div>
@endsection

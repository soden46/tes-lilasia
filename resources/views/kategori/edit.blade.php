@extends('layouts.master')

@section('title', 'Edit Kategori')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Edit Kategori</h2>
        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $category->name) }}" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Kategori</button>
        </form>
    </div>
@endsection

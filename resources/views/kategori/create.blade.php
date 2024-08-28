@extends('layouts.master')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Tambah Kategori</h2>
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama kategori"
                    required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Tambah Kategori</button>
        </form>
    </div>
@endsection

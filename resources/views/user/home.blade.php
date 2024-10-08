@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Selamat Datang, {{ Auth::user()->name }}! Anda Berhasil Masuk.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

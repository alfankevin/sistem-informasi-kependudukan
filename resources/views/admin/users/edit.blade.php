@extends('admin.layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pengguna</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('user.index') }}">Pengguna</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Ubah</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Pengguna</h2>
            <div class="card">
                <form action="{{ route('user.update', $user) }}" method="POST">
                    <div class="card-header">
                        <h4>Validasi Ubah Pengguna</h4>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $user->name }}" spellcheck="false" autocomplete="off">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ $user->email }}" spellcheck="false" autocomplete="off">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Simpan</button>
                        <a class="btn btn-secondary" href="{{ route('user.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

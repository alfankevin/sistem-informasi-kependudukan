@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Bantuan Sosial</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('sosial.index') }}">Sosial</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tambah</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Bantuan Sosial</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Bantuan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('sosial.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama_sosial">Nama Bantuan Sosial</label>
                            <input id="nama_sosial" name="nama_sosial" type="text" spellcheck="false" autocomplete="off"
                            class="form-control @error('nama_sosial') is-invalid @enderror" value="{{ old('nama_sosial') }}">
                            @error('nama_sosial')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Simpan</button>
                    <a class="btn btn-secondary" href="{{ route('sosial.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

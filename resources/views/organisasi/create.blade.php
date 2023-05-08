@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Organisasi</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('organisasi.store') }}" method="post">
                        @csrf
                        <div class="form-group ">
                            <label for="nama_ormas">Nama Organisasi</label>
                            <input id="nama_ormas" name="nama_ormas" type="text"
                            class="form-control @error('nama_ormas') is-invalid @enderror" value="{{ old('nama_ormas') }}">
                            @error('nama_ormas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gambar_ormas">Gambar Organisasi</label>
                            <input type="text" class="form-control @error('gambar_ormas') is-invalid @enderror" id="gambar_ormas"
                                name="gambar_ormas" value="{{ old('gambar_ormas') }}">
                            @error('gambar_ormas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('organisasi.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

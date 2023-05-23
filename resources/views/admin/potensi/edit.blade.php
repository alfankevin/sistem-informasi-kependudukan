@extends('admin.layouts.app')

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
            <h2 class="section-title">Edit Potensi UMKM</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Potensi UMKM</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('potensi.update', $potensi) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group ">
                            <label for="nama_umkm">Nama UMKM</label>
                            <input id="nama_umkm" name="nama_umkm" type="text"
                            class="form-control @error('nama_umkm') is-invalid @enderror"
                                value="{{ old('nama_umkm', $potensi->nama_umkm) }}">
                            @error('nama_umkm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_umkm">Alamat UMKM</label>
                            <input type="text" class="form-control @error('alamat_umkm') is-invalid @enderror" id="alamat_umkm"
                            name="alamat_umkm" value="{{ old('alamat_umkm', $potensi->alamat_umkm) }}">
                            @error('alamat_umkm')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="deskripsi_umkm">Deskripsi UMKM</label>
                            <input id="deskripsi_umkm" name="deskripsi_umkm" type="text"
                                class="form-control @error('deskripsi_umkm') is-invalid @enderror"
                                value="{{ old('deskripsi_umkm', $potensi->deskripsi_umkm) }}">
                            @error('deskripsi_umkm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="sosial_media">Sosial Media</label>
                            <input id="sosial_media" name="sosial_media" type="text"
                                class="form-control @error('sosial_media') is-invalid @enderror"
                                value={{ old('sosial_media', $potensi->sosial_media) }}>
                            @error('sosial_media')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="gambar_umkm">Gambar UMKM</label><br>
                            <img src="/assets/img/potensi/{{ $potensi->gambar_umkm }}" alt="{{ $potensi->gambar_umkm }}" height="180px" width="320px" class="mb-2">
                            <input id="gambar_umkm" name="gambar_umkm" type="file"
                                class="form-control @error('gambar_umkm') is-invalid @enderror"
                                value={{ old('gambar_umkm', $potensi->gambar_umkm) }}>
                            @error('gambar_umkm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('potensi.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

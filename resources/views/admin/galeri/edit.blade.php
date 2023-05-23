@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Galeri</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Galeri</a></div>
                <div class="breadcrumb-item"><a href="#">Management</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Galeri</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Galeri</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group ">
                            <label for="foto">Foto</label><br>
                            <img src="/assets/img/galeri/{{ $galeri->foto }}" alt="{{ $galeri->foto }}" height="180px" width="320px" class="mb-2">
                            <input id="foto" name="foto" type="file" spellcheck="false" autocomplete="off"
                            class="form-control @error('foto') is-invalid @enderror"
                                value="{{ old('foto', $galeri->foto) }}">
                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('galeri.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

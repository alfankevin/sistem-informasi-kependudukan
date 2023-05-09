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
            <h2 class="section-title">Edit Galeri</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Galeri</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group ">
                            <label for="foto">Foto</label>
                            <input id="foto" name="foto" type="file"
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

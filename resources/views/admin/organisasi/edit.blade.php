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
            <h2 class="section-title">Edit Organisasi</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Organisasi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('organisasi.update', $organisasi) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group ">
                            <label for="nama_organisasi">Nama Organisasi</label>
                            <input id="nama_organisasi" name="nama_organisasi" type="text" spellcheck="false" autocomplete="off"
                            class="form-control @error('nama_organisasi') is-invalid @enderror"
                                value="{{ old('nama_organisasi', $organisasi->nama_organisasi) }}">
                            @error('nama_organisasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gambar_organisasi">Gambar Organisasi</label><br>
                            <img src="/assets/img/organisasi/{{ $organisasi->gambar_organisasi }}" alt="{{ $organisasi->gambar_organisasi }}" height="180px" width="320px" class="mb-2">
                            <input type="file" class="form-control @error('gambar_organisasi') is-invalid @enderror" id="gambar_organisasi"
                            name="gambar_organisasi" value="{{ old('gambar_organisasi', $organisasi->gambar_organisasi) }}" spellcheck="false" autocomplete="off">
                            @error('gambar_organisasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="deskripsi_organisasi">Deskripsi Organisasi</label>
                            <input id="deskripsi_organisasi" name="deskripsi_organisasi" type="text" spellcheck="false" autocomplete="off"
                            class="form-control @error('deskripsi_organisasi') is-invalid @enderror"
                                value="{{ old('deskripsi_organisasi', $organisasi->deskripsi_organisasi) }}">
                            @error('deskripsi_organisasi')
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

@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kartu Keluarga</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('keluarga.index') }}">Keluarga</a></div>
                <div class="breadcrumb-item"><a href="#">Management</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Kartu Keluarga</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Kartu</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('keluarga.update', $penduduk) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="no_kk">No. KK</label>
                            <input id="no_kk" name="no_kk" type="text" spellcheck="false" autocomplete="off"
                            class="form-control @error('no_kk') is-invalid @enderror"
                            value="{{ old('no_kk', $penduduk->no_kk) }}">
                            @error('no_kk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Kepala Keluarga</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ old('nama', $penduduk->nama) }}" spellcheck="false" autocomplete="off">
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input id="alamat" name="alamat" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('alamat') is-invalid @enderror"
                                value="{{ old('alamat', $penduduk->alamat) }}">
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>RT</label>
                            <select class="form-control select2 @error('rt') is-invalid @enderror" name="rt">
                                <option value=""></option>
                                <option value="1" @if (old('rt', $penduduk->rt) == "1") {{ 'selected' }} @endif>001</option>
                                <option value="2" @if (old('rt', $penduduk->rt) == "2") {{ 'selected' }} @endif>002</option>
                                <option value="3" @if (old('rt', $penduduk->rt) == "3") {{ 'selected' }} @endif>003</option>
                                <option value="4" @if (old('rt', $penduduk->rt) == "4") {{ 'selected' }} @endif>004</option>
                                <option value="5" @if (old('rt', $penduduk->rt) == "5") {{ 'selected' }} @endif>005</option>
                            </select>
                            @error('rt')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>RW</label>
                            <select class="form-control select2 @error('rw') is-invalid @enderror" name="rw">
                                <option value="">005</option>
                            </select>
                            @error('rw')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('keluarga.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kartu Keluarga</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('keluarga.index') }}">Keluarga</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tambah</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Kartu Keluarga</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Kartu</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('keluarga.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Kepala Keluarga</label>
                            <select class="form-control select2 @error('penduduk') is-invalid @enderror" name="penduduk">
                                <option value=""></option>
                                @foreach ($data as $item)
                                    <option value="{{ $item->id }}">{{ $item->nik }} - {{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('penduduk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Simpan</button>
                    <a class="btn btn-secondary" href="{{ route('keluarga.index') }}">Batal</a>
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
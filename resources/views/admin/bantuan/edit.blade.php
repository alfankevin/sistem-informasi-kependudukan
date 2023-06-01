@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Bantuan Sosial</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('bantuan.index') }}">Bantuan</a></div>
                <div class="breadcrumb-item"><a href="#">Management</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Bantuan Sosial</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Penerima</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('bantuan.update', $penduduk) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="nama">Penerima</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ old('nama', $penduduk->nama) }}" spellcheck="false" autocomplete="off">
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bantuan Sosial</label>
                            <select class="form-control select2" name="sosial_id">
                                <option value="{{ old('sosial_id', $penduduk->sosial_id) }}">{{ $nama_sosial[0]->nama_sosial }}</option>
                                @foreach ($sosial as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_sosial }}</option>
                                @endforeach
                            </select>
                            @error('sosial_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('bantuan.index') }}">Cancel</a>
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
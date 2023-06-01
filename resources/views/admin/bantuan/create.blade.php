@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Bantuan Sosial</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('bantuan.index') }}">Bantuan</a></div>
                <div class="breadcrumb-item"><a href="#">Management</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Bantuan Sosial</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Penerima</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('bantuan.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Penerima</label>
                            <select class="form-control select2 @error('penduduk') is-invalid @enderror" name="penduduk">
                                <option value=""></option>
                                @foreach ($penduduk as $item)
                                    <option value="{{ $item->id }}">{{ $item->nik }} - {{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('penduduk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bantuan Sosial</label>
                            <select class="form-control select2" name="sosial">
                                <option value=""></option>
                                @foreach ($sosial as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_sosial }}</option>
                                @endforeach
                            </select>
                            @error('sosial')
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
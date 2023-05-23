@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kependudukan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('penduduk.index') }}">Penduduk</a></div>
                <div class="breadcrumb-item"><a href="#">Management</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Kependudukan</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Penduduk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('penduduk.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="no_kk">No. KK</label>
                            <input id="no_kk" name="no_kk" type="text" spellcheck="false" autocomplete="off"
                            class="form-control @error('no_kk') is-invalid @enderror" value="{{ old('no_kk') }}">
                            @error('no_kk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input id="nik" name="nik" type="text" spellcheck="false" autocomplete="off"
                            class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}">
                            @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ old('nama') }} " spellcheck="false" autocomplete="off">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input id="tempat_lahir" name="tempat_lahir" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input id="tanggal_lahir" name="tanggal_lahir" type="date" spellcheck="false" autocomplete="off"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror" value={{ old('tanggal_lahir') }}>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <input id="jenis_kelamin" name="jenis_kelamin" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                value="{{ old('jenis_kelamin') }}">
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="golongan_darah">Golongan Darah</label>
                            <input id="golongan_darah" name="golongan_darah" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('golongan_darah') is-invalid @enderror" value="{{ old('golongan_darah') }}">
                            @error('golongan_darah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="agama">Agama</label>
                            <input id="agama" name="agama" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('agama') is-invalid @enderror" value="{{ old('agama') }}">
                            @error('agama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status_perkawinan">Status Perkawinan</label>
                            <input id="status_perkawinan" name="status_perkawinan" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('status_perkawinan') is-invalid @enderror" value="{{ old('status_perkawinan') }}">
                            @error('status_perkawinan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input id="pekerjaan" name="pekerjaan" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan') }}">
                            @error('pekerjaan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input id="alamat" name="alamat" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}">
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input id="keterangan" name="keterangan" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan') }}">
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('penduduk.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kependudukan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('penduduk.index') }}">Penduduk</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tambah</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Kependudukan</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Penduduk</h4>
                    <div class="card-header-action">
                        <a class="btn btn-primary btn-color-blue text-white" data-toggle="modal"
                            data-target="#importModal">
                            <i class="fa fa-download" aria-hidden="true"></i> Unggah Kartu Keluarga
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('penduduk.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="import_kk" value="0">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="no_kk">No. KK</label>
                                    <input id="no_kk" name="no_kk" type="text" spellcheck="false" autocomplete="off"
                                    class="form-control @error('no_kk') is-invalid @enderror" value="{{ old('no_kk') }}">
                                    @error('no_kk')
                                    <div class="invalid-feedback">
                                        {rormessage }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input id="nik" name="penduduk[0][nik]" type="text" spellcheck="false" autocomplete="off"
                                    class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}">
                                    @error('nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="penduduk[0][nama]" value="{{ old('nama') }} " spellcheck="false" autocomplete="off">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input id="tempat_lahir" name="penduduk[0][tempat_lahir]" type="text" spellcheck="false" autocomplete="off"
                                        class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input id="tanggal_lahir" name="penduduk[0][tanggal_lahir]" type="date" spellcheck="false" autocomplete="off"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror" value={{ old('tanggal_lahir') }}>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" name="penduduk[0][jenis_kelamin]">
                                        <option value=""></option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Golongan Darah</label>
                                    <select class="form-control select2 @error('golongan_darah') is-invalid @enderror" name="penduduk[0][golongan_darah]">
                                        <option value=""></option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                        <option value="-">-</option>
                                    </select>
                                    @error('golongan_darah')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <select class="form-control select2 @error('agama') is-invalid @enderror" name="penduduk[0][agama]">
                                        <option value=""></option>
                                        <option value="Islam">Islam</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Protestan">Protestan</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                    @error('agama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Status Perkawinan</label>
                                    <select class="form-control select2 @error('status_perkawinan') is-invalid @enderror" name="penduduk[0][status_perkawinan]">
                                        <option value=""></option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Kawin Tercatat">Kawin Tercatat</option>
                                        <option value="Kawin Belum Tercatat">Kawin Belum Tercatat</option>
                                        <option value="Cerai">Cerai</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Tercatat">Cerai Tercatat</option>
                                    </select>
                                    @error('status_perkawinan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Status Keluarga</label>
                                    <select class="form-control select2 @error('status_keluarga') is-invalid @enderror" name="penduduk[0][status_keluarga]">
                                        <option value=""></option>
                                        <option value="1">Kepala Keluarga</option>
                                        <option value="2">Istri</option>
                                        <option value="3">Anak</option>
                                        <option value="0">-</option>
                                    </select>
                                    @error('status_keluarga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="pekerjaan">Jenis Pekerjaan</label>
                                    <input id="pekerjaan" name="penduduk[0][pekerjaan]" type="text" spellcheck="false" autocomplete="off"
                                        class="form-control @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan') }}">
                                    @error('pekerjaan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <select class="form-control select2 @error('keterangan') is-invalid @enderror" name="penduduk[0][keterangan]">
                                        <option value=""></option>
                                        <option value="Hidup">Hidup</option>
                                        <option value="Meninggal">Meninggal</option>
                                    </select>
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>Bantuan Sosial</label>
                            <select class="form-control select2" name="penduduk[0][id_sosial]">
                                <option value="1"></option>
                            </select>
                            @error('id_sosial')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Simpan</button>
                        <a class="btn btn-secondary" href="{{ route('penduduk.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Kartu Keluarga</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('penduduk.import_kk') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
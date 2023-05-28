@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kependudukan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('penduduk.index') }}">Penduduk</a></div>
                <div class="breadcrumb-item"><a href="#">Management</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Kependudukan</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Penduduk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('penduduk.update', $penduduk) }}" method="POST">
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
                            <label for="nik">NIK</label>
                            <input id="nik" name="nik" type="text" spellcheck="false" autocomplete="off"
                            class="form-control @error('nik') is-invalid @enderror"
                            value="{{ old('nik', $penduduk->nik) }}">
                            @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kepala Keluarga</label>
                            <select class="form-control select2 @error('kepala_keluarga') is-invalid @enderror" name="kepala_keluarga">
                                <option value=""></option>
                                <option value="1" @if (old('kepala_keluarga', $penduduk->kepala_keluarga) == "1") {{ 'selected' }} @endif>Ya</option>
                                <option value="0" @if (old('kepala_keluarga', $penduduk->kepala_keluarga) == "0") {{ 'selected' }} @endif>Tidak</option>
                            </select>
                            @error('kepala_keluarga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ old('nama', $penduduk->nama) }}" spellcheck="false" autocomplete="off">
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input id="tempat_lahir" name="tempat_lahir" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('tempat_lahir') is-invalid @enderror"
                                value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input id="tanggal_lahir" name="tanggal_lahir" type="date" spellcheck="false" autocomplete="off"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir) }}">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                                <option value=""></option>
                                <option value="L" @if (old('jenis_kelamin', $penduduk->jenis_kelamin) == "L") {{ 'selected' }} @endif>Laki-laki</option>
                                <option value="P" @if (old('jenis_kelamin', $penduduk->jenis_kelamin) == "P") {{ 'selected' }} @endif>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Golongan Darah</label>
                            <select class="form-control select2 @error('golongan_darah') is-invalid @enderror" name="golongan_darah">
                                <option value=""></option>
                                <option value="-" @if (old('golongan_darah', $penduduk->golongan_darah) == "-") {{ 'selected' }} @endif>-</option>
                                <option value="A" @if (old('golongan_darah', $penduduk->golongan_darah) == "A") {{ 'selected' }} @endif>A</option>
                                <option value="B" @if (old('golongan_darah', $penduduk->golongan_darah) == "B") {{ 'selected' }} @endif>B</option>
                                <option value="AB" @if (old('golongan_darah', $penduduk->golongan_darah) == "AB") {{ 'selected' }} @endif>AB</option>
                                <option value="O" @if (old('golongan_darah', $penduduk->golongan_darah) == "O") {{ 'selected' }} @endif>O</option>
                            </select>
                            @error('golongan_darah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Agama</label>
                            <select class="form-control select2 @error('agama') is-invalid @enderror" name="agama">
                                <option value=""></option>
                                <option value="Islam" @if (old('agama', $penduduk->agama) == "Islam") {{ 'selected' }} @endif>Islam</option>
                                <option value="Katolik" @if (old('agama', $penduduk->agama) == "Katolik") {{ 'selected' }} @endif>Katolik</option>
                                <option value="Protestan" @if (old('agama', $penduduk->agama) == "Protestan") {{ 'selected' }} @endif>Protestan</option>
                                <option value="Hindu" @if (old('agama', $penduduk->agama) == "Hindu") {{ 'selected' }} @endif>Hindu</option>
                                <option value="Budha" @if (old('agama', $penduduk->agama) == "Budha") {{ 'selected' }} @endif>Budha</option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Status Perkawinan</label>
                            <select class="form-control select2 @error('status_perkawinan') is-invalid @enderror" name="status_perkawinan">
                                <option value=""></option>
                                <option value="Kawin" @if (old('status_perkawinan', $penduduk->status_perkawinan) == "Kawin") {{ 'selected' }} @endif>Kawin</option>
                                <option value="Belum Kawin" @if (old('status_perkawinan', $penduduk->status_perkawinan) == "Belum Kawin") {{ 'selected' }} @endif>Belum Kawin</option>
                                <option value="Kawin Tercatat" @if (old('status_perkawinan', $penduduk->status_perkawinan) == "Kawin Tercatat") {{ 'selected' }} @endif>Kawin Tercatat</option>
                                <option value="Kawin Belum Tercatat" @if (old('status_perkawinan', $penduduk->status_perkawinan) == "Kawin Belum Tercatat") {{ 'selected' }} @endif>Kawin Belum Tercatat</option>
                                <option value="Cerai Hidup Tercatat" @if (old('status_perkawinan', $penduduk->status_perkawinan) == "Cerai Hidup Tercatat") {{ 'selected' }} @endif>Cerai Hidup Tercatat</option>
                                <option value="Cerai Mati" @if (old('status_perkawinan', $penduduk->status_perkawinan) == "Cerai Mati") {{ 'selected' }} @endif>Cerai Mati</option>
                            </select>
                            @error('status_perkawinan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input id="pekerjaan" name="pekerjaan" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('pekerjaan') is-invalid @enderror"
                                value="{{ old('pekerjaan', $penduduk->pekerjaan) }}">
                            @error('pekerjaan')
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
                                <option value="1" @if (old('rt', $penduduk->rt) == "01") {{ 'selected' }} @endif>01</option>
                                <option value="2" @if (old('rt', $penduduk->rt) == "02") {{ 'selected' }} @endif>02</option>
                                <option value="3" @if (old('rt', $penduduk->rt) == "03") {{ 'selected' }} @endif>03</option>
                                <option value="4" @if (old('rt', $penduduk->rt) == "04") {{ 'selected' }} @endif>04</option>
                                <option value="5" @if (old('rt', $penduduk->rt) == "05") {{ 'selected' }} @endif>05</option>
                            </select>
                            @error('rt')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <select class="form-control select2 @error('keterangan') is-invalid @enderror" name="keterangan">
                                <option value=""></option>
                                <option value="Hidup" @if (old('keterangan', $penduduk->keterangan) == "Hidup") {{ 'selected' }} @endif>Hidup</option>
                                <option value="Meninggal" @if (old('keterangan', $penduduk->keterangan) == "Meninggal") {{ 'selected' }} @endif>Meninggal</option>
                            </select>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bantuan Sosial</label>
                            <select class="form-control select2" name="sosial_id">
                                <option value="{{ old('sosial_id', $penduduk->sosial_id) }}">{{ $penduduk->sosial_id }}</option>
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
                    <a class="btn btn-secondary" href="{{ route('penduduk.index') }}">Cancel</a>
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
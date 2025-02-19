@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kartu Keluarga</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('keluarga.index') }}">Keluarga</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Ubah</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Kartu Keluarga</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Ubah Kartu Keluarga</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('keluarga.update', $kartu_keluarga) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="no_kk">No. KK</label>
                                    <input id="no_kk" name="no_kk" type="text" spellcheck="false" autocomplete="off"
                                    class="form-control @error('no_kk') is-invalid @enderror"
                                    value="{{ old('no_kk', default: $kartu_keluarga->no_kk) }}">
                                    @error('no_kk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="kelurahan">Desa/Kelurahan</label>
                                    <input id="kelurahan" name="kelurahan" type="text" spellcheck="false" autocomplete="off"
                                        class="form-control @error('kelurahan') is-invalid @enderror"
                                        value="{{ old('kelurahan', $kartu_keluarga->kelurahan) }}">
                                    @error('kelurahan')
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
                                    <label for="alamat">Alamat</label>
                                    <input id="alamat" name="alamat" type="text" spellcheck="false" autocomplete="off"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        value="{{ old('alamat', $kartu_keluarga->alamat) }}">
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input id="kecamatan" name="kecamatan" type="text" spellcheck="false" autocomplete="off"
                                        class="form-control @error('kecamatan') is-invalid @enderror"
                                        value="{{ old('kecamatan', $kartu_keluarga->kecamatan) }}">
                                    @error('kecamatan')
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
                                    <label for="rt_rw">RT/RW</label>
                                    <input id="rt_rw" name="rt_rw" type="text" spellcheck="false" autocomplete="off"
                                        class="form-control @error('rt_rw') is-invalid @enderror"
                                        value="{{ old('rt', $kartu_keluarga->rt) }}/{{ old('rw', $kartu_keluarga->rw) }}">
                                    @error('rt_rw')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="kabupaten">Kabupaten/Kota</label>
                                    <input id="kabupaten" name="kabupaten" type="text" spellcheck="false" autocomplete="off"
                                        class="form-control @error('kabupaten') is-invalid @enderror"
                                        value="{{ old('kabupaten', $kartu_keluarga->kabupaten) }}">
                                    @error('kabupaten')
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
                                    <label for="kode_pos">Kode Pos</label>
                                    <input id="kode_pos" name="kode_pos" type="text" spellcheck="false" autocomplete="off"
                                        class="form-control @error('kode_pos') is-invalid @enderror"
                                        value="{{ old('kode_pos', $kartu_keluarga->kode_pos) }}">
                                    @error('kode_pos')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="provinsi">Provinsi</label>
                                    <input id="provinsi" name="provinsi" type="text" spellcheck="false" autocomplete="off"
                                        class="form-control @error('provinsi') is-invalid @enderror"
                                        value="{{ old('provinsi', $kartu_keluarga->provinsi) }}">
                                    @error('provinsi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
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
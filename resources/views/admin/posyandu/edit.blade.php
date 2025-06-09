@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Posyandu</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('penduduk.index') }}">Posyandu</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tambah</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Posyandu</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Ubah Batita</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('posyandu.update', $posyandu->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label for="nik">NIK</label>
                                    <input id="nik" name="nik" type="text" spellcheck="false"
                                        autocomplete="off" class="form-control @error('nik') is-invalid @enderror"
                                        value="{{ $posyandu->penduduk->nik }}" readonly>
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label for="nama">Nama</label>
                                    <select id="nama" name="nama" disabled
                                        class="form-control @error('nama') is-invalid @enderror">
                                        @if ($posyandu)
                                            <option value="{{ $posyandu->penduduk->nama }}" selected>{{ $posyandu->penduduk->nama }}
                                            </option>
                                        @endif
                                    </select>
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <label for="usia">Usia (bulan)</label>
                                    <input id="usia" name="usia" type="number" spellcheck="false"
                                        autocomplete="off" class="form-control @error('usia') is-invalid @enderror"
                                        value="{{ $posyandu->usia }}">
                                    @error('usia')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label for="berat_badan">Berat Badan (kg)</label>
                                    <input id="berat_badan" name="berat_badan" type="number" step="any"
                                        spellcheck="false" autocomplete="off"
                                        class="form-control @error('berat_badan') is-invalid @enderror"
                                        value="{{ $posyandu->berat_badan }}">
                                    @error('berat_badan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label for="tinggi_badan">Panjang Badan (cm)</label>
                                    <input id="tinggi_badan" name="tinggi_badan" type="number" step="any"
                                        spellcheck="false" autocomplete="off"
                                        class="form-control @error('tinggi_badan') is-invalid @enderror"
                                        value="{{ $posyandu->tinggi_badan }}">
                                    @error('tinggi_badan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label for="lingkar_lengan_atas">Lingkar Lengan Atas (cm)</label>
                                    <input id="lingkar_lengan_atas" name="lingkar_lengan_atas" type="number" step="any"
                                        spellcheck="false" autocomplete="off"
                                        class="form-control @error('lingkar_lengan_atas') is-invalid @enderror"
                                        value="{{ $posyandu->lingkar_lengan_atas }}">
                                    @error('lingkar_lengan_atas')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">


                                <div class="col-12 col-md-3">
                                    <label for="lingkar_lengan_bawah">Lingkar Lengan Bawah (cm)</label>
                                    <input id="lingkar_lengan_bawah" name="lingkar_lengan_bawah" type="number"
                                        step="any" spellcheck="false" autocomplete="off"
                                        class="form-control @error('lingkar_lengan_bawah') is-invalid @enderror"
                                        value="{{ $posyandu->lingkar_lengan_bawah }}">
                                    @error('lingkar_lengan_bawah')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label for="lingkar_dada">Lingkar Dada (cm)</label>
                                    <input id="lingkar_dada" name="lingkar_dada" type="number" step="any"
                                        spellcheck="false" autocomplete="off"
                                        class="form-control @error('lingkar_dada') is-invalid @enderror"
                                        value="{{ $posyandu->lingkar_dada }}">
                                    @error('lingkar_dada')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label for="lingkar_perut">Lingkar Perut (cm)</label>
                                    <input id="lingkar_perut" name="lingkar_perut" type="number" step="any"
                                        spellcheck="false" autocomplete="off"
                                        class="form-control @error('lingkar_perut') is-invalid @enderror"
                                        value="{{ $posyandu->lingkar_perut }}">
                                    @error('lingkar_perut')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label for="lingkar_kepala">Lingkar Kepala (cm)</label>
                                    <input id="lingkar_kepala" name="lingkar_kepala" type="number" step="any"
                                        spellcheck="false" autocomplete="off"
                                        class="form-control @error('lingkar_kepala') is-invalid @enderror"
                                        value="{{ $posyandu->lingkar_kepala }}">
                                    @error('lingkar_kepala')
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
                    <a class="btn btn-secondary" href="{{ route('posyandu.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
    <script>
        $(document).ready(function() {
            const penduduk = {!! json_encode($posyandu->penduduk) !!};
            $('#usia').val(hitungUsiaDalamBulan(penduduk.tanggal_lahir));

            function hitungUsiaDalamBulan(tanggalLahir) {
                const lahir = new Date(tanggalLahir);
                const hariIni = new Date();

                let tahun = hariIni.getFullYear() - lahir.getFullYear();
                let bulan = hariIni.getMonth() - lahir.getMonth();
                let totalBulan = tahun * 12 + bulan;

                // Kalau hari ini belum lewat tanggal lahir di bulan ini, kurangi 1
                if (hariIni.getDate() < lahir.getDate()) {
                    totalBulan--;
                }

                return totalBulan;
            }
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush

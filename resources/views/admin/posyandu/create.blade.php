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
                    <h4>Validasi Tambah Batita</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('posyandu.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label for="nik">NIK</label>
                                    <input id="nik" name="nik" type="text" spellcheck="false"
                                        autocomplete="off" class="form-control @error('nik') is-invalid @enderror"
                                        value="{{ old('nik') }}" readonly>
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
                                    <select id="nama" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror">
                                        @if (old('nama'))
                                            <option value="{{ old('nama') }}" selected>{{ old('nama') }}</option>
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
                                        value="{{ old('usia') }}" readonly>
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
                                        value="{{ old('berat_badan') }}" required>
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
                                        value="{{ old('tinggi_badan') }}" required>
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
                                        value="{{ old('lingkar_lengan_atas') }}" required>
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
                                        value="{{ old('lingkar_lengan_bawah') }}" required>
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
                                        value="{{ old('lingkar_dada') }}" required>
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
                                        value="{{ old('lingkar_perut') }}" required>
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
                                        value="{{ old('lingkar_kepala') }}" required>
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
    <script src="/assets/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#nama').select2({
                placeholder: "Cari nama batita...",
                allowClear: false,
                ajax: {
                    url: '{{ route('posyandu.create') }}', // ganti dengan route kamu
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // kata yang diketik
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(item => ({
                                id: item.id,
                                text: item.nama
                            }))
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#nama').on('change', () => {
                const penduduk = {!! json_encode($penduduk) !!}
                const id_penduduk = $(this).find('option:selected').val();

                const find_penduduk = penduduk.find((item) => item.id == id_penduduk);

                $("#nik").val(find_penduduk.nik);
                $('#usia').val(hitungUsiaDalamBulan(find_penduduk.tanggal_lahir))
            });

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

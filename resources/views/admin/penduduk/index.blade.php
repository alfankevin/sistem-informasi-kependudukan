@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Data Kependudukan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Penduduk</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tabel</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Kependudukan</h2>
            <div class="row">
                <div class="col-12">
                    @include('admin.layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Penduduk</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('penduduk.create') }}">Tambah
                                    Penduduk</a>
                                <a class="btn btn-primary btn-color-blue text-white" data-toggle="modal"
                                    data-target="#importModal">
                                    <i class="fa fa-download" aria-hidden="true"></i> Import Data
                                </a>
                                <a class="btn btn-primary btn-color-blue" href="{{ route('penduduk.export') }}">
                                    <i class="fa fa-upload" aria-hidden="true"></i> Export Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="penduduk" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th class="text-nowrap">Tempat Lahir</th>
                                            <th width=65px>Tgl Lahir</th>
                                            <th>JK</th>
                                            <th>Gol.</th>
                                            <th>Agama</th>
                                            <th>Pekerjaan</th>
                                            <th>Alamat</th>
                                            <th>RT</th>
                                            <th>Ket.</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="show-data">
                                        {{-- @foreach ($penduduk as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="openKTP" data-toggle="modal" data-target="#ktp"
                                                    data-nik="{{ $item->nik }}"
                                                    data-nama="{{ $item->nama }}"
                                                    data-tempat_lahir="{{ $item->tempat_lahir }}"
                                                    data-tanggal_lahir="{{ $item->tanggal_lahir }}"
                                                    data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                                                    data-golongan_darah="{{ $item->golongan_darah }}"
                                                    data-alamat="{{ $item->alamat }}"
                                                    data-rt="{{ $item->rt }}"
                                                    data-agama="{{ $item->agama }}"
                                                    data-status_perkawinan="{{ $item->status_perkawinan }}"
                                                    data-pekerjaan="{{ $item->pekerjaan }}"
                                                    data-keterangan="{{ $item->keterangan }}"
                                                    data-sosial="{{ $item->nama_sosial }}">
                                                    {{ $item->nama }}
                                                </td>
                                                <td>{{ $item->tempat_lahir }}</td>
                                                <td class="text-nowrap">{{ $item->tanggal_lahir }}</td>
                                                <td>{{ $item->jenis_kelamin }}</td>
                                                <td>{{ $item->golongan_darah }}</td>
                                                <td>{{ $item->agama }}</td>
                                                <td>{{ $item->pekerjaan }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>00{{ $item->rt }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-sm btn-success btn-icon d-flex align-items-center justify-content-center data-link openKK" style="height: 30px; width: 30px"
                                                            data-toggle="modal"
                                                            data-target="#kk"
                                                            data-value="{{ $item->no_kk }}"
                                                            data-no_kk="{{ $item->no_kk }}"
                                                            data-nama="{{ $item->nama }}"
                                                            data-alamat="{{ $item->alamat }}"
                                                            data-rt="{{ $item->rt }}">
                                                            <i class="fas fa-user"></i>
                                                        </button>
                                                        <a href="{{ route('penduduk.edit', $item->id) }}" class="btn btn-sm btn-info btn-icon ml-2 mr-2 d-flex align-items-center justify-content-center" style="height: 30px; width: 30px">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        <form action="{{ route('penduduk.destroy', $item->id) }}"
                                                            method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete d-flex align-items-center justify-content-center" style="height: 30px; width: 30px">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- KK --}}
    <div id="kk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="height: 100vh; width: 100vw; transform: scale(1)">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="detailKK">
                    <div class="headerKK">
                        <h4>KARTU KELUARGA</h4>
                        <h5>No.<span id="no_kk"></span></h5>
                    </div>
                    <div class="bodyKK">
                        <div class="row">
                            <div class="col col-lg-7 col-sm-12">
                                <table>
                                    <tr>
                                        <td>Nama Anggota Keluarga</td>
                                        <td>:</td>
                                        <td><b><span id="nama"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><span id="alamat"></span></td>
                                    </tr>
                                    <tr>
                                        <td>RT/RW</td>
                                        <td>:</td>
                                        <td><span id="rt"></span>/<span id="rw"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Kode Pos</td>
                                        <td>:</td>
                                        <td><span id="kode_pos"></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col col-lg-5 col-sm-12">
                                <table>
                                    <tr>
                                        <td>Desa/Kelurahan</td>
                                        <td>:</td>
                                        <td><span id="kelurahan"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>:</td>
                                        <td><span id="kecamatan"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Kabupaten/Kota</td>
                                        <td>:</td>
                                        <td><span id="kabupaten"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Provinsi</td>
                                        <td>:</td>
                                        <td><span id="provinsi"></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Lengkap</th>
                                                <th>NIK</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Tempat Lahir</th>
                                                <th>Tanggal Lahir</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail1"></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Agama</th>
                                                <th>Jenis Pekerjaan</th>
                                                <th>Status Perkawinan</th>
                                                <th>Status Keluarga</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail2"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Import --}}
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('penduduk.import') }}" method="post" enctype="multipart/form-data">
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
    <script>
        $(document).ready(function() {
            $('#penduduk').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('penduduk.index') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "pageLength": 25,
                "columns": [{
                        "data": "id",
                        "orderable": true,
                        "render": function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "nama",
                        "orderable": true,
                    },
                    {
                        "data": "tempat_lahir",
                        "orderable": true,
                    },
                    {
                        "data": "tanggal_lahir",
                        "orderable": true,
                    },
                    {
                        "data": "jenis_kelamin",
                        "orderable": true,
                    },
                    {
                        "data": "golongan_darah",
                        "orderable": true,
                    },
                    {
                        "data": "agama",
                        "orderable": true,
                    },
                    {
                        "data": "pekerjaan",
                        "orderable": true,
                    },
                    {
                        "data": "alamat",
                        "orderable": true,
                    },
                    {
                        "data": "rt",
                        "orderable": true,
                    },
                    {
                        "data": "keterangan",
                        "orderable": true,
                    },
                    {
                        "data": "action",
                        "orderable": false,
                        "searchable": false
                    }
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.import').click(function(event) {
                event.stopPropagation();
                $(".show-import").slideToggle("fast");
                $(".show-search").hide();
            });
            $('.search').click(function(event) {
                event.stopPropagation();
                $(".show-search").slideToggle("fast");
                $(".show-import").hide();
            });
            $('#file-upload').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#file-upload')[0].files[0].name;
                $(this).prev('label').text(file);
            });
        });

        $(document).on("click", ".openKK", function() {
            var no_kk = $(this).data('no_kk');
            var nama = $(this).data('nama');
            var alamat = $(this).data('alamat');
            var rt = $(this).data('rt');
            var rw = $(this).data('rw');
            var kode_pos = $(this).data('kode_pos');
            var kelurahan = $(this).data('kelurahan');
            var kecamatan = $(this).data('kecamatan');
            var kabupaten = $(this).data('kabupaten');
            var provinsi = $(this).data('provinsi');

            $(".modal-content #no_kk").text(no_kk);
            $(".modal-content #nama").text(nama);
            $(".modal-content #alamat").text(alamat ? alamat : '-');
            $(".modal-content #rt").text(rt ? rt.toString().padStart(3, '0') : '-');
            $(".modal-content #rw").text(rw ? rw.toString().padStart(3, '0') : '-');
            $(".modal-content #kode_pos").text(kode_pos ? kode_pos : '-');
            $(".modal-content #kelurahan").text(kelurahan ? kelurahan : '-');
            $(".modal-content #kecamatan").text(kecamatan ? kecamatan : '-');
            $(".modal-content #kabupaten").text(kabupaten ? kabupaten : '-');
            $(".modal-content #provinsi").text(provinsi ? provinsi : '-');
        });

        $(document).on("click", ".data-link", function() {
            var no_kk = $(this).data('value');

            $.ajax({
                url: '{{ route('penduduk.detail') }}',
                method: 'POST',
                data: {
                    no_kk: no_kk
                },
                success: function(response) {
                    var detailElement1 = $('#detail1');
                    var detailElement2 = $('#detail2');

                    detailElement1.empty();
                    detailElement2.empty();

                    for (var i = 0; i < response.length; i++) {
                        var nama = response[i].nama;
                        var nik = response[i].nik;
                        var jenis_kelamin = response[i].jenis_kelamin;
                        var tempat_lahir = response[i].tempat_lahir;
                        var tanggal_lahir = response[i].tanggal_lahir;
                        var agama = response[i].agama;
                        var pekerjaan = response[i].pekerjaan;
                        var status_perkawinan = response[i].status_perkawinan;
                        var status_keluarga = response[i].status_keluarga;
                        var keterangan = response[i].keterangan;

                        detailElement1.append('<tr><td>' + (i + 1) + '</td><td>' + nama + '</td><td>' +
                            nik + '</td><td>' + jenis_kelamin + '</td><td>' + tempat_lahir +
                            '</td><td>' + tanggal_lahir + '</td></tr>');
                        detailElement2.append('<tr><td>' + (i + 1) + '</td><td>' + agama + '</td><td>' +
                            pekerjaan + '</td><td>' + status_perkawinan + '</td><td>' +
                            status_keluarga + '</td><td>' + keterangan + '</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    </script>
@endpush

@push('customStyle')
@endpush

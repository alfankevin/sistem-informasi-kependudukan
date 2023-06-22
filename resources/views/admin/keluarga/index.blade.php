@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Data Kartu Keluarga</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Keluarga</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tabel</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Kartu Keluarga</h2>

            <div class="row">
                <div class="col-12">
                    @include('admin.layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Kartu</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('keluarga.create') }}">Tambah Kartu</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="keluarga">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>No. KK</th>
                                            <th>Kepala Keluarga</th>
                                            <th>Alamat</th>
                                            <th>RT</th>
                                            <th>RW</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}
                                                </td>
                                                <td>{{ $item->no_kk }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>00{{ $item->rt }}</td>
                                                <td>005</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-sm btn-success btn-icon d-flex align-items-center justify-content-center data-link openKK" style="height: 30px; width: 30px"
                                                            data-no_kk="{{ $item->no_kk }}"
                                                            data-nama="{{ $item->nama }}"
                                                            data-alamat="{{ $item->alamat }}"
                                                            data-rt="{{ $item->rt }}"
                                                            data-value="{{ $item->no_kk }}"
                                                            data-toggle="modal"
                                                            data-target="#kk">
                                                            <i class="fas fa-user"></i>
                                                        </button>
                                                        <a href="{{ route('keluarga.edit', $item->id) }}"
                                                            class="btn btn-sm btn-info btn-icon ml-2 mr-2 d-flex align-items-center justify-content-center" style="height: 30px; width: 30px">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        <form action="{{ route('keluarga.destroy', $item->id) }}"
                                                            method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete d-flex align-items-center justify-content-center" style="height: 30px; width: 30px">
                                                            <i class="fas fa-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="kk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                        <td>: <b><span id="nama"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>: <span id="alamat"></span></td>
                                    </tr>
                                    <tr>
                                        <td>RT/RW</td>
                                        <td>: 00<span id="rt"></span>/005</td>
                                    </tr>
                                    <tr>
                                        <td>Desa/Kelurahan</td>
                                        <td>: TANJUNGREJO</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col col-lg-5 col-sm-12">
                                <table>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>: SUKUN</td>
                                    </tr>
                                    <tr>
                                        <td>Kabupaten/Kota</td>
                                        <td>: MALANG</td>
                                    </tr>
                                    <tr>
                                        <td>Kode Pos</td>
                                        <td>: 65147</td>
                                    </tr>
                                    <tr>
                                        <td>Provinsi</td>
                                        <td>: JAWA TIMUR</td>
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
                                                <th>Pendidikan/Pekerjaan</th>
                                                <th>Status Perkawinan</th>
                                                <th>Status Keluarga</th>
                                                <th>Kewarganegaraan</th>
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
@endsection
@push('customScript')
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
            //ganti label berdasarkan nama file
            $('#file-upload').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#file-upload')[0].files[0].name;
                $(this).prev('label').text(file);
            });
        });

        $(document).on("click", ".openKK", function () {
            var no_kk = $(this).data('no_kk');
            var nama = $(this).data('nama');
            var alamat = $(this).data('alamat');
            var rt = $(this).data('rt');

            $(".modal-content #no_kk").text(no_kk);
            $(".modal-content #nama").text(nama);
            $(".modal-content #alamat").text(alamat);
            $(".modal-content #rt").text(rt);
        });

        $(document).on("click", ".data-link", function() {
            var no_kk = $(this).data('value');
            
            $.ajax({
            url: '/penduduk',
            method: 'POST',
            data: { no_kk: no_kk },
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

                    detailElement1.append('<tr><td>' + (i+1) + '</td><td>' + nama + '</td><td>' + nik + '</td><td>' + jenis_kelamin + '</td><td>' + tempat_lahir + '</td><td>' + tanggal_lahir + '</td></tr>');
                    detailElement2.append('<tr><td>' + (i+1) + '</td><td>' + agama + '</td><td>' + pekerjaan + '</td><td>' + status_perkawinan + '</td><td>' + status_keluarga + '</td><td>WNI</td></tr>');
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

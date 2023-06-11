@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <div>
        <section class="section">
            <div class="section-header">
                <h1>Data Kependudukan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Penduduk</a></div>
                    <div class="breadcrumb-item"><a href="#">Management</a></div>
                    <div class="breadcrumb-item">Table</div>
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
                                    <a class="btn btn-icon icon-left btn-primary" href="">Tambah Penduduk</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md" id="penduduk">
                                        <thead>
                                            <tr>
                                                <th>No. KK</th>
                                                <th>Nama</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($penduduk as $key => $item)
                                                <tr>
                                                    <td>{{ $item->no_kk }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td><button id="tombolData" class="openKTP data-link" data-toggle="modal" data-target="#kk"  data-no_kk="{{ $item->no_kk }}">Kartu Keluarga</button></td>
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
    </div>
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
                                        <td>Nama Kepala Keluarga</td>
                                        <td>: <span><b>ALFAN FARCHI AL-HADI</b></span></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>: JL. SILIKAT 47</td>
                                    </tr>
                                    <tr>
                                        <td>RT/RW</td>
                                        <td>: 003/005</td>
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
                                        <tbody id="anggota"></tbody>
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
                                                <th>Bantuan Sosial</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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

        $(document).on("click", ".openKTP", function () {
            var no_kk = $(this).data('no_kk');
            $(".modal-content #no_kk").text(no_kk);
        });
    </script>

    <script>
    $(document).ready(function() {
        $('.data-link').click(function() {
            var no_kk = $(this).data('value');
            
            $.ajax({
            url: '/penduduk',
            method: 'POST',
            data: { no_kk: no_kk },
            success: function(response) {
                // Tampilkan data pada elemen HTML dengan ID "anggota"
                var anggotaElement = $('#anggota');
                anggotaElement.empty();

                // Iterasi melalui setiap baris hasil query
                for (var i = 0; i < response.length; i++) {
                    var nama = response[i].nama;
                    var no_kk = response[i].no_kk;

                    anggotaElement.append('<tr><td>' + no_kk + '</td><td>' + nama + '</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                // Penanganan kesalahan
                console.log(error);
            }
            });
        });
    });
    </script>
@endpush

@push('customStyle')
@endpush

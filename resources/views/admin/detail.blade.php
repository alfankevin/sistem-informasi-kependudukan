@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
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
                        <div class="card-header" style="background: black">
                            <h4>Daftar Penduduk</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="">Tambah Penduduk</a>
                            </div>
                        </div>
                        <div class="card-body" style="background: black">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="penduduk" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th style="white-space: nowrap">Tempat Lahir</th>
                                            <th>Tgl Lahir</th>
                                            <th>Jenis.</th>
                                            <th>Gol.</th>
                                            <th>Agama</th>
                                            <th>Pekerjaan</th>
                                            <th>Alamat</th>
                                            <th>RT</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade d-block show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content detail-nik">
                <div class="">
                    <div name="nama" id="nama"></div>
                    <div name="tempat_lahir" id="tempat_lahir"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal d-block" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="detailKTP">
                    <div class="headerKTP">
                        <h5>PROVINSI JAWA TIMUR</h5>
                        <h5>KOTA MALANG</h5>
                    </div>
                    <div class="bodyKTP">
                        <div>
                            <h5>NIK&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;:&nbsp;</h5><span>1233123134231431</span>
                        </div>
                        <table>
                            <tr>
                                <td>Nama</td>
                                <td>: ALFAN FARCHI AL-HADI</td>
                            </tr>
                            <tr>
                                <td>Tempat/Tgl Lahir</td>
                                <td>: MALANG, 15-09-2002</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>: PEREMPUAN&emsp;&emsp;&ensp;Gol.Darah&emsp;: A</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: Alfan</td>
                            </tr>
                            <tr>
                                <td>&emsp;&emsp;&ensp;RT/RW</td>
                                <td>: Alfan</td>
                            </tr>
                            <tr>
                                <td>&emsp;&emsp;&ensp;Kel/Desa</td>
                                <td>: Alfan</td>
                            </tr>
                            <tr>
                                <td>&emsp;&emsp;&ensp;Kecamatan</td>
                                <td>: Alfan</td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td>: Alfan</td>
                            </tr>
                            <tr>
                                <td>Status Perkawinan</td>
                                <td>: Alfan</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>: Alfan</td>
                            </tr>
                            <tr>
                                <td>Kewarganegaraan</td>
                                <td>: Alfan</td>
                            </tr>
                            <tr>
                                <td>Bantuan Sosial</td>
                                <td>: Alfan</td>
                            </tr>
                        </table>
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
            var nama = $(this).data('nama');
            var tempat_lahir = $(this).data('tempat_lahir');
            $(".modal-content #nama").text(nama);
            $(".modal-content #tempat_lahir").text(tempat_lahir);
        });
    </script>
@endpush

@push('customStyle')
@endpush

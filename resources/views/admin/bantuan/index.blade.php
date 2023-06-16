@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Data Bantuan Sosial</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Bantuan</a></div>
                <div class="breadcrumb-item"><a href="#">Management</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Bantuan Sosial</h2>

            <div class="row">
                <div class="col-12">
                    @include('admin.layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Penerima</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('bantuan.create') }}">Tambah Penerima</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="bantuan">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Usia</th>
                                            <th>Gender</th>
                                            <th>Agama</th>
                                            <th>Pekerjaan</th>
                                            <th>Alamat</th>
                                            <th>RT</th>
                                            <th>Bantuan</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}
                                                </td>
                                                <td>{{ $item->nama }}</td>
                                                <td class="text-nowrap">{{ $item->usia }} th</td>
                                                <td>{{ $item->gender }}</td>
                                                <td>{{ $item->agama }}</td>
                                                <td>{{ $item->pekerjaan }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>00{{ $item->rt }}</td>
                                                <td>{{ $item->nama_sosial }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-sm btn-success btn-icon d-flex align-items-center justify-content-center openKTP" style="height: 30px; width: 30px"
                                                            data-toggle="modal"
                                                            data-target="#ktp"
                                                            data-nik="{{ $item->nik }}"
                                                            data-nama="{{ $item->nama }}"
                                                            data-tempat_lahir="{{ $item->tempat_lahir }}"
                                                            data-tanggal_lahir="{{ $item->tanggal_lahir }}"
                                                            data-gender="{{ $item->gender }}"
                                                            data-golongan_darah="{{ $item->golongan_darah }}"
                                                            data-alamat="{{ $item->alamat }}"
                                                            data-rt="{{ $item->rt }}"
                                                            data-agama="{{ $item->agama }}"
                                                            data-status_perkawinan="{{ $item->status_perkawinan }}"
                                                            data-pekerjaan="{{ $item->pekerjaan }}"
                                                            data-keterangan="{{ $item->keterangan }}"
                                                            data-sosial="{{ $item->nama_sosial }}">
                                                            <i class="fas fa-user"></i></button>
                                                        <a href="{{ route('bantuan.edit', $item->id) }}"
                                                            class="btn btn-sm btn-info btn-icon ml-2 mr-2 d-flex align-items-center justify-content-center" style="height: 30px; width: 30px">
                                                            <i class="fas fa-pen"></i></a>
                                                        <form action="{{ route('bantuan.destroy', $item->id) }}"
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
    <div id="ktp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="detailKTP">
                    <div class="headerKTP">
                        <h5>PROVINSI JAWA TIMUR</h5>
                        <h5>KOTA MALANG</h5>
                    </div>
                    <div class="bodyKTP">
                        <div>
                            <h5>NIK<span class="mr-2" style="margin-left: 70px">:</span></h5>
                            <span id="nik"></span>
                        </div>
                        <table>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><span id="nama"></span></td>
                            </tr>
                            <tr>
                                <td>Tempat/Tgl Lahir</td>
                                <td>:</td>
                                <td><span id="tempat_lahir"></span>, <span id="tanggal_lahir"></span></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><span id="gender" class="mr-4"></span>Gol. Darah : <span id="golongan_darah"></span></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><span id="alamat"></span></td>
                            </tr>
                            <tr>
                                <td class="pl-4">RT/RW</td>
                                <td>:</td>
                                <td>00<span id="rt"></span>/005</td>
                            </tr>
                            <tr>
                                <td class="pl-4">Kel/Desa</td>
                                <td>:</td>
                                <td>TANJUNGREJO</td>
                            </tr>
                            <tr>
                                <td class="pl-4">Kecamatan</td>
                                <td>:</td>
                                <td>SUKUN</td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td>:</td>
                                <td><span id="agama"></span></td>
                            </tr>
                            <tr>
                                <td>Status Perkawinan</td>
                                <td>:</td>
                                <td><span id="status_perkawinan"></span></td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td><span id="pekerjaan"></span></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><span id="keterangan"></span></td>
                            </tr>
                            <tr>
                                <td>Bantuan Sosial</td>
                                <td>:</td>
                                <td><span id="sosial"></span></td>
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

        $(document).on("click", ".openKTP", function() {
            var nik = $(this).data('nik');
            var nama = $(this).data('nama');
            var tempat_lahir = $(this).data('tempat_lahir');
            var tanggal_lahir = $(this).data('tanggal_lahir');
            var gender = $(this).data('gender');
            var golongan_darah = $(this).data('golongan_darah');
            var alamat = $(this).data('alamat');
            var rt = $(this).data('rt');
            var agama = $(this).data('agama');
            var status_perkawinan = $(this).data('status_perkawinan');
            var pekerjaan = $(this).data('pekerjaan');
            var keterangan = $(this).data('keterangan');
            var sosial = $(this).data('sosial');

            $(".modal-content #nik").text(nik);
            $(".modal-content #nama").text(nama);
            $(".modal-content #tempat_lahir").text(tempat_lahir);
            $(".modal-content #tanggal_lahir").text(tanggal_lahir);
            $(".modal-content #gender").text(gender);
            $(".modal-content #golongan_darah").text(golongan_darah);
            $(".modal-content #alamat").text(alamat);
            $(".modal-content #rt").text(rt);
            $(".modal-content #agama").text(agama);
            $(".modal-content #status_perkawinan").text(status_perkawinan);
            $(".modal-content #pekerjaan").text(pekerjaan);
            $(".modal-content #keterangan").text(keterangan);
            $(".modal-content #sosial").text(sosial);
        });
    </script>
@endpush

@push('customStyle')
@endpush

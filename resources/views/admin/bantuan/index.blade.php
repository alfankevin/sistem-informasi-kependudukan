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
                        <div class="card-header">
                            <h4>Daftar Penduduk</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('penduduk.create') }}">Tambah Penduduk</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="table-1">
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
                                    <tbody>
                                        @foreach ($penduduk as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}
                                                </td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->tempat_lahir }}</td>
                                                <td style="white-space: nowrap">{{ $item->tanggal_lahir }}</td>
                                                <td>{{ $item->jenis_kelamin }}</td>
                                                <td>{{ $item->golongan_darah }}</td>
                                                <td>{{ $item->agama }}</td>
                                                <td>{{ $item->pekerjaan }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>0{{ $item->rt }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-sm btn-warning btn-icon d-flex align-items-center justify-content-center openKTP" style="height: 30px; width: 30px"
                                                            data-toggle="modal"
                                                            data-target="#exampleModalCenter"
                                                            data-nama="{{ $item->nama }}"
                                                            data-tempat_lahir="{{ $item->tempat_lahir }}">
                                                            <i class="fas fa-user"></i></button>
                                                        <a href="{{ route('penduduk.edit', $item->id) }}"
                                                            class="btn btn-sm btn-info btn-icon ml-2 mr-2 d-flex align-items-center justify-content-center" style="height: 30px; width: 30px">
                                                            <i class="fas fa-pen"></i></a>
                                                        <form action="{{ route('penduduk.destroy', $item->id) }}"
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content detail-nik">
                <div class="">
                    <div name="nama" id="nama"></div>
                    <div name="tempat_lahir" id="tempat_lahir"></div>
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

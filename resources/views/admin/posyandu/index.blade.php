@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Data Batita</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Posyandu</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tabel</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Posyandu</h2>
            <div class="row">
                <div class="col-12">
                    @include('admin.layouts.alert')
                    @if ($errors->has('file'))
                        <div class="text-danger">
                            {{ $errors->first('file') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Batita</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('posyandu.create') }}">Tambah
                                    Batita</a>
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
                                <table class="table table-bordered table-md" id="posyandu" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th width=65px>Tgl Lahir</th>
                                            <th>JK</th>
                                            <th>Alamat</th>
                                            <th>Usia (Bulan)</th>
                                            <th>Berat Badan (kg)</th>
                                            <th>Panjang Badan (cm)</th>
                                            <th>Lingkar Lengan Atas (cm)</th>
                                            <th>Lingkar Lengan Bawah (cm)</th>
                                            <th>Lingkar Dada (cm)</th>
                                            <th>Lingkar Perut (cm)</th>
                                            <th>Lingkar Kepala (cm)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="show-data">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                <form action="{{ route('posyandu.import') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="file" class="form-control" accept=".xls,.xlsx,.csv" required>
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
            $('#posyandu').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('posyandu.index') }}",
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
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "nama",
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
                        "data": "alamat",
                        "orderable": true,
                    },
                    {
                        "data": "usia",
                        "orderable": true,
                    },
                    {
                        "data": "tinggi_badan",
                        "orderable": true,
                    },
                    {
                        "data": "berat_badan",
                        "orderable": true,
                    },
                    {
                        "data": "lingkar_lengan_atas",
                        "orderable": true,
                    },
                    {
                        "data": "lingkar_lengan_bawah",
                        "orderable": true,
                    },
                    {
                        "data": "lingkar_dada",
                        "orderable": true,
                    },
                    {
                        "data": "lingkar_perut",
                        "orderable": true,
                    },
                    {
                        "data": "lingkar_kepala",
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
@endpush

@push('customStyle')
@endpush

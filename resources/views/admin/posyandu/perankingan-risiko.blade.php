@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Data Risiko Stunting</h1>
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
                            <h4>Daftar Risiko Stunting</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="ranking" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>JK</th>
                                            <th>Tgl Lahir</th>
                                            <th>Usia (Bulan)</th>
                                            <th>Alamat</th>
                                            <th>Status Gizi</th>
                                            <th>Nilai Perankingan</th>
                                            <th>Kategori Risiko</th>
                                            {{-- <th>Action</th> --}}
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
@endsection
@push('customScript')
    <script>
        $(document).ready(function() {
            $('#ranking').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('perankingan-risiko.index') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "pageLength": 25,
                "columns": [{
                        "data": "rank",
                        "orderable": true,
                    },
                    {
                        "data": "nama",
                        "orderable": true,
                    },
                    {
                        "data": "jenis_kelamin",
                        "orderable": true,
                    },
                    {
                        "data": "tanggal_lahir",
                        "orderable": true,
                    },
                    {
                        "data": "usia",
                        "orderable": true,
                    },
                    {
                        "data": "alamat",
                        "orderable": true,
                    },
                    {
                        "data": "status_gizi",
                        "orderable": true,
                    },
                    {
                        "data": "nilai_topsis",
                        "orderable": true,
                    },
                    {
                        "data": "kategori_risiko",
                        "orderable": true,
                    },
                    // {
                    //     "data": "action",
                    //     "orderable": false,
                    //     "searchable": false
                    // }
                ]
            });
        });
    </script>
@endpush

@push('customStyle')
@endpush

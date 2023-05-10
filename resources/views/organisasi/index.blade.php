@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Data Organisasi Masyarakat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Organisasi Masyarakat</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Organisasi</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('organisasi.create') }}">Tambah Organisasi</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Gambar</th>
                                            <th>Deskripsi</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($organisasi as $key => $item)
                                            <tr>
                                                <td>{{ ($organisasi->currentPage() - 1) * $organisasi->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $item->nama_organisasi }}</td>
                                                <td class="gambar" item-id={{ $item->id }}>
                                                    <span item-id="{{ $item->id }}" class="open-item">{{ $item->gambar_organisasi }}</span>
                                                    <div id="open-{{ $item->id }}" class="close-item">
                                                        <img src="/assets/img/organisasi/{{ $item->gambar_organisasi }}" alt="Gambar">
                                                    </div>                                                
                                                </td>
                                                <td>{{ $item->deskripsi_organisasi }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('organisasi.edit', $item->id) }}"
                                                            class="btn btn-sm btn-info btn-icon ml-2 mr-2 d-flex align-items-center">
                                                            <span><i class="fas fa-edit"></i></span>&nbsp;Edit</a>
                                                        <form action="{{ route('organisasi.destroy', $item->id) }}"
                                                            method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete d-flex align-items-center">
                                                            <span><i class="fas fa-times"></i></span>&nbsp;Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $organisasi->withQueryString()->links() }}
                                </div>
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
    </script>
@endpush

@push('customStyle')
@endpush

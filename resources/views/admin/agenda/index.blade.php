@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Data Agenda Sosial</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Agenda</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tabel</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Agenda Sosial</h2>

            <div class="row">
                <div class="col-12">
                    @include('admin.layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Agenda</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('agenda.create') }}">Tambah Agenda</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Judul</th>
                                            <th>Tanggal</th>
                                            <th>Deskripsi</th>
                                            <th>Gambar</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($agenda as $key => $item)
                                            <tr>
                                                <td>{{ ($agenda->currentPage() - 1) * $agenda->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $item->judul_agenda }}</td>
                                                <td>{{ $item->tanggal_agenda }}</td>
                                                <td>{{ $item->deskripsi_agenda }}</td>
                                                <td class="openGambar" data-toggle="modal" data-target="#exampleModalCenter" data-gambar="/assets/img/agenda/{{ $item->gambar_agenda }}">{{ $item->gambar_agenda }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        @if ($item->prioritas)
                                                        <button class="unmark-btn btn btn-sm btn-success btn-icon d-flex align-items-center" data-id="{{ $item->id }}">
                                                            <span><i class="fas fa-eye"></i></span>&nbsp;Tampil</button>
                                                        @else
                                                        <button class="mark-btn btn btn-sm btn-warning btn-icon d-flex align-items-center" data-id="{{ $item->id }}">
                                                            <span><i class="fas fa-eye"></i></span>&nbsp;Tampil</button>
                                                        @endif
                                                        <a href="{{ route('agenda.edit', $item->id) }}"
                                                            class="btn btn-sm btn-info btn-icon ml-2 mr-2 d-flex align-items-center">
                                                            <span><i class="fas fa-edit"></i></span>&nbsp;Ubah</a>
                                                        <form action="{{ route('agenda.destroy', $item->id) }}"
                                                            method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete d-flex align-items-center">
                                                            <span><i class="fas fa-times"></i></span>&nbsp;Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $agenda->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="overflow: hidden; background: rgba(0,0,0,0)">
                <img class="gambar" id="gambar" alt="Gambar">
            </div>
        </div>
    </div>
@endsection
@push('customScript')
    <script>
        $(document).on("click", ".openGambar", function () {
            var gambar = $(this).data('gambar');
            $('.modal-content img').prop('src', $(this).data('gambar'));
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
            //ganti label berdasarkan nama file
            $('#file-upload').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#file-upload')[0].files[0].name;
                $(this).prev('label').text(file);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.mark-btn, .unmark-btn').click(function() {
                var button = $(this);
                var id = button.data('id');
                var url = "{{ route('agenda.mark', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        // Update the button text and class
                        if (button.hasClass('mark-btn')) {
                            // button.text('Mark');
                            button.removeClass('mark-btn btn btn-sm btn-warning btn-icon d-flex align-items-center').addClass('unmark-btn btn btn-sm btn-success btn-icon d-flex align-items-center');
                            // button.removeClass('mark-btn').addClass('unmark-btn');
                        } else {
                            // button.text('Mark');
                            button.removeClass('unmark-btn btn-sm btn btn-success btn-icon d-flex align-items-center').addClass('mark-btn btn btn-sm btn-warning btn-icon d-flex align-items-center');
                        }
                    },
                    error: function(xhr) {
                        var error = JSON.parse(xhr.responseText);
                        alert(error.message);
                    }
                });
            });
        });
    </script>
@endpush

@push('customStyle')
@endpush

@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Data Pengajuan Surat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Pengajuan Surat</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tabel</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Pengajuan Surat</h2>

            <div class="row">
                <div class="col-12">
                    @include('admin.layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Pengajuan Surat</h4>
                            {{-- <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('agenda.create') }}">Tambah Agenda</a>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Keperluan</th>
                                            <th>Surat Pengantar</th>
                                            <th>Lampiran</th>
                                            <th>Status Pengajuan</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($pengajuan_surat as $key => $item)
                                            <tr>
                                                <td>{{ ($pengajuan_surat->currentPage() - 1) * $pengajuan_surat->perPage() + $key + 1 }}
                                                <td>{{ $item->nik_pemohon }}</td>
                                                <td>{{ $item->nama_pemohon }}</td>
                                                <td>{{ $item->alamat_pemohon }}</td>
                                                <td>{{ $item->jenis_surat }}</td>
                                                <td class="open-pdf" data-toggle="modal" data-target="#pdfModal"
                                                    data-pdf="{{ asset('/assets/files/' . $item->pdf_path) }}"
                                                    data-lampiran="{{ !empty($item->lampiran) ? asset('/assets/files/' . $item->lampiran) : '' }}">
                                                    Lihat Surat Pengantar</td>

                                                @if (!empty($item->lampiran))
                                                    <td class="open-pdf" data-toggle="modal" data-target="#pdfModal"
                                                        data-pdf="{{ '/assets/files/' . $item->lampiran }}">
                                                        Lihat Lampiran
                                                    </td>
                                                @else
                                                    <td>-</td>
                                                @endif
                                                <td class="text-capitalize">{{ $item->status }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                                <div class="d-flex justify-content-center">
                                    {{ $pengajuan_surat->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Form Surat Pengantar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <embed id="pdf" src="" type="application/pdf" style="width: 100%; height: 75vh;">
                    <div class="lampiran-container d-noner mt-3">
                        <!-- tombol dropdown -->
                        <p class="font-weight-bold mb-1" style="font-size: 12pt; cursor: pointer;" data-toggle="collapse"
                            data-target="#collapseLampiran" aria-expanded="false" aria-controls="collapseLampiran">
                            <i class="fas fa-caret-down mr-2 toggle-icon"></i>
                            Lihat Lampiran
                        </p>

                        <!-- isi dropdown -->
                        <div id="collapseLampiran" class="collapse">
                            <embed src="" type="application/pdf" id="lampiran" style="width: 100%; height: 75vh;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Setujui</button>
                    <button class="btn btn-danger">Tolak</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customScript')
    <script>
        $(document).on("click", ".open-pdf", function() {
            $('#pdf').prop('src', $(this).data('pdf'));

            const lampiran = $(this).data('lampiran');
            if (lampiran !== "") {
                // tampilkan tombol lampiran
                $(".lampiran-container").removeClass('d-none');

                // reset collapse setiap kali modal dibuka
                $('#collapseLampiran').collapse('hide');
                $(".toggle-icon").removeClass("fa-caret-up").addClass("fa-caret-down");

                $('#lampiran').prop('src', lampiran);
            } else {
                // sembunyikan kalau gak ada lampiran
                $(".lampiran-container").addClass('d-none');
                $('#lampiran').prop('src', '');
            }
        });

        $('#collapseLampiran').on('show.bs.collapse', function() {
            $(".toggle-icon").removeClass("fa-caret-down").addClass("fa-caret-up");
        }).on('hide.bs.collapse', function() {
            $(".toggle-icon").removeClass("fa-caret-up").addClass("fa-caret-down");
        });
    </script>
@endpush

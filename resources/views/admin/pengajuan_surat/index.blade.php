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
                                            <th>Status Pengajuan</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($pengajuan_surat as $key => $item)
                                            <tr>
                                                <td>{{ ($pengajuan_surat->currentPage() - 1) * $pengajuan_surat->perPage() + $key + 1 }}
                                                <td>{{ $item->nik_pemohon }}</td>
                                                <td>{{ $item->nama_pemohon }}</td>
                                                <td>{{ $item->alamat_pemohon }}</td>
                                                <td>
                                                    @switch($item->jenis_surat)
                                                        @case('sktm')
                                                            Surat Keterangan Tidak Mampu
                                                        @break

                                                        @case('sku')
                                                            Surat Keterangan Usaha
                                                        @break

                                                        @case('skd')
                                                            Surat Keterangan Domisili
                                                        @break

                                                        @case('skck')
                                                            Surat Pengantar SKCK
                                                        @break

                                                        @case('ska')
                                                            Surat Izin Acara/Keramaian
                                                        @break

                                                        @case('sktp')
                                                            Surat Pengantar KTP
                                                        @break

                                                        @case('spkk')
                                                            Surat Pengantar Kartu Keluarga
                                                        @break

                                                        @case('skk')
                                                            Surat Keterangan Kematian
                                                        @break

                                                        @case('spaw')
                                                            Surat Pengantar Ahli Waris
                                                        @break

                                                        @case('skp')
                                                            Surat Keterangan Pindah
                                                        @break

                                                        @case('skbk')
                                                            Surat Keterangan Boro Kerja
                                                        @break

                                                        @default
                                                            -
                                                    @endswitch

                                                </td>
                                                {{-- <td class="open-pdf" data-toggle="modal" data-target="#pdfModal"
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
                                                @endif --}}
                                                <td class="text-capitalize">{{ $item->status }}</td>
                                                <td>
                                                    <div class="d-flex flex-column align-items-end">
                                                        <button
                                                            class="btn btn-sm btn-success btn-icon d-flex align-items-center justify-content-center mb-1"
                                                            id="open-pdf" data-toggle="modal" data-target="#pdfModal"
                                                            data-pdf="{{ asset('/assets/files/form_pengajuan/' . $item->pdf_path) }}"
                                                            data-idxPengajuan="{{ $item->id }}"
                                                            data-lampiran="{{ !empty($item->lampiran) ? asset('/assets/files/lampiran/' . $item->lampiran) : '' }}">
                                                            <i class="fas fa-file-pdf mr-3"></i> Lihat File</button>

                                                        <button
                                                            class="btn btn-sm btn-primary btn-icon d-flex align-items-center justify-content-center {{ $item->status === 'disetujui_rw' ? '' : 'disabled' }}"
                                                            {{ $item->status === 'disetujui_rw' ? '' : 'disabled' }}
                                                            id="send-email" data-toggle="modal" data-target="#emailModal"
                                                            data-nama-pemohon="{{ $item->nama_pemohon }}"
                                                            data-id-pengajuan="{{ $item->id }}"
                                                            data-rw="{{ $item->rw }}"
                                                            data-pdf-path="{{ $item->pdf_path }}">
                                                            <i class="fas fa-paper-plane mr-3"></i> Proses ke
                                                            Kelurahan</button>
                                                    </div>
                                                </td>
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

    @include('admin.pengajuan_surat.partials.pdf_modal')
    @include('admin.pengajuan_surat.partials.email_modal')
@endsection

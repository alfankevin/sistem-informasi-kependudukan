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
                                <table id="pengajuanTable" class="table table-bordered table-md w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Keperluan</th>
                                            <th>Status Pengajuan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($pengajuan_surat as $key => $item)
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
                                                <td class="text-capitalize">
                                                    @if ($item->status === 'selesai')
                                                        <span
                                                            class="badge badge-success badge-pill px-3 py-2 text-capitalize">{{ $item->status }}</span>
                                                    @elseif (str_contains($item->status, 'ditolak'))
                                                        <span
                                                            class="badge badge-danger badge-pill px-3 py-2 text-capitalize">penolakan
                                                            <span
                                                                class="text-uppercase">{{ ucfirst(explode('_', $item->status)[1]) }}</span></span>
                                                    @elseif ($item->status === 'diajukan')
                                                        <span
                                                            class="badge badge-warning badge-pill px-3 py-2 text-capitalize">pengajuan
                                                            diterima</span>
                                                    @elseif (str_contains($item->status, 'disetujui'))
                                                        <span
                                                            class="badge badge-primary badge-pill px-3 py-2 text-capitalize">
                                                            Verifikasi <span
                                                                class="text-uppercase">{{ ucfirst(explode('_', $item->status)[1]) }}</span>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
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

@push('customScript')
    <script>
        $(document).ready(function() {
            $('#pengajuanTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pengajuan-surat.index') }}",
                columns: [{
                        data: 'id',
                        "orderable": true,
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'nik_pemohon',
                        name: 'nik_pemohon',
                        width: '15%'
                    },
                    {
                        data: 'nama_pemohon',
                        name: 'nama_pemohon',
                        width: '15%'
                    },
                    {
                        data: 'alamat_pemohon',
                        name: 'alamat_pemohon',
                        width: '25%'
                    },
                    {
                        data: 'jenis_surat',
                        render: function(data, type, row) {
                            switch (data) {
                                case 'sktm':
                                    return ` <span class="badge badge-success badge-pill px-3 py-2 text-capitalize">${data}</span>`;
                                case 'sku':
                                    return 'Surat Keterangan Usaha';
                                case 'skd':
                                    return 'Surat Keterangan Domisili';
                                case 'skck':
                                    return 'Surat Pengantar SKCK';
                                case 'ska':
                                    return 'Surat Izin Acara/Keramaian';
                                case 'sktp':
                                    return 'Surat Pengantar KTP';
                                case 'spkk':
                                    return 'Surat Pengantar Kartu Keluarga';
                                case 'skk':
                                    return 'Surat Keterangan Kematian';
                                case 'spaw':
                                    return 'Surat Pengantar Ahli Waris';
                                case 'skp':
                                    return 'Surat Keterangan Pindah';
                                case 'skbk':
                                    return 'Surat Keterangan Boro Kerja';
                                case 'skb':
                                    return 'Surat Keterangan Beasiswa';
                                default:
                                    return '-';
                            }
                        },
                        width: '15%'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            if (data === 'selesai') {
                                return `<span class="badge badge-success badge-pill px-3 py-2 text-capitalize">${data}</span>`;
                            } else if (data.includes('ditolak')) {
                                let who = data.split('_')[1] ? data.split('_')[1].toUpperCase() :
                                    '';
                                return `<span class="badge badge-danger badge-pill px-3 py-2 text-capitalize">Penolakan <span class="text-uppercase">${who}</span></span>`;
                            } else if (data === 'diajukan') {
                                return `<span class="badge badge-warning badge-pill px-3 py-2 text-capitalize">Pengajuan Diterima</span>`;
                            } else if (data.includes('disetujui')) {
                                let who = data.split('_')[1] ? data.split('_')[1].toUpperCase() :
                                    '';
                                return `<span class="badge badge-primary badge-pill px-3 py-2 text-capitalize">Verifikasi <span class="text-uppercase">${who}</span></span>`;
                            }
                            return `<span class="badge badge-secondary badge-pill px-3 py-2">-</span>`;
                        },
                        width: '15%'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '10%'
                    },
                ]
            });
        });
    </script>
@endpush

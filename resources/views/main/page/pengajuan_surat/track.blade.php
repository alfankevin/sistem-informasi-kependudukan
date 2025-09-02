@extends('main.layouts.main')

@section('content')
    <section id="track-pengajuan" class="p-5 bg-light" style="min-height: 80vh">
        <div class="container">
            <!-- Form Input Token -->
            <div class="text-center mb-4">
                <h2 class="fw-bold blue-title">Lacak Pengajuan Surat</h2>
                <p class="text-muted">Masukkan nomor token untuk melihat status pengajuan surat Anda</p>

                <form action="" method="GET" class="d-flex justify-content-center mt-3">
                    <div class="input-group w-50">
                        <input type="text" name="token" class="form-control" placeholder="Contoh: ABC123XYZ"
                            value="{{ old('token', request('token')) }}">
                        <button class="btn btn-primary px-4" type="submit">Lacak</button>
                    </div>
                </form>
            </div>

            @if (!empty($pengajuan))
                <!-- Info Ringkasan -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body row text-center">
                        <div class="col-md-3 border-end">
                            <p class="text-muted mb-1">Jenis Surat</p>
                            <h6 class="fw-bold">
                                @switch($pengajuan->jenis_surat)
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
                            </h6>
                        </div>
                        <div class="col-md-3 border-end">
                            <p class="text-muted mb-1">Nama Pemohon</p>
                            <h6 class="fw-bold">{{ $pengajuan->nama_pemohon }}</h6>
                        </div>
                        <div class="col-md-3 border-end">
                            <p class="text-muted mb-1">Tanggal Pengajuan</p>
                            <h6 class="fw-bold">{{ $pengajuan->created_at->format('d-m-Y') }}</h6>
                        </div>
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Status</p>
                            @if ($pengajuan->status === 'selesai')
                                <span
                                    class="badge bg-success rounded-pill px-3 py-2 text-capitalize">{{ $pengajuan->status }}</span>
                            @elseif (str_contains($pengajuan->status, 'ditolak'))
                                <span class="badge bg-danger rounded-pill px-3 py-2 text-capitalize">Ditolak <span
                                        class="text-uppercase">{{ ucfirst(explode('_', $pengajuan->status)[1]) }}</span></span>
                            @else
                                <span class="badge bg-primary rounded-pill px-3 py-2 text-capitalize">
                                    @if ($pengajuan->status === 'diajukan')
                                        pengajuan diterima
                                    @elseif (str_contains($pengajuan->status, 'disetujui'))
                                        Verifikasi <span
                                            class="text-uppercase">{{ ucfirst(explode('_', $pengajuan->status)[1]) }}</span>
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timeline Proses -->
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold text-primary mb-0">Riwayat Proses</h6>
                    </div>
                    <div class="card-body">
                        <ul class="timeline">
                            @foreach ($historiPengajuan as $item)
                                <li class="timeline-item {{ $item->status === $pengajuan->status ? 'active' : '' }}">
                                    <span class="timeline-date">{{ $pengajuan->created_at->format('d-m-Y') }}</span>
                                    <div class="timeline-content">
                                        @if ($item->status === 'diajukan')
                                            <h6 class="mb-1">Pengajuan Diterima</h6>
                                            <p class="text-muted small mb-0">Data berhasil masuk ke sistem</p>
                                            <a class="small mb-0 text-decoration-none"
                                                href="{{ asset('/assets/files/form_pengajuan/' . $item->pengajuanSurat->pdf_path) }}">
                                                Lihat Surat Pengantar
                                            </a>
                                        @elseif (str_contains($item->status, 'disetujui'))
                                            @php $verifikator = ucfirst(explode('_', $item->status)[1]); @endphp
                                            <h6 class="mb-1">Verifikasi <span
                                                    class="text-uppercase">{{ $verifikator }}</span></h6>
                                            <p class="text-muted small mb-0"><span
                                                    class="text-uppercase">{{ $verifikator }}</span> memverifikasi dokumen
                                            </p>
                                        @elseif (str_contains($item->status, 'ditolak'))
                                            @php $penolak = ucfirst(explode('_', $item->status)[1]); @endphp
                                            <h6 class="mb-1 text-danger">Ditolak <span
                                                    class="text-uppercase">{{ $penolak }}</span></h6>
                                            <p class="text-muted small mb-0">
                                                Pengajuan dokumen ditolak
                                                @if (!empty($item->keterangan))
                                                    : {{ $item->keterangan }}
                                                @else
                                                    (Tanpa keterangan)
                                                @endif
                                            </p>
                                        @elseif ($item->status === 'selesai')
                                            <h6 class="mb-1">Terkirim ke Kelurahan</h6>
                                            <p class="text-muted small mb-0">
                                                Dokumen dikirim ke Kelurahan dan bisa diambil di kantor desa
                                            </p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                @if (request()->has('token') && request('token') === '')
                    <div class="alert alert-danger mt-4 text-center">
                        Token <strong>{{ request('token') }}</strong> tidak ditemukan.
                        Pastikan nomor token benar.
                    </div>
                @endif
            @endif
        </div>
    </section>
@endsection

@push('customScript')
    <script></script>
@endpush

@push('customStyle')
    <!-- Timeline CSS -->
    <style>
        .timeline {
            list-style: none;
            padding-left: 0;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #0d6efd;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 50px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 12px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #0d6efd;
            top: 5px;
        }

        .timeline-item.active::before {
            background: #198754;
        }

        .timeline-date {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
        }
    </style>
@endpush

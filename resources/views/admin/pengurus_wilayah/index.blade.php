@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Pengurus Wilayah</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Pengurus Wilayah</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tabel</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Pengurus Wilayah</h2>
            <p class="section-lead">
                Daftar pengurus wilayah (RT/RW) yang terdaftar dalam sistem beserta informasi akun dan tanda tangan digital.
            </p>

            <div class="row">
                <div class="col-12">
                    @include('admin.layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Pengurus Wilayah</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary"
                                    href="{{ route('pengurus-wilayah.create') }}">Tambah Pengurus</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Jabatan</th>
                                            <th>Tanda Tangan</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($pengurus as $key => $item)
                                            <tr>
                                                <td>{{ ($pengurus->currentPage() - 1) * $pengurus->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $item->penduduk->nama }}</td>
                                                <td>{{ $item->user->email }}</td>
                                                <td class="capitalize">
                                                    @if (Str::contains($item->jabatan, 'rw'))
                                                        Ketua RW {{ str_pad($item->wilayah_rw, 3, '0', STR_PAD_LEFT) }}
                                                    @elseif ($item->jabatan === 'ketua-rt')
                                                        Ketua RT {{ str_pad($item->wilayah_rt, 3, '0', STR_PAD_LEFT) }} <br>
                                                        RW {{ str_pad($item->wilayah_rw, 3, '0', STR_PAD_LEFT) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <img src="/assets/img/ttd_pengurus/{{ $item->ttd_path }}" alt="Foto"
                                                        class="prevGambar" style="height: 100px">
                                                </td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('pengurus-wilayah.edit', $item->id) }}"
                                                            class="btn btn-sm btn-info btn-icon ml-2 mr-2 d-flex align-items-center">
                                                            <span><i class="fas fa-edit"></i></span>&nbsp;Ubah</a>
                                                        <form action="{{ route('pengurus-wilayah.destroy', $item->id) }}" method="POST"
                                                            class="ml-2">
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
                                    {{ $pengurus->withQueryString()->links() }}
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
@endpush

@push('customStyle')
@endpush

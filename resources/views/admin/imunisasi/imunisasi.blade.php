@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Imunisasi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('penduduk.index') }}">Posyandu</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Imunisasi</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card mt-1 card-primary">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h4 class="card-title">Form Imunisasi Batita</h4>
                        <div>
                            <button id="btn-pertumbuhan" class="btn btn-light text-dark btn-sm" onclick="showCard('pertumbuhan')">
                                <i class="fas fa-stethoscope"></i> Pertumbuhan
                            </button>
                            <button id="btn-pemeriksaan" class="btn btn-light text-dark btn-sm" onclick="showCard('pemeriksaan')">
                                <i class="fas fa-stethoscope"></i> Pemeriksaan
                            </button>
                            <button id="btn-vaksinasi" class="btn btn-light text-dark btn-sm" onclick="showCard('vaksinasi')">
                                <i class="fas fa-medkit"></i> Vaksin
                            </button>
                            <button id="btn-vitamin" class="btn btn-light text-dark btn-sm" onclick="showCard('vitamin')">
                                <i class="fas fa-capsules"></i> Vitamin
                            </button>
                            <button data-toggle="modal"
                                data-target="#detail-riwayat" class="btn btn-danger btn-sm open-riwayat" data-id="{{ $posyandu->penduduk->id }}"><i class="fas fa-book"></i> Riwayat Vaksin
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="card shadow-lg mb-4">
                                <div class="card-header" style="padding: .75rem 25px; background-color: #2a5788; min-height: unset;">
                                    <h5 class="card-title text-white" style="font-weight: 400"><i class="fas fa-user me-2"></i> Data Batita</h5>
                                </div>
                                <div class="card-body border">
                                    <hr class="my-1">                 
                                    <div class="row">
                                        <div class="col-5 py-1">
                                            <b>Posyandu Bulan</b>
                                        </div>
                                        <div class="col-7 py-1">
                                            : {{ \Carbon\Carbon::parse($posyandu->bulan_posyandu)->format('Y-m') }}
                                        </div>
                                    </div>
                                    <hr class="my-1">
                                    <div class="row">
                                        <div class="col-5 py-1">
                                            <b>Nama Batita</b>
                                        </div>
                                        <div class="col-7 py-1">
                                            : {{ $posyandu->penduduk->nama }}
                                        </div>
                                    </div>
                                    <hr class="my-1">
                                    <div class="row">
                                        <div class="col-5 py-1">
                                            <b>Tanggal Lahir</b>
                                        </div>
                                        <div class="col-7 py-1">
                                            : {{ \Carbon\Carbon::parse($posyandu->penduduk->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
                                        </div>
                                    </div>
                                    <hr class="my-1">
                                    <div class="row">
                                        <div class="col-5 py-1">
                                            <b>Usia</b>
                                        </div>
                                        <div class="col-7 py-1">
                                            : {{ $posyandu->usia }} bulan
                                        </div>
                                    </div>
                                    <hr class="my-1">
                                    <div class="row">
                                        <div class="col-5 py-1">
                                            <b>Jenis Kelamin</b>
                                        </div>
                                        <div class="col-7 py-1">
                                            : {{ $posyandu->penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </div>
                                    </div>
                                    <hr class="my-1">
                                    <div class="row">
                                        <div class="col-5 py-1">
                                            <b>Tanggal Daftar</b>
                                        </div>
                                        <div class="col-7 py-1">
                                            : {{ \Carbon\Carbon::parse($posyandu->created_at)->format('d-m-Y') }} -
                                              {{ \Carbon\Carbon::parse($posyandu->created_at)->format('H:i:s') }}
                                        </div>
                                    </div>
                                    <hr class="my-1">                 
                                    <div class="row">
                                        <div class="col-5 py-1">
                                            <b>Alamat</b>
                                        </div>
                                        <div class="col-7 py-1">
                                            : {{ $posyandu->penduduk->kartuKeluarga->alamat }}
                                        </div>
                                    </div>
                                    <hr class="my-1">
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            @include('admin.imunisasi.pertumbuhan')
                            @include('admin.imunisasi.pemeriksaan')
                            @include('admin.imunisasi.vaksinasi')
                            @include('admin.imunisasi.vitamin')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- riwayat vaksin--}}
    @include('admin.posyandu.riwayat')

    <script>
        // Function to show only the specified card and hide the others
        function showCard(cardId) {
            const cardIds = ['pertumbuhan', 'pemeriksaan', 'vaksinasi', 'vitamin'];
            const buttonIds = ['btn-pertumbuhan', 'btn-pemeriksaan', 'btn-vaksinasi', 'btn-vitamin'];
            
            // Loop through all card IDs, displaying only the one with a matching cardId and hiding others
            cardIds.forEach((id, index) => {
                const card = document.getElementById(id);
                const button = document.getElementById(buttonIds[index]);
                
                if (id === cardId) {
                    card.style.display = 'block';
                    button.classList.add('btn-primary'); // Add red background
                    button.classList.remove('btn-light'); // Remove default background
                    button.setAttribute('style', 'color: white !important;');
                } else {
                    card.style.display = 'none';
                    button.classList.add('btn-light'); // Reset to default background
                    button.classList.remove('btn-primary'); // Remove red background
                    button.setAttribute('style', 'color: unset !important;');
                }
            });
        }
    
        // Show only the initial card on page load
        document.addEventListener("DOMContentLoaded", function() {
            showCard('pertumbuhan');
        });
    </script>
@endsection

@push('customScript')
    <script>
        $(document).ready(function() {
            const penduduk = {!! json_encode($posyandu->penduduk) !!};
            $('#usia').val(hitungUsiaDalamBulan(penduduk.tanggal_lahir));

            function hitungUsiaDalamBulan(tanggalLahir) {
                const lahir = new Date(tanggalLahir);
                const hariIni = new Date();

                let tahun = hariIni.getFullYear() - lahir.getFullYear();
                let bulan = hariIni.getMonth() - lahir.getMonth();
                let totalBulan = tahun * 12 + bulan;

                // Kalau hari ini belum lewat tanggal lahir di bulan ini, kurangi 1
                if (hariIni.getDate() < lahir.getDate()) {
                    totalBulan--;
                }

                return totalBulan;
            }
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush

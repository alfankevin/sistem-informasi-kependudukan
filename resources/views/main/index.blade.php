@extends('main.layouts.main')

@section('content')
    {{-- Hero --}}
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="/assets/img/agenda/maulid.jpg"></div>
            <div class="hero__items set-bg" data-setbg="/assets/img/agenda/patrol.jpg"></div>
            <div class="hero__items set-bg" data-setbg="/assets/img/agenda/vaksin.jpg"></div>
        </div>
    </section>

    {{-- Sambutan --}}
    <section class="sambutan">
        <div class="container-xxl">
            <div class="row g-5 align-items-center">
                <div class="col-lg-4">
                    <img class="img-fluid rounded-4 shadow profile" src="{{ asset('assets/img/main/profile2.png') }}">
                </div>
                <div class="col-lg-8">
                    <h1 class="mb-4">SAMBUTAN KETUA RW 05</h1>
                    <p class="mb-4">Assalamualaikum Wr. Wb.</p>

                    <p class="mb-4" style="line-height: 2">
                        Kemanusiaan Yang Adil dan Beradab adalah sebaik-baik barometer kita sebagai Warga Negara yang baik
                        dalam memberikan pelayanan dan sebagai wakil pemerintah di tengah-tengah masyarakat, karena kemajuan
                        sebuah lingkungan terutama sosial ekonomi bukan hanya menjadi tanggung jawab perorangan. Melainkan
                        tanggung jawab kita semua. Untuk itu hanya dengan niat dan kemauan yang kuat ditambah doa kita Semua
                        insyaAllah mampu mengubah RW 05 Kelurahan Tanjungrejo, Kota Malang ini menjadi lingkungan yang lebih
                        guyub dan rukun, adil dan beradab sosial dan ekonominya. Lebih merdeka dalam segala hal yang
                        positif. Terima kasih. </p>

                    <p class="m-0">
                        <span class="badge shadow rounded-pill">#tonggoKuiseduLurPalingCede'k</span>
                        <span class="badge shadow rounded-pill">#RW05PeduliLingkungan</span>
                        <span class="badge shadow rounded-pill">#TanjungrejoDisiniAja</span>
                        <span class="badge shadow rounded-pill">#TidakKemana-ManaAdaDimana-Mana</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Penduduk --}}
    <div class="penduduk">
        <div class="container">
            <div class="row text-white">
                <div class="count col-sm-3 wow fadeIn d-flex justify-content-center" data-wow-delay="0s">
                    <div class="count-penduduk text-center">
                        <div class="d-flex align-items-center">
                            <div>
                                <h2 class="pb-2" style="border-bottom: 2px solid #fdc800; font-size: 50px"
                                    data-val="{{ $countPenduduk }}" id="num"></h2>
                            </div>
                            <p class="text-uppercase">Jiwa</p>
                        </div>
                    </div>
                </div>
                <div class="count col-sm-3 wow fadeIn d-flex justify-content-center" data-wow-delay="0s">
                    <div class="count-penduduk text-center">
                        <div class="d-flex align-items-center">
                            <div>
                                <h2 class="pb-2" style="border-bottom: 2px solid #fdc800; font-size: 50px"
                                    data-val="{{ $countL }}" id="num"></h2>
                            </div>
                            <p class="text-uppercase">Laki-laki</p>
                        </div>
                    </div>
                </div>
                <div class="count col-sm-3 wow fadeIn d-flex justify-content-center" data-wow-delay="0s">
                    <div class="count-penduduk text-center">
                        <div class="d-flex align-items-center">
                            <div>
                                <h2 class="pb-2" style="border-bottom: 2px solid #fdc800; font-size: 50px"
                                    data-val="{{ $countP }}" id="num"></h2>
                            </div>
                            <p class="text-uppercase">Perempuan</p>
                        </div>
                    </div>
                </div>
                <div class="count col-sm-3 wow fadeIn d-flex justify-content-center" data-wow-delay="0s">
                    <div class="count-penduduk text-center">
                        <div class="d-flex align-items-center">
                            <div>
                                <h2 class="pb-2" style="border-bottom: 2px solid #fdc800; font-size: 50px"
                                    data-val="{{ $countKK }}" id="num"></h2>
                            </div>
                            <p class="text-uppercase">Kepala Keluarga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ormas --}}
    <section class="ormas flex justify-content-center align-content-center">
        <h2 class="text-center mb-5 text-capitalize">Organisasi Masyarakat</h2>
        <div class="container">
            <div class="owl-carousel owl-theme" id="ormas">
                @foreach ($ormas as $key => $item)
                    <div class="item ms-2 me-2">
                        <div class="card border-0 m-auto">
                            <img src="/assets/img/organisasi/{{ $item->gambar_organisasi }}"
                                class="card-img-top rounded-circle object-fit-cover shadow m-auto"
                                width="50%" height="200">
                            <div class="card-body mt-2 text-center">
                                <h5 class="card-title text-capitalize">{{ $item->nama_organisasi }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Agenda --}}
    <div class="agenda album" id="agenda">
        <div class="container">
            <div class="pb-2 text-center">
                <h2 class="text-center text-capitalize" id="">Agenda terbaru</h2>
            </div>
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 g-3 m-2">
                @foreach ($agenda as $item)
                    <div class="col mb-4">
                        <div class="card card-agenda">
                            <img src="/assets/img/agenda/{{ $item->gambar_agenda }}" class="card-img-top object-fit-cover" height="200">
                            <div class="card-body">
                                <h5 class="card-title text-capitalize">{{ $item->judul_agenda }}</h5>
                                <p class="card-text thumbnail read-toggle" data-id='0'>
                                    <span id=""
                                        class="agenda-desc line-clamp-2">{{ $item->deskripsi_agenda }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pt-2 pb-2 text-center">
                <a href="/agenda"><button class="btn-more">Lihat lagi</button></a>
            </div>
        </div>
    </div>

    {{-- Potensi --}}
    <div class="potensi album" id="potensi" style="padding-top: 40px">
        <div class="container">
            <div class="pb-5 text-center">
                <h2 class="text-center m-0">Potensi UMKM</h2>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mx-auto">
                @foreach ($potensi as $item)
                    <div class="col">
                        <div class="mx-auto" style="width: 80%;">
                            <div class="potensi-img">
                                <img src="/assets/img/potensi/{{ $item->gambar_umkm }}"
                                    class="m-sm-0 m-md-0 m-lg-0 card-img-top rounded-circle object-fit-cover shadow" width="200" height="200">
                            </div>
                            <div class="card-body mt-3 text-center">
                                <h5 class="card-title text-capitalize mb-1">{{ $item->nama_umkm }}</h5>
                                <p class="card-text mb-1">{{ $item->deskripsi_umkm }}</p>
                                <a href="{{ $item->sosial_media }}" class="text-decoration-none fw-bold"
                                    id="custom-text-link">beli sekarang
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pt-5 text-center">
                <a href="/potensi"><button class="btn-more">Lihat lagi</button></a>
            </div>
        </div>
    </div>

    {{-- Galeri --}}
    <div class="galeri">
        <section class="container">
            <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 g-4 mx-auto">
                @foreach ($galeri as $item)
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                        <figure><img class="img-fluid img-thumbnail" src="/assets/img/galeri/{{ $item->foto }}"></figure>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
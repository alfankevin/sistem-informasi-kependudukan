@extends('main.layouts.main')

@section('content')
    <section id="potensi" class="container mx-auto flex justify-center align-content-center">
        <h2 class="text-center my-5 blue-title text-capitalize display-4">Potensi UMKM</h2>
        <div class="album my-4" id="potensi">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mx-auto">
                    @foreach ($potensi as $item)
                        <div class="col mb-4">
                            <div class="potensi mx-auto" style="width: 85%; padding: 0">
                                <div class="potensi-img">
                                    <img src="/assets/img/potensi/{{ $item->gambar_umkm }}"
                                        class="m-sm-0 m-md-0 m-lg-0 card-img-top rounded-circle object-fit-cover shadow"
                                        alt="..." width="200" height="200">
                                </div>
                                <div class="card-body mt-3 text-center">
                                    <h5 class="card-title text-capitalize mb-1">{{ $item->nama_umkm }}</h5>
                                    <p class="card-text mb-1">{{ $item->deskripsi_umkm }}</p>
                                    <a href="{{ $item->sosial_media }}" class="text-decoration-none fw-bold" id="custom-text-link">beli
                                        sekarang
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
            </div>
        </div>
    </section>
@endsection

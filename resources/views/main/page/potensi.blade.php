@extends('main.layouts.main')

@section('content')
    <section id="potensi" class="container mx-auto flex justify-center align-content-center">
        <h2 class="text-center my-5 blue-title text-capitalize display-4">Potensi UMKM</h2>
        <div class="album my-4" id="potensi">
            <div class="row potensi row-cols-1 row-cols-md-2 d-flex justify-content-center">
                @foreach ($potensi as $item)
                <div class="col-md-4 mb-4">
                    <div class="card border-1 rounded-1" style="width: 100%; margin:0;">
                        <div class="row no-gutters">
                            <div class="col-md-4 potensi-img">
                                <img src="/assets/img/potensi/{{ $item->gambar_umkm }}" alt="Image 1" class="w-100 h-100">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title text-capitalize fw-bold mb-1">{{ $item->nama_umkm }}</h5>
                                        <p class="card-text mb-1" style="text-align: justify">{{ $item->deskripsi_umkm }}</p>
                                        <p class="card-text mb-1">Rp </p>
                                    </div>
                                    <a href="{{ $item->sosial_media }}" class="text-decoration-none fw-bold" id="custom-text-link">beli sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

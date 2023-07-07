@extends('main.layouts.main')

@section('content')
    <section id="potensi" class="container mx-auto flex justify-center align-content-center">
        <h2 class="text-center my-5 blue-title text-capitalize display-4">Potensi UMKM</h2>
        <div class="album" id="potensi">
            <div class="row potensi row-cols-1 row-cols-md-2 d-flex justify-content-center" style="padding-top: 0">
                @foreach ($potensi as $item)
                <div class="card border-0 col-md-4 mb-4 mx-1">
                    <img src="/assets/img/potensi/{{ $item->gambar_umkm }}" class="card-img-top object-fit-cover w-100" height="180">
                    <div class="card-body mt-3">
                        <h5 class="card-title text-capitalize">{{ $item->nama_umkm }}</h5>
                        <p class="card-text thumbnail read-toggle" data-id='0' style="text-align: justify">
                            <span id="" class="content-desc line-clamp satu">{{ $item->deskripsi_umkm }}</span>
                        </p>
                        <div class="row justify-content-between align-content-center">
                            <div class="col pt-3 w-50">
                                <span class="font-weight-bold text-black">Rp{{ $item->harga_umkm }},00</span>
                            </div>
                            <div class="col d-flex justify-content-end w-50">
                                <a href="{{ $item->sosial_media }}" class="text-decoration-none btn btn-buy" id="custom-text-link">beli sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

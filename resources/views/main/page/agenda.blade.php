@extends('main.layouts.main')

@section('content')
    <section id="agenda" class="py-5 bg">
        <h2 class="text-center mb-5 blue-title text-capitalize display-4">Agenda</h2>
        @foreach ($agenda as $item)
            <div class="item">
                <div class="card card-agenda mb-4 mx-auto border-0" style="max-width: 90%;">
                    <div class="row rounded-2 g-0" style="background: #fff">
                        <div class="col-md-4 p-2">
                            <img src="/assets/img/agenda/{{ $item->gambar_agenda }}" class="img-fluid img-agenda rounded-2"
                                alt="...">
                        </div>
                        <div class="col-md-8 p-2">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $item->judul_agenda }}</h5>
                                <p class="card-text">{{ $item->deskripsi_agenda }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection

@extends('main.layouts.main')

@section('content')
     <!-- galery start -->
     <section class="container py-5" id="gallery">
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 g-4 mx-auto">
            @foreach ($galeri as $item)
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <figure>
                        <a href="" class="d-block">
                            <img class="img-fluid img-thumbnail" src="/assets/img/galeri/{{ $item->foto }}"
                                alt="Random Image">
                        </a>
                    </figure>
                </div>
            @endforeach
        </div>
    </section>
    <div class="modal lightbox-modal" id="lightbox-modal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
        {{-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        <div class="modal-body">
            <div class="container-fluid p-0">
            <!-- JS content here -->
            </div>
        </div>
        </div>
    </div>
    </div>
@endsection

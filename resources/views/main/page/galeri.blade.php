@extends('main.layouts.main')

@section('content')
    <!-- galery start -->
    <div class="bg">
        <section class="container" id="gallery" style="padding-top: 3rem; padding-bottom: 2rem">
            <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 g-4 mx-auto">
                @foreach ($galeri as $item)
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                        <figure>
                            <a href="#" class="d-block">
                                <img class="img-fluid img-thumbnail img-galeri" src="/assets/img/galeri/{{ $item->foto }}">
                            </a>
                        </figure>
                    </div>
                @endforeach
            </div>
        </section>
        <div class="modal lightbox-modal" id="lightbox-modal" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid d-flex align-items-center p-0" style="height: 100%">
                            <!-- JS content here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

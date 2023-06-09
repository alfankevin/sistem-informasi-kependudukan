@extends('main.layouts.main')

@section('content')
     <!-- galery start -->
     <section class="container" id="gallery">
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 g-4 mx-auto">
            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                <figure>
                    <a href="" class="d-block">
                        <img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=1"
                            alt="Random Image">
                    </a>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                <figure>
                     <a href="" class="d-block">
                        <img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=2"
                            alt="Random Image">
                     </a>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-xs-6 thumb">

                <figure>
                     <a href="" class="d-block">
                        <img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=3"
                        alt="Random Image">
                     </a>
                </figure>

            </div>

            <div class="col-lg-3 col-md-4 col-xs-6 thumb">

                <figure>
                     <a href="" class="d-block"><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=4"
                        alt="Random Image">
                     </a>
                </figure>

            </div>

            <div class="col-lg-3 col-md-4 col-xs-6 thumb">

                <figure>
                     <a href="" class="d-block"><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=5"
                        alt="Random Image">
                    </a>
                </figure>

            </div>

            <div class="col-lg-3 col-md-4 col-xs-6 thumb">

                <figure>
                     <a href="" class="d-block"><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=6"
                        alt="Random Image">
                    </a>
                </figure>

            </div>

            <div class="col-lg-3 col-md-4 col-xs-6 thumb">

                <figure>
                     <a href="" class="d-block"><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=7"
                        alt="Random Image">
                    </a>
                    </figure>

            </div>

            <div class="col-lg-3 col-md-4 col-xs-6 thumb">

                <figure>
                     <a href="" class="d-block"><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=8"
                        alt="Random Image">
                     </a>
                </figure>

            </div>

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

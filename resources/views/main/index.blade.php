@extends('main.layouts.main')

@section('content')
    <section class="relative">

        <div id="carouselExampleRide" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1700">

        <div id="carouselExampleRide" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1613395940640-9c2d79562bf7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
                        class="d-block w-100" alt="..." style="height:600px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1545300082-ad9323e5e4ee?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=871&q=80"
                        class="d-block w-100" alt="..." style="height:600px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1582156307922-c6cd3584b6bf?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
                        class="d-block w-100" alt="..." style="height:600px; object-fit: cover;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <!-- Sambutan -->
    <!-- About start -->
    <section class="sambutan">
        <div class="container-xxl py-5">
            <div class="row g-5 align-items-center" style="min-height: 500px">
                <div class="col-lg-4">
                    <div class="">
                        <img class="img-fluid rounded-4 profile"
                            src="{{ asset('assets/img/main/profile2.png') }}" alt="Profile">
                    </div>
    
                </div>
                <div class="col-lg-8">
                    <h1 class="mb-4">SAMBUTAN <span class="text-dark-blue text-uppercase">KETUA RW 05</span></h1>
                    <p class="mb-4"> Assalamualaikum Wr. Wb.</b></p>
    
                    <p class="mb-4" style="line-height: 2">
                    Kemanusiaan Yang Adil dan Beradab adalah sebaik-baik barometer kita sebagai Warga Negara yang baik dalam memberikan pelayanan dan sebagai wakil pemerintah di tengah-tengah masyarakat, karena kemajuan sebuah lingkungan terutama sosial ekonomi bukan hanya menjadi tanggung jawab perorangan. Melainkan tanggung jawab kita semua. Untuk itu hanya dengan niat dan kemauan yang kuat ditambah doa kita Semua insyaAllah mampu mengubah RW 05 Kelurahan Tanjungrejo, Kota Malang ini menjadi lingkungan yang lebih guyub dan rukun, adil dan beradab sosial dan ekonominya. Lebih merdeka dalam segala hal yang positif. Terima kasih. </p>
    
                    <p>
                        <span class="badge rounded-pill bg-dark-blue">#tonggoKuiseduLurPalingCede'k</span>
                        <span class="badge rounded-pill bg-dark-blue">#RW05PeduliLingkungan</span>
                        <span class="badge rounded-pill bg-dark-blue">#TanjungrejoDisiniAja</span>
                        <span class="badge rounded-pill bg-dark-blue">#TidakKemana-ManaAdaDimana-Mana</span>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <div class="row p-3 mb-2 bg-dark-blue text-white" style="background-image: url(/assets/img/main/bg-gunung.jpg); background-position: center; background-repeat: no-repeat; background-size: cover">
        <div class="col-sm-3 wow fadeIn" data-wow-delay="0.1s">
            <div class=" p-1">
                <div class=" text-center p-4">
                    <i class="fa fa-mobile-screen fa-2x mb-2"></i>
                    <h2 class="mb-1" data-val="10" id="num">00</h2>
                    <p class="mb-0">Laki-laki</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 wow fadeIn" data-wow-delay="0.3s">
            <div class=" p-1">
                <div class=" text-center p-4">
                    <i class="fa fa-users-cog fa-2x mb-2"></i>
                    <h2 class="mb-1" data-val="80" id="num">00</h2>
                    <p class="mb-0">Perempuan</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 wow fadeIn" data-wow-delay="0.5s">
            <div class="p-1">
                <div class="text-center p-4">
                    <i class="fa fa-users fa-2x mb-2"></i>
                    <h2 class="mb-1" data-val="500" id="num">000</h2>

                    <p class="mb-0">Jiwa</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 wow fadeIn" data-wow-delay="0.5s">
            <div class=" p-1">
                <div class=" text-center p-4">
                    <i class="fa fa-users fa-2x mb-2"></i>
                    <h2 class="mb-1" data-val="500" id="num">000</h2>
                    <p class="mb-0">Kepala Keluarga</p>
                </div>
            </div>
        </div>
    </div>

    <!-- about end -->

    <!-- ormas -->
    <section class="flex justify-content-center align-content-center my-4 mb-5" id="ormas">
        <h2 class="text-center my-5 blue-title text-capitalize fw-bold">Organisasi Masyarakat</h2>
        <div class="ormas carousel mx-auto" data-bs-ride="carousel" id="carouselControls" style="width:90%">
            <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="col-md-3">
                <div class="card border-0">
                    <div class="card-body">
                    <img src="https://1.bp.blogspot.com/-3HopkQyBdVM/WQTWhSnWfjI/AAAAAAAAB-s/PaO2ZF9RpxUIDHyP_faRbxSh5kyK6FUtQCLcB/s1600/Logo%2BNahdlatul%2BUlama%2B%2528NU%2529%2B-%2BFormat%2BPNG.png" class= "card-img-top rounded-circle object-fit-cover shadow" alt="..." width="50%" height="200">
                        <div class="card-body mt-2 text-center">
                            <h5 class="card-title text-capitalize">nadhlatul ulama</h5>
                            <!-- <p class="card-text mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p> -->
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="col-md-3">
                <div class="card border-0">
                    <div class="card-body">
                    <img src="https://th.bing.com/th/id/OIP.kA5Kfs1jEspaCRokNVQErwHaHm?pid=ImgDet&w=860&h=883&rs=1" alt="" class="card-img-top rounded-circle object-fit-cover shadow" alt="..." width="50%" height="200">
                    <div class="card-body mt-2 text-center">
                        <h5 class="card-title text-capitalize">pemberdayaan kesejahteraan keluarga</h5>
                        <!-- <p class="card-text mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p> -->
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="col-md-3">
                <div class="card border-0">
                    <div class="card-body">
                    <img src="https://images.unsplash.com/photo-1555126634-323283e090fa?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=464&q=80" alt="" class="card-img-top rounded-circle object-fit-cover shadow" alt="..." width="50%" height="200">
                    <div class="card-body mt-2 text-center">
                        <h5 class="card-title text-capitalize">pemberdayaan kesejahteraan keluarga</h5>
                        <!-- <p class="card-text mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p> -->
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="col-md-3">
                <div class="card border-0">
                    <div class="card-body">
                    <img src="https://images.unsplash.com/photo-1555126634-323283e090fa?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=464&q=80" alt="" class="card-img-top rounded-circle object-fit-cover shadow" alt="..." width="50%" height="200">
                    <div class="card-body mt-2 text-center">
                        <h5 class="card-title text-capitalize">pemberdayaan kesejahteraan keluarga</h5>
                        <!-- <p class="card-text mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p> -->
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="col-md-3">
                <div class="card border-0">
                    <div class="card-body">
                    <img src="https://images.unsplash.com/photo-1555126634-323283e090fa?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=464&q=80" alt="" class="card-img-top rounded-circle object-fit-cover shadow" alt="..." width="50%" height="200">
                    <div class="card-body mt-2 text-center">
                        <h5 class="card-title text-capitalize">pemberdayaan kesejahteraan keluarga</h5>
                        <!-- <p class="card-text mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p> -->
                    </div>
                    </div>
                </div>
                </div>
            </div>

            </div>
            <!-- create next or prev button -->
            <button class="carousel-control-prev rounded-2 my-auto" type="button" data-bs-target="#carouselControls" data-bs-slide="prev">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
            </svg>
            <span class="visually-hidden text-black">Previous</span>
            </button>
            <button class="carousel-control-next rounded-2 my-auto" type="button" data-bs-target="#carouselControls" data-bs-slide="next">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
            <span class="visually-hidden">Next</span>
            </button>
        </div>

        </section>

        {{-- agenda --}}
        <div class="album my-4" id="agenda">
            <div class="container">
                <div class="p-2 text-center">
                    <h2 class="text-center blue-title text-capitalize fw-bold" id="">Agenda terbaru</h2>
                </div>
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 g-3 m-2">
                    <div class="col mb-4">
                        <div class="card shadow-light">
                            <img src="https://media.istockphoto.com/id/1164624416/photo/malaysia-hawker-culture-clay-pot-chicken-rice-stock-photo.jpg?b=1&s=170667a&w=0&k=20&c=65L8gxjLg-jpXtSSJVp3wT8c2Z5LL_eMkFTW8DVx9Bk=&auto=format&fit=crop&w=400&h=280&q=80" class="card-img-top object-fit-cover" alt="..." height="200">

                            <div class="card-body">
                            <h5 class="card-title text-capitalize fw-bold">Takjil Gratis</h5>
                            <p class="card-text thumbnail read-toggle" data-id='0'>Takjil gratis adalah sebuah program yang biasanya diadakan pada bulan Ramadan di mana makanan ringan atau minuman manis seperti kolak, kurma, atau air zam-zam dibagikan secara gratis kepada masyarakat yang sedang berpuasa.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card">
                        <img src="https://images.unsplash.com/photo-1615647112295-7f6355324a4a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&h=275&q=80" class="card-img-top object-fit-cover" alt="..." width="100%" height="200">
                            <div class="card-body">
                            <h5 class="card-title text-capitalize fw-bold">Bazar Murah</h5>
                            <p class="card-text thumbnail read-toggle" data-id='0'>Bazar murah sembako adalah sebuah acara di mana berbagai sembako (sembilan bahan pokok) seperti beras, minyak goreng, gula, tepung terigu, dan lain-lain dijual dengan harga yang lebih terjangkau atau murah dari harga pasar.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card">
                            <img src="https://images.unsplash.com/photo-1631002165139-81c716532830?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&h=275&q=80" class="card-img-top object-fit-cover" alt="..." width="100%" height="200">
                            <div class="card-body" id="module">
                            <h5 class="card-title text-capitalize fw-bold">Perayaan Hari Kemerdekaan RI</h5>
                                <p class="card-text thumbnail read-toggle" data-id='0'>Perayaan kemerdekaan RI merupakan acara tahunan yang dirayakan pada tanggal 17 Agustus untuk memperingati kemerdekaan Indonesia. Perayaan ini diisi dengan berbagai kegiatan seperti  pawai, lomba, dan pertunjukan seni budaya.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 text-center">
                    <a href="/agenda"><button class="btn-more">Lihat Lagi</button></a>
                </div>
            </div>


{{-- potensi --}}
    <div class="album my-4" id="potensi">
        <div class="container">
            <div class="p-5 text-center">
                <h2 class="text-center blue-title fw-bold">Potensi UMKM</h2>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mx-auto">
                <div class="col">
                    <div class="potensi mx-auto" style="width: 80%;">
                        <img src="https://images.unsplash.com/photo-1555126634-323283e090fa?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=464&q=80" class="m-sm-0 m-md-0 m-lg-0 card-img-top rounded-circle object-fit-cover" alt="..." width="200" height="200">
                        <div class="card-body mt-3 text-center">
                          <h5 class="card-title text-capitalize fw-bold">mie Ayam Pak No</h5>
                          <p class="card-text mb-1">Mie dengan topping ayam dan kuah segar</p>
                          <a href="#" class="text-decoration-none fw-bold" id="custom-text-link">beli sekarang
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                            </svg>
                          </a>
                        </div>
                      </div>
                </div>
                <div class="col">
                  <div class="potensi mx-auto" style="width: 80%;">
                      <img src="https://images.unsplash.com/photo-1567982047351-76b6f93e38ee?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" class="m-sm-0 m-md-0 m-lg-0 card-img-top rounded-circle object-fit-cover" alt="..." width="50%" height="200">
                      <div class="card-body mt-3 text-center">
                        <h5 class="card-title text-capitalize fw-bold">Pecel Ayam Jaya</h5>
                        <p class="card-text mb-1">Penyetan ayam dengan sambel orek</p>
                        <a href="#" class="text-decoration-none fw-bold" id="custom-text-link">beli sekarang
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                          </svg>
                        </a>
                      </div>
                    </div>
              </div>
              <div class="col">
                <div class="potensi mx-auto" style="width: 80%;">
                    <img src="https://images.unsplash.com/photo-1558961363-fa8fdf82db35?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=465&q=80" class="m-sm-0 m-md-0 m-lg-0 card-img-top rounded-circle object-fit-cover" alt="..." width="50%" height="200">
                    <div class="card-body mt-3 text-center">
                      <h5 class="card-title text-capitalize fw-bold">Cookie Yahuttt</h5>
                      <p class="card-text mb-1">Cookie lejatt dengan cokelat meleleh di dalamnya</p>
                      <a href="#" class="text-decoration-none fw-bold" id="custom-text-link">beli sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                        </svg>
                      </a>
                    </div>
                  </div>
            </div>
            <div class="col">
              <div class="potensi mx-auto" style="width: 80%;">
                  <img src="https://images.unsplash.com/photo-1555126634-323283e090fa?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=464&q=80" class="m-sm-0 m-md-0 m-lg-0 card-img-top rounded-circle object-fit-cover" alt="..." width="50%" height="200">
                  <div class="card-body mt-3 text-center">
                    <h5 class="card-title text-capitalize fw-bold">Kui Cakes</h5>
                    <p class="card-text mb-1">Aneka kue kering untuk hari raya eid</p>
                    <a href="#" class="text-decoration-none fw-bold" id="custom-text-link">beli sekarang
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                      </svg>
                    </a>
                  </div>
                </div>
          </div>
            </div>
            <div class="p-5 text-center">
            <a href="/potensi"><button class="btn-more">Lihat Lagi</button></a>
            </div>
    </div>
        </div>

        <!-- galery start -->
        <section class="container">
            {{-- <h1 class="my-4 text-center text-lg-left">Galeri</h1> --}}
            <div class="row row-cols-2 gallery">

            </div>
        </div>
        <!-- about end -->

        <!-- galery start -->
        <div style="background: #eaeaea">
            <section class="container">
                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 g-4 mx-auto">
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                        <figure><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=1"
                                alt="Random Image"></figure>
                    </div>
    
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                        <figure><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=2"
                                alt="Random Image"></figure>
                    </div>
    
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
    
                        <figure><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=3"
                                alt="Random Image"></figure>
    
                    </div>
    
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
    
                        <figure><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=4"
                                alt="Random Image"></figure>
    
                    </div>
    
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
    
                        <figure><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=5"
                                alt="Random Image"></figure>
    
                    </div>
    
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
    
                        <figure><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=6"
                                alt="Random Image"></figure>
    
                    </div>
    
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
    
                        <figure><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=7"
                                alt="Random Image"></figure>
    
                    </div>
    
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
    
                        <figure><img class="img-fluid img-thumbnail" src="https://picsum.photos/940/650?random=8"
                                alt="Random Image"></figure>
    
                    </div>
    
                </div>
            </section>
        </div>
    </div>
@endsection

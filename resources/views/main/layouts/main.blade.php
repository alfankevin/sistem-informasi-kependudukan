<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RW 5 Tanjungrejo</title>
        <link rel="icon" href="/assets/img/malang.png">

        <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/footers/">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

        <link rel="stylesheet" href="/assets/css/main.css">
        <link rel="stylesheet" href="/assets/css/main/owl.theme.default.min.css">
        <link rel="stylesheet" href="/assets/css/main/owl.carousel.min.css" type="text/css">
    </head>

    <body class="overflow-x-hidden">
        @include('main.utils.navbar')
        @yield('content')
        @include('main.utils.footer')

        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

        <!--Jquery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous"></script>
        <!-- Owl Carousel -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

        <script>
            // navbar
            document.addEventListener('scroll', () =>  {
                const nav = document.querySelector('nav');

                if(window.scrollY > 0) {
                    nav.classList.add('scrolled');
                    nav.classList.remove('navbar-dark');
                    nav.classList.add('navbar-light');
                } else {
                    nav.classList.remove('scrolled');
                    nav.classList.remove('navbar-light');
                    nav.classList.add('navbar-dark');
                }
            })

            // hero
            var hero = $(".hero__slider");
            hero.owlCarousel({
                loop: true,
                margin: 0,
                items: 1,
                dots: false,
                nav: true,
                navText: ["<div class='hero-button hero-prev'><span class='carousel-control-prev-icon' aria-hidden='true'></span></div>",
                    "<div class='hero-button hero-next'><span class='carousel-control-next-icon' aria-hidden='true'></span></div>"
                ],
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                autoplayTimeout: 4000,
                smartSpeed: 1200,
                autoHeight: false,
                autoplay: true,
                mouseDrag: false
            });

            // count
            let valueDisplays = document.querySelectorAll("#num");
            let interval = 5000;

            valueDisplays.forEach((valueDisplays) => {
                let startValue = 0;
                let endValue = parseInt(valueDisplays.getAttribute("data-val"));
                let duration = Math.floor(interval / endValue);
                let counter = setInterval(function() {
                    startValue += 1;
                    valueDisplays.textContent = startValue;
                    if (startValue == endValue) {
                        clearInterval(counter);
                    }
                }, duration);
            })

            // ormas
            var ormas = $("#ormas");
            ormas.owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                navText: ["<div class='nav-button owl-prev'><i class='fa fa-chevron-left'></i></div>",
                    "<div class='nav-button owl-next'><i class='fa fa-chevron-right'></i></div>"
                ],
                autoplay: true,
                autoplayhoverpause: true,
                autoplayTimeout: 2000,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            });

            // read more
            let agendaDescs = document.querySelectorAll(".agenda-desc");
            agendaDescs.forEach((agendaDesc) => {
                agendaDesc.addEventListener("click", function() {
                    var element = this;
                    if (element.classList.contains('line-clamp-2')) {
                        element.classList.remove('line-clamp-2');
                    } else {
                        element.classList.add('line-clamp-2');
                    }
                });
            });

            // gallery
            const imageGrid = document.querySelector("#gallery");
            const links = imageGrid.querySelectorAll("a");
            const imgs = imageGrid.querySelectorAll("img");
            const lightboxModal = document.getElementById("lightbox-modal");
            const bsModal = new bootstrap.Modal(lightboxModal);
            const modalBody = document.querySelector(".modal-body .container-fluid");
            const modal = document.querySelector("#lightboxCarousel");
            for (const link of links) {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    const currentImg = link.querySelector("img");
                    const lightboxCarousel = document.getElementById("lightboxCarousel");
                    if (lightboxCarousel) {
                        const parentCol = link.parentElement.parentElement;
                        const index = [...parentCol.parentElement.children].indexOf(parentCol);
                        const bsCarousel = new bootstrap.Carousel(lightboxCarousel);
                        bsCarousel.to(index);
                    } else {
                        createCarousel(currentImg);
                    }
                    bsModal.show();
                });
            }

            function createCarousel(img) {
                const markup = `
                    <div id="lightboxCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
                    <div class="carousel-inner" data-bs-dismiss="modal" aria-label="Close">
                        ${createSlides(img)}
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev" style="margin-left: 100px;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next" style="margin-right: 100px;">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    </div>
                `;
                modalBody.innerHTML = markup;
            }

            function createSlides(img) {
                let markup = "";
                const currentImgSrc = img.getAttribute("src");
                for (const img of imgs) {
                    const imgSrc = img.getAttribute("src");
                    const imgAlt = img.getAttribute("alt");
                    const imgCaption = img.getAttribute("data-caption");
                    markup += `
                <div class="carousel-item${currentImgSrc === imgSrc ? " active" : ""}">
                <img src=${imgSrc} alt=${imgAlt} width="600" height="400">
                ${imgCaption ? createCaption(imgCaption) : ""}
                </div>
                `;
                }
                return markup;
            }
        </script>

        <script src="assets/js/main/jquery-3.3.1.min.js"></script>
        <script src="assets/js/main/bootstrap.min.js"></script>
        <script src="assets/js/main/player.js"></script>
        <script src="assets/js/main/jquery.nice-select.min.js"></script>
        <script src="assets/js/main/mixitup.min.js"></script>
        <script src="assets/js/main/jquery.slicknav.js"></script>
        <script src="assets/js/main/owl.carousel.min.js"></script>
        <script src="assets/js/main/main.js"></script>
    </body>
</html>

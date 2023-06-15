<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RW 5 Tanjungrejo</title>
    <link rel="icon" href="/assets/img/malang.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/footers/">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/owl.theme.default.min.css">

    <script src="/assets/js/owl.carousel.min.js"></script>
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

        //read more javascript
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

        // ormas
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel();
        });

        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            navText: ["<div class='nav-button owl-prev'><i class='fa fa-chevron-left'></i></div>",
                "<div class='nav-button owl-next'><i class='fa fa-chevron-right'></i></div>"
            ],
            autoplay: true,
            autoplayhoverpause: true,
            autoplayTimeout: 3000,
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

                  // Event listener for window resize
                  window.addEventListener('resize', handleResponsive);
          // Initial call to handle responsive behavior
          handleResponsive();
        //   gallery modal
        const imageGrid = document.querySelector("#gallery");
        const links = imageGrid.querySelectorAll("a");
        const imgs = imageGrid.querySelectorAll("img");
        const lightboxModal = document.getElementById("lightbox-modal");
        const bsModal = new bootstrap.Modal(lightboxModal);
        const modalBody = document.querySelector(".modal-body .container-fluid");
        const modal = document.querySelector("#lightboxCarousel");
        for (const link of links) {
        link.addEventListener("click", function (e) {
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
</body>

</html>

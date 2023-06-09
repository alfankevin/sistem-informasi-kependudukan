<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/footers/">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,700&display=swap" rel="stylesheet">

</head>

<body class="overflow-x-hidden">
    @include('main.utils.navbar')
    @yield('content')
    @include('main.utils.footer')

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

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
            $(document).ready( function () {
                var contentArray=[];
                var index="";
                var clickedIndex="";
                var minimumLength=(parseFloat(getComputedStyle(module).lineHeight))*3;
                var initialContentLength=[];
                var initialContent=[];
                var readMore=" ...<br><br><span class='read-more'><span class='glyphicon glyphicon-plus-sign'></span>Selengkapnya</span>";
                var readLess="<br><br><span class='read-less'><span class='glyphicon glyphicon-minus-sign'></span>Lebih Sedikit</span>";
                    $('.read-toggle').each(function(){
                    index = $(this).attr('data-id');
                    contentArray[index] = $(this).html();
                    initialContentLength[index] = $(this).html().length;
                    if(initialContentLength[index]>minimumLength) {
                    initialContent[index]=$(this).html().substr(0,minimumLength);
                    }else {
                    initialContent[index]=$(this).html();
                    }
                    $(this).html(initialContent[index]+readMore);
                    //console.log(initialContent[0]);


                });
                    $(document).on('click','.read-more',function(){
                    $(this).fadeOut(1000, function(){
                    clickedIndex = $(this).parents('.read-toggle').attr('data-id');
                    $(this).parents('.read-toggle').html(contentArray[clickedIndex]+readLess);
                    });
                    });
                $(document).on('click','.read-less',function(){
                    $(this).fadeOut(1000, function(){
                    clickedIndex = $(this).parents('.read-toggle').attr('data-id');
                    $(this).parents('.read-toggle').html(initialContent[clickedIndex]+readMore);
                    });
                    });
                });

        // ormas
        function handleResponsive() {
            // Get the window width
            var windowWidth = window.innerWidth;

            // Select all carousel items
            var items = document.querySelectorAll('.ormas.carousel .carousel-item');

            // Define the default number of items to show
            var slide = 4;

            // Check the window width and update the number of items to show
            if (windowWidth < 576) {
              slide = 1; // Show 2 items for small screens
            } else if (windowWidth >= 576 && windowWidth < 992) {
              slide = 2; // Show 3 items for medium screens
            }

            // Loop through each carousel item
            items.forEach((e) => {
              let next = e.nextElementSibling;
              for (var i = 1; i < slide; i++) {
                if (!next) {
                  next = items[0];
                }
                let cloneChild = next.cloneNode(true);
                e.appendChild(cloneChild.children[0]);
                next = next.nextElementSibling;
              }
            });
          }

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

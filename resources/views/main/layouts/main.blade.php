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
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
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
         agendaDesc.addEventListener("click", function(){
              var element = this;
              if(element.classList.contains('line-clamp-2')){
                  element.classList.remove('line-clamp-2');
              }else{
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
          navText: ["<div class='nav-button owl-prev'><i class='fa fa-chevron-left'></i></div>", "<div class='nav-button owl-next'><i class='fa fa-chevron-right'></i></div>"],
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
  </script>
</body>

</html>
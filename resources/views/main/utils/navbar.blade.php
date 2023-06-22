<nav class="navbar navbar-expand-lg navbar-dark z-3 fixed-top">
    <div class="container">
        <a href="/"><img src="/assets/img/malang.png" alt="Logo" height="30px" style="margin: 0 10px 2.5px 0"></a>
        <a class="navbar-brand fw-bold m-0" href="/">ERWE LIMO Tanjungrejo</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" class="navbarSupportedContent">
            <ul class="navbar-nav ms-auto" style="padding: 0 10px;">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Request::is('agenda') ? 'active' : ''}}" href="/agenda">Agenda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Request::is('potensi') ? 'active' : ''}}" href="/potensi">Potensi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Request::is('galeri') ? 'active' : ''}}" href="/galeri">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
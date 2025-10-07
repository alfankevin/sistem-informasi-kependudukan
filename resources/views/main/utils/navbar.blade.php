<nav class="navbar navbar-expand-lg navbar-dark z-3 fixed-top">
    <div class="container">
        <a href="/"><img src="/assets/img/malang.png" alt="Logo" height="30px" style="margin: 0 10px 2.5px 0"></a>
        <a class="navbar-brand fw-bold m-0" href="/">ERWE LIMO Tanjungrejo</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" class="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page"
                        href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('agenda') ? 'active' : '' }}" href="/agenda">Agenda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('potensi') ? 'active' : '' }}" href="/potensi">Potensi</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ Request::is('galeri') ? 'active' : '' }}" href="/galeri">Galeri</a>
                </li> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link {{ Request::is('infografis-posyandu') ? 'active' : '' }}"
                        href="/dashboard">Infografis Posyandu</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link {{ Request::is('pelayanan/pengajuan-surat') ? 'active' : '' }}"
                        {{ Request::is('pelayanan/lacak-pengajuan') ? 'active' : '' }} href="#" role="button"
                        id="dropdownMenuPelayanan" data-bs-toggle="dropdown" aria-expanded="false">Pelayanan <i
                            class="fa fa-chevron-down ms-1" style="font-size: 11pt"></i></a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item {{ Request::is('pelayanan/pengajuan-surat') ? 'active' : '' }}"
                                href="/pelayanan/pengajuan-surat">Form Persuratan</a></li>
                        <li><a class="dropdown-item" href="/pelayanan/lacak-pengajuan">Lacak Pengajuan</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@php
    $id = request()->segment(3);
    $penduduk = request()->is('penduduk-management/penduduk/' . $id . '/edit');
    $keluarga = request()->is('penduduk-management/keluarga/' . $id . '/edit');
    $bantuan = request()->is('penduduk-management/bantuan/' . $id . '/edit');
    $organisasi = request()->is('organisasi-management/organisasi/' . $id . '/edit');
    $sosial = request()->is('sosial-management/sosial/' . $id . '/edit');
    $agenda = request()->is('agenda-management/agenda/' . $id . '/edit');
    $potensi = request()->is('potensi-management/potensi/' . $id . '/edit');
    $galeri = request()->is('galeri-management/galeri/' . $id . '/edit');
    $user = request()->is('user-management/user/' . $id . '/edit');
    $group = request()->is('menu-management/menu-group/' . $id . '/edit');
    $item = request()->is('menu-management/menu-item/' . $id . '/edit');
@endphp

<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="/dashboard"><img src="/assets/img/malang.png" width="25px" alt=""></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="/dashboard"><img src="/assets/img/malang.png" width="25px" alt=""></a>
    </div>
    <ul class="sidebar-menu">
        <li class="nav-item dropdown {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-chart-pie"></i>
                <span>Dashboard</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->is('dashboard') ? 'active' : '' }}"><a class="nav-link" href="/dashboard">Dashboard</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown {{ request()->is('penduduk-management/penduduk') ? 'active' : '' }} ||
            {{ request()->is('penduduk-management/keluarga') ? 'active' : '' }} ||
            {{ request()->is('penduduk-management/bantuan') ? 'active' : '' }} ||
            {{ request()->is('penduduk-management/penduduk/create') ? 'active' : '' }} ||
            {{ request()->is('penduduk-management/keluarga/create') ? 'active' : '' }} ||
            {{ request()->is('penduduk-management/bantuan/create') ? 'active' : '' }} ||
            {{ $penduduk ? 'active' : '' }} ||
            {{ $keluarga ? 'active' : '' }} ||
            {{ $bantuan ? 'active' : '' }}">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                <span>Kependudukan</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->is('penduduk-management/penduduk') ? 'active' : '' }}"><a class="nav-link" href="/penduduk-management/penduduk">Data Penduduk</a></li>
                <li class="{{ request()->is('penduduk-management/keluarga') ? 'active' : '' }}"><a class="nav-link" href="/penduduk-management/keluarga">Data Kartu Keluarga</a></li>
                <li class="{{ request()->is('penduduk-management/bantuan') ? 'active' : '' }}"><a class="nav-link" href="/penduduk-management/bantuan">Data Bantuan Sosial</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown {{ request()->is('organisasi-management/organisasi') ? 'active' : '' }} ||
            {{ request()->is('organisasi-management/organisasi/create') ? 'active' : '' }} ||
            {{ $organisasi ? 'active' : '' }}">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-sitemap"></i>
                <span>Organisasi</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->is('organisasi-management/organisasi') ? 'active' : '' }}"><a class="nav-link" href="/organisasi-management/organisasi">Organisasi Masyarakat</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown {{ request()->is('sosial-management/sosial') ? 'active' : '' }} ||
            {{ request()->is('sosial-management/sosial/create') ? 'active' : '' }} ||
            {{ $sosial ? 'active' : '' }}">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-handshake"></i>
                <span>Bantuan</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->is('sosial-management/sosial') ? 'active' : '' }}"><a class="nav-link" href="/sosial-management/sosial">Bantuan Sosial</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown {{ request()->is('agenda-management/agenda') ? 'active' : '' }} ||
            {{ request()->is('agenda-management/agenda/create') ? 'active' : '' }} ||
            {{ $agenda ? 'active' : '' }}">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-book"></i>
                <span>Agenda</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->is('agenda-management/agenda') ? 'active' : '' }}"><a class="nav-link" href="/agenda-management/agenda">Agenda Sosial</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown {{ request()->is('potensi-management/potensi') ? 'active' : '' }} ||
            {{ request()->is('potensi-management/potensi/create') ? 'active' : '' }} ||
            {{ $potensi ? 'active' : '' }}">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-store"></i>
                <span>Potensi</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->is('potensi-management/potensi') ? 'active' : '' }}"><a class="nav-link" href="/potensi-management/potensi">Potensi UMKM</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown {{ request()->is('galeri-management/galeri') ? 'active' : '' }} ||
            {{ request()->is('galeri-management/galeri/create') ? 'active' : '' }} ||
            {{ $galeri ? 'active' : '' }}">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-image"></i>
                <span>Galeri</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->is('galeri-management/galeri') ? 'active' : '' }}"><a class="nav-link" href="/galeri-management/galeri">Galeri Halaman</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown {{ request()->is('user-management/user') ? 'active' : '' }} ||
            {{ request()->is('user-management/user/create') ? 'active' : '' }} ||
            {{ $user ? 'active' : '' }}">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-user-tag"></i>
                <span>Pengguna</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->is('user-management/user') ? 'active' : '' }}"><a class="nav-link" href="/user-management/user">Daftar Pengguna</a></li>
            </ul>
        </li>
    </ul>
</aside>
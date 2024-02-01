<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-fw fa-leaf"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SKPL TOPSIS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $active == 'dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        MASTER DATA
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item <?= $active == 'alternatif' ? 'active' : '' ?>">
        <a class="nav-link" href="/data-alternatif">
            <i class="fas fa-fw fa-house-flag"></i>
            <span>Data Alternatif</span></a>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->
    <li class="nav-item <?= $active == 'kriteria' ? 'active' : '' ?>">
        <a class="nav-link" href="/data-kriteria">
            <i class="fas fa-fw fa-layer-group"></i>
            <span>Data Kriteria</span></a>
    </li>
    <!-- Nav Item - Charts -->
    <li class="nav-item <?= $active == 'matrix' ? 'active' : '' ?>">
        <a class="nav-link" href="/data-matrix">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Data Matrix</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        HASIL TOPSIS
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item <?= $active == 'nilai-matrix' ? 'active' : '' ?>">
        <a class="nav-link" href="/hasil-topsis/nilai-matrix">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Nilai Matrix</span></a>
    </li>
    <li class="nav-item <?= $active == 'nilai-normalisasi' ? 'active' : '' ?>">
        <a class="nav-link" href="/hasil-topsis/nilai-matrix-ternormalisasi">
            <i class="fas fa-fw fa-1"></i>
            <span>Matrix Ternormalisasi</span></a>
    </li>
    <li class="nav-item <?= $active == 'bobot-normalisasi' ? 'active' : '' ?>">
        <a class="nav-link" href="/hasil-topsis/nilai-bobot-ternormalisasi">
            <i class="fas fa-fw fa-2"></i>
            <span>Bobot Ternormalisasi</span></a>
    </li>
    <li class="nav-item <?= $active == 'matrix-ideal' ? 'active' : '' ?>">
        <a class="nav-link" href="/hasil-topsis/matrix-ideal-positif-negatif">
            <i class="fas fa-fw fa-3"></i>
            <span>Matrix Ideal</span></a>
    </li>
    <li class="nav-item <?= $active == 'jarak-solusi' ? 'active' : '' ?>">
        <a class="nav-link" href="/hasil-topsis/jarak-ideal-positif-negatif">
            <i class="fas fa-fw fa-4"></i>
            <span>Jarak Solusi Ideal</span></a>
    </li>
    <li class="nav-item <?= $active == 'nilai-preferensi' ? 'active' : '' ?>">
        <a class="nav-link" href="/hasil-topsis/nilai-preferensi">
            <i class="fas fa-fw fa-5"></i>
            <span>Nilai Preferensi</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        PENGATURAN
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item <?= $active == 'akun' ? 'active' : '' ?>">
        <a class="nav-link" href="/data-akun">
            <i class="fas fa-fw fa-cog"></i>
            <span>Manajemen Akun</span></a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->


</ul>
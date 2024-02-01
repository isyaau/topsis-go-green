<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-car"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Rental Mobil</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $active == 'dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url(); ?>/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item <?= $active == 'katalog' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url(); ?>/data-katalog">
            <i class="fas fa-fw fa-car"></i>
            <span>Data Katalog</span></a>
    </li>
    <!-- Nav Item - Charts -->
    <li class="nav-item <?= $active == 'pesanan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url(); ?>/data-pesanan">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Data Pesanan</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Charts -->
    <li class="nav-item <?= $active == 'setting' ? 'active' : '' ?>">
        <a class="nav-link" href="/data-pemesan/setting/<?= user()->id ?>">
            <i class="fas fa-fw fa-cog"></i>
            <span>Setting</span></a>
    </li>
    <!-- Divider -->
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->


</ul>
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand d-flex flex-column align-items-center pt-4" href="{{ route('sales.home') }}">
            <img src="{{ asset('admin_asset/img/photos/logo_telkomsel.png') }}" alt="Logo" style="height: 40px; filter: brightness(0) invert(1); margin-bottom: 10px;">
            <span class="align-middle" style="font-size: 0.85rem; opacity: 0.8;">PONDOK HAJI</span>
            <span class="align-middle" style="font-size: 0.85rem; opacity: 0.8;">Sales Panel</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header" style="opacity: 0.5; font-size: 0.65rem;">
                MENU UTAMA
            </li>

            <li class="sidebar-item {{ request()->routeIs('sales.home') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('sales.home') }}">
                    <i class="align-middle fas fa-home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('sales.transaksi') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('sales.transaksi') }}">
                    <i class="align-middle fas fa-shopping-cart"></i> <span class="align-middle">Input Transaksi</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('sales/rekap') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('sales/rekap') }}">
                    <i class="align-middle fas fa-file-invoice-dollar"></i> <span class="align-middle">Rekap Pendapatan</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

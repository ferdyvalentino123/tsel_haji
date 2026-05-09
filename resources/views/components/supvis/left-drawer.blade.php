<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand">
            <span class="align-middle">{{ Auth::user()->name }}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Dashboard
            </li>

            <x-nav-link href="{{ route('kasir.home') }}" :active="request()->is('programhaji/supvis/home') || request()->is('programhaji/supvis/budget-insentif')">Home</x-nav-link>
            <x-nav-link href="{{ route('admin.produk.index') }}" :active="request()->is('programhaji/produk/*', 'programhaji/produk')">Produk</x-nav-link>
            <x-nav-link href="{{ route('admin.merchandise.index') }}" :active="request()->is('programhaji/merch', 'programhaji/merch/*')">Merch</x-nav-link>
            <x-nav-link href="{{ route('add_sales') }}" :active="request()->is('programhaji/tambah-sales')">Add Sales</x-nav-link>
            <x-nav-link href="{{ route('history-setoran') }}" :active="request()->routeIs('history-setoran')">Checklist Sales</x-nav-link>
            <x-nav-link href="{{ route('transaksi.approve') }}" :active="request()->is('programhaji/supvis/approvetransaksi')">Approve Transaksi</x-nav-link>
            <x-nav-link href="{{ route('supvis.transactions.index') }}" :active="request()->routeIs('supvis.transactions.index')">Riwayat Transaksi</x-nav-link>
            <x-nav-link href="{{ route('admin.stock-history.index') }}" :active="request()->routeIs('admin.stock-history.index')">Pantau Stok</x-nav-link>
            <x-nav-link href="{{ route('supvis.budget_insentif.pantau') }}" :active="request()->routeIs('supvis.budget_insentif.pantau')">Pantau Budget</x-nav-link>
            @if(Auth::user() && Auth::user()->is_superuser)
                <x-nav-link href="{{ route('add_supvis') }}" :active="request()->is('programhaji/tambah-supvis')">Add Kasir</x-nav-link>
                <x-nav-link href="{{ route('role-users.sales') }}" :active="request()->is('programhaji/superuser/roleusers/sales')">Daftar Sales</x-nav-link>
            @endif
            <x-nav-link href="{{ route('admin.monitor.setoran') }}" :active="request()->routeIs('admin.monitor.setoran')">Monitor Setoran</x-nav-link>
            <x-nav-link href="{{ route('admin.monitor.void') }}" :active="request()->routeIs('admin.monitor.void')">Void Transaksi</x-nav-link>
        </ul>
    </div>
</nav>

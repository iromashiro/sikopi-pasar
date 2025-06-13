<ul class="nav flex-column">
    @role('Admin|SuperAdmin')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>

    <li class="nav-item">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-white-50">
            <span>Master Data</span>
        </h6>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.markets.*') ? 'active' : '' }}"
            href="{{ route('admin.markets.index') }}">
            <i class="bi bi-building"></i> Pasar
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.kiosks.*') ? 'active' : '' }}"
            href="{{ route('admin.kiosks.index') }}">
            <i class="bi bi-shop"></i> Kios
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.traders.*') ? 'active' : '' }}"
            href="{{ route('admin.traders.index') }}">
            <i class="bi bi-people"></i> Pedagang
        </a>
    </li>

    <li class="nav-item">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-white-50">
            <span>Transaksi</span>
        </h6>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.levies.*') ? 'active' : '' }}"
            href="{{ route('admin.levies.index') }}">
            <i class="bi bi-receipt"></i> Retribusi
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"
            href="{{ route('admin.payments.index') }}">
            <i class="bi bi-credit-card"></i> Pembayaran
        </a>
    </li>

    <li class="nav-item">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-white-50">
            <span>Laporan</span>
        </h6>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
            href="{{ route('admin.reports.show', 'daily') }}">
            <i class="bi bi-graph-up"></i> Laporan
        </a>
    </li>
    @endrole

    @role('Trader')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('trader.dashboard') ? 'active' : '' }}"
            href="{{ route('trader.dashboard') }}">
            <i class="bi bi-house"></i> Dashboard
        </a>
    </li>
    @endrole
</ul>
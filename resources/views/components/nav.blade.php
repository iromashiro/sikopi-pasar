@php
$user = auth()->user();
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ url('/') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="topNav">
            <ul class="navbar-nav me-auto mb-2">

                @role('Admin|SuperAdmin')
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Master</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.traders.index') }}">Traders</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.kiosks.index') }}">Kiosks</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.markets.index') }}">Markets</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Financial</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.levies.index') }}">Levies</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.payments.index') }}">Payments</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.reports.show','daily') }}">Reports</a>
                </li>
                @endrole

                @role('Collector')
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.payments.index') }}">Payments</a></li>
                @endrole

                @role('Trader')
                <li class="nav-item"><a class="nav-link" href="{{ route('trader.dashboard') }}">My Dashboard</a></li>
                @endrole

            </ul>

            <span class="navbar-text me-3">
                {{ $user->name }} (<small>{{ $user->getRoleNames()->implode(',') }}</small>)
            </span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf <button class="btn btn-sm btn-light">Logout</button>
            </form>
        </div>
    </div>
</nav>
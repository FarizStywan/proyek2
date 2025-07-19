<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">

        {{-- Branding Kos --}}
        <a class="sidebar-brand d-flex flex-column align-items-center py-4 border-bottom border-white" href="{{ url('/') }}">
            <img src="{{ asset('images/logokos.png') }}" alt="Logo Kos" class="rounded-circle mb-2" width="64" height="64">
            <h3 class="text-white mb-0">Sobat <span class="text-warning">Kos</span></h3>
            <small class="text-white-50">Smart Living</small>
        </a>

        {{-- Menu --}}
        <ul class="sidebar-nav">
            <li class="sidebar-header text-white">
                Menu Utama
            </li>

            <li class="sidebar-item {{ request()->is('/dashboard') || request()->routeIs('auth.penyewa.dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('penyewa.dashboard') }}" >
                    <i data-feather="home" class="align-middle"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('penyewa/bayar') || request()->routeIs('auth.penyewa.bayar') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('auth.penyewa.bayar') }}">
                    <i data-feather="dollar-sign" class="align-middle"></i>
                    <span class="align-middle">Biaya Sewa</span>
                </a>
            </li>
            
            

            {{-- Status Pembayaran (Nonaktifkan sementara) --}}
            <li class="sidebar-item {{ request()->is('penyewa/status-pembayaran') || request()->routeIs('penyewa.status') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('penyewa.status') }}">
                    <i data-feather="credit-card" class="align-middle"></i>
                    <span class="align-middle">Status Pembayaran</span>
                </a>
            </li>

            {{-- Histori Pembayaran (Nonaktifkan sementara) --}}
            <li class="sidebar-item {{ request()->is('penyewa/histori') || request()->routeIs('auth.penyewa.histori') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('auth.penyewa.histori') }}">
                    <i data-feather="clock" class="align-middle"></i>
                    <span class="align-middle">Histori Pembayaran</span>
                </a>
            </li>
            

            <li class="sidebar-item {{ request()->is('penyewa/pengaduan') || request()->routeIs('auth.penyewa.pengaduan.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('auth.penyewa.pengaduan.index') }}">
                    <i data-feather="message-circle" class="align-middle"></i>
                    <span class="align-middle">Pengaduan</span>
                </a>
            </li>

            {{-- Logout --}}
            <li class="sidebar-item">
                <a class="sidebar-link logout-link" href="{{ route('penyewa.logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i data-feather="log-out" class="align-middle"></i>
                    <span class="align-middle">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('penyewa.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>

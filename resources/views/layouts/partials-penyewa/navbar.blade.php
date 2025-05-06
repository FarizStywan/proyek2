<nav class="navbar navbar-expand navbar-light navbar-bg">
    <!-- Sidebar Toggle -->
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <!-- Navbar Collapse -->
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <!-- Notifications Dropdown -->
            {{-- <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="bell"></i>
                        <span class="indicator">4</span> <!-- Dynamic notification count -->
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                    <div class="dropdown-menu-header">
                        4 New Notifications
                    </div>
                    <div class="list-group">
                        <!-- Sample Notification -->
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <i class="text-danger" data-feather="alert-circle"></i>
                                </div>
                                <div class="col-10">
                                    <div class="text-dark">Update completed</div>
                                    <div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
                                    <div class="text-muted small mt-1">30m ago</div>
                                </div>
                            </div>
                        </a>
                        <!-- Additional notifications can be added here -->
                    </div>
                    <div class="dropdown-menu-footer">
                        <a href="#" class="text-muted">Show all notifications</a>
                    </div>
                </div> --}}
            </li>

            <!-- User Profile Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/avatars/profil.png') }}"
                         class="avatar img-fluid rounded-circle"
                         style="width: 40px; height: 40px; object-fit: cover;" 
                         alt="Profil" />
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/avatars/profil.png') }}" 
                         class="avatar img-fluid rounded-circle me-1" 
                         style="width: 40px; height: 40px; object-fit: cover;" 
                         alt="Profil" />
                    <span class="text-dark">{{ Auth::user()->name ?? 'Guest' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('auth.penyewa.profil.index') }}">
                        <i class="align-middle me-1" data-feather="user"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('penyewa.logout') }}">
                        @csrf
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="align-middle me-1" data-feather="log-out"></i> Log out
                        </a>
                    </form>
                </div>
            </li>

        </ul>
    </div>
</nav>

<!-- Required Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize Feather Icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>

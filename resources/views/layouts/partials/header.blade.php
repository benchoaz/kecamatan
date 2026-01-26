<header class="header">
    <div class="header-left">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="breadcrumb">
            <span class="breadcrumb-item">
                <i class="fas fa-home"></i>
            </span>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-item">@yield('breadcrumb', 'Dashboard')</span>
        </div>
    </div>

    <div class="header-right">
        <!-- Search -->
        <div class="header-search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari..." class="search-input">
        </div>

        <!-- Theme Toggle -->
        <button class="header-btn theme-toggle" id="themeToggle" title="Toggle Theme">
            <i class="fas fa-moon"></i>
        </button>

        <!-- Notifications -->
        <button class="header-btn notification-btn" title="Notifikasi">
            <i class="fas fa-bell"></i>
            <span class="notification-badge">3</span>
        </button>

        <!-- Quick Actions -->
        <div class="header-dropdown">
            <button class="header-btn" id="quickActionsBtn">
                <i class="fas fa-plus"></i>
            </button>
            <div class="dropdown-menu" id="quickActionsMenu">
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file-alt"></i>
                    <span>Buat Surat</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user-plus"></i>
                    <span>Tambah User</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-calendar-plus"></i>
                    <span>Buat Event</span>
                </a>
            </div>
        </div>

        <!-- Date & Time -->
        <div class="header-datetime">
            <span class="header-date" id="headerDate"></span>
            <span class="header-time" id="headerTime"></span>
        </div>

        <!-- User Profile Component (Architected) -->
        <div class="gov-profile">
            <button type="button" class="gov-profile__trigger" id="userProfileBtn" aria-expanded="false"
                aria-haspopup="true">
                <div class="gov-profile__avatar">
                    {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'U', 0, 2)) }}
                </div>
                <span
                    class="gov-profile__name d-none d-md-inline">{{ auth()->user()->nama_lengkap ?? 'Pengguna' }}</span>
                <i class="fas fa-chevron-down gov-profile__chevron"></i>
            </button>

            <nav class="gov-profile__menu" aria-label="Menu Profil">
                <div class="gov-profile__header">
                    <div class="gov-profile__avatar gov-profile__avatar--large">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="gov-profile__details">
                        <h6>{{ auth()->user()->nama_lengkap ?? 'Pengguna' }}</h6>
                        <span
                            class="gov-profile__role">{{ optional(auth()->user()->role)->nama_role ?? 'Akses Terbatas' }}</span>
                    </div>
                </div>

                <ul class="gov-profile__list">
                    <li>
                        <a href="#" class="gov-profile__item">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="gov-profile__item">
                            <i class="fas fa-key"></i>
                            <span>Ubah Kata Sandi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="gov-profile__item gov-profile__item--logout"
                            data-form-id="logout-form-header">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar Aplikasi</span>
                        </a>
                    </li>
                </ul>
                <form id="logout-form-header" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        </div>
    </div>
</header>
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/components/profile.js') }}"></script>
@stack('scripts')
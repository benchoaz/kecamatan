<header class="header border-0 shadow-sm px-4">
    <div class="header-left">
        <button class="menu-toggle shadow-sm rounded-3 border-0 bg-white text-primary-900" id="menuToggle">
            <i class="fas fa-bars-staggered"></i>
        </button>

        <div class="breadcrumb ms-2 d-none d-lg-flex">
            <span class="breadcrumb-item">
                <i class="fas fa-house-chimney text-brand-600"></i>
            </span>
            <span class="breadcrumb-separator opacity-25">/</span>
            <span class="breadcrumb-item fw-bold text-primary-900">@yield('breadcrumb', 'Dashboard Kontrol')</span>
        </div>
    </div>

    <div class="header-right">
        <!-- Search -->
        <div class="header-search ps-3 border-start border-primary-50 d-none d-md-flex">
            <i class="fas fa-magnifying-glass text-tertiary"></i>
            <input type="text" placeholder="Cari data desa atau indikator..."
                class="search-input bg-primary-50 border-0 rounded-pill ps-5">
        </div>

        <!-- System Controls -->
        <div class="d-flex align-items-center gap-2 ps-3 border-start border-primary-50">
            <button class="header-btn border-0 bg-transparent text-secondary" id="themeToggle">
                <i class="fas fa-moon"></i>
            </button>

            <button class="header-btn border-0 bg-transparent text-secondary position-relative">
                <i class="fas fa-bell"></i>
                <span class="position-absolute top-2 end-2 p-1 bg-danger border border-white rounded-circle"
                    style="width: 8px; height: 8px;"></span>
            </button>
        </div>

        <!-- User Profile (Standardized Gov Component) -->
        <div class="gov-profile" id="govProfileDropdown">
            <button class="gov-profile__trigger shadow-sm" type="button" aria-haspopup="true" aria-expanded="false"
                onclick="document.getElementById('govProfileDropdown').classList.toggle('is-active'); event.stopPropagation();">
                <div class="gov-profile__avatar bg-brand-600">
                    {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'U', 0, 2)) }}
                </div>
                <div class="gov-profile__name d-none d-sm-block">
                    {{ auth()->user()->nama_lengkap ?? 'User' }}
                </div>
                <i class="fas fa-chevron-down gov-profile__chevron"></i>
            </button>

            <div class="gov-profile__menu">
                <div class="gov-profile__header">
                    <div class="gov-profile__avatar gov-profile__avatar--large shadow-sm">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'U', 0, 2)) }}
                    </div>
                    <div class="gov-profile__details">
                        <h6>{{ auth()->user()->nama_lengkap ?? 'User' }}</h6>
                        <span
                            class="gov-profile__role">{{ optional(auth()->user()->role)->nama_role ?? 'Administrator' }}</span>
                    </div>
                </div>

                <ul class="gov-profile__list">
                    <li>
                        <a href="#" class="gov-profile__item">
                            <i class="fas fa-user-circle"></i> Profil Saya
                        </a>
                    </li>
                    <li>
                        <a href="#" class="gov-profile__item">
                            <i class="fas fa-lock text-info"></i> Ubah Password
                        </a>
                    </li>
                    <li>
                        <button type="button" class="gov-profile__item gov-profile__item--logout"
                            onclick="if(confirm('Konfirmasi Keluar\n\nApakah Anda yakin ingin keluar dari aplikasi?')) { document.getElementById('logout-form-header').submit(); }">
                            <i class="fas fa-power-off"></i> Keluar Aplikasi
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Hidden Logout Form -->
        <form id="logout-form-header" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</header>

<!-- Profile Component Scripts -->
<script src="{{ asset('js/components/profile.js') }}"></script>
<script>
// Failsafe: Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const profileDropdown = document.getElementById('govProfileDropdown');
    if (profileDropdown && !e.target.closest('#govProfileDropdown')) {
        profileDropdown.classList.remove('is-active');
    }
});
</script>
@stack('scripts')
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <div class="logo-icon text-primary"><i class="fas fa-university"></i></div>
            <div class="logo-text">
                <span class="logo-title">KECAMATAN</span>
                <span class="logo-subtitle">Sistem Pengawasan</span>
            </div>
        </div>
        <button class="sidebar-close" id="sidebarClose"><i class="fas fa-times"></i></button>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <span class="nav-section-title">Otoritas Kecamatan</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('kecamatan.dashboard') }}"
                        class="nav-link {{ request()->is('kecamatan/dashboard*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-gauge-high"></i></span>
                        <span class="nav-text">Dashboard Kontrol</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kecamatan.verifikasi.index') }}"
                        class="nav-link {{ request()->is('kecamatan/verifikasi*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-clipboard-check"></i></span>
                        <span class="nav-text">Verifikasi Laporan</span>
                        @php $pendingCount = \App\Models\Submission::where('status', 'submitted')->count(); @endphp
                        @if($pendingCount > 0) <span class="nav-badge">{{ $pendingCount }}</span> @endif
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <span class="nav-section-title">Bidang Pengawasan</span>
            <ul class="nav-menu">
                <!-- Pemerintahan -->
                <li class="nav-item">
                    <a href="{{ route('kecamatan.pemerintahan.index') }}"
                        class="nav-link {{ request()->is('kecamatan/pemerintahan*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-building-columns"></i></span>
                        <span class="nav-text">Monev Administrasi</span>
                    </a>
                </li>

                <!-- Ekonomi & Pembangunan -->
                <li class="nav-item">
                    <a href="{{ route('kecamatan.ekbang.index') }}"
                        class="nav-link {{ request()->is('kecamatan/ekbang*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-chart-line"></i></span>
                        <span class="nav-text">Monev Pembangunan</span>
                    </a>
                </li>

                <!-- Kesejahteraan Rakyat -->
                <li class="nav-item">
                    <a href="{{ route('kecamatan.kesra.index') }}"
                        class="nav-link {{ request()->is('kecamatan/kesra*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-hand-holding-heart"></i></span>
                        <span class="nav-text">Monev Kesejahteraan</span>
                    </a>
                </li>

                <!-- Trantibum -->
                <li class="nav-item">
                    <a href="{{ route('kecamatan.trantibum.index') }}"
                        class="nav-link {{ request()->is('kecamatan/trantibum*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-shield-halved"></i></span>
                        <span class="nav-text">Monev Trantibum</span>
                    </a>
                </li>
            </ul>
        </div>

        @if(auth()->user()->isSuperAdmin() || auth()->user()->isOperatorKecamatan())
            <div class="nav-section">
                <span class="nav-section-title">Sistem & Master</span>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('kecamatan.users.index') }}"
                            class="nav-link {{ request()->routeIs('kecamatan.users.*') ? 'active' : '' }}">
                            <span class="nav-icon"><i class="fas fa-users-cog"></i></span>
                            <span class="nav-text">Manajemen User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kecamatan.master.desa.index') }}"
                            class="nav-link {{ request()->routeIs('kecamatan.master.desa.*') ? 'active' : '' }}">
                            <span class="nav-icon"><i class="fas fa-map-marked-alt"></i></span>
                            <span class="nav-text">Master Data Desa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon"><i class="fas fa-file-invoice"></i></span>
                            <span class="nav-text">Log Aktivitas</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar bg-primary text-white"><i class="fas fa-user-shield"></i></div>
            <div class="user-info">
                <span class="user-name text-truncate">{{ auth()->user()->nama_lengkap }}</span>
                <span
                    class="user-role small text-muted text-capitalize">{{ optional(auth()->user()->role)->nama_role }}</span>
            </div>
        </div>
    </div>
</aside>
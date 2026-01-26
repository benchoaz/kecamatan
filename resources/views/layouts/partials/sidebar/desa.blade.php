<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <div class="logo-icon text-success"><i class="fas fa-home"></i></div>
            <div class="logo-text">
                <span class="logo-title">OPERATOR</span>
                <span class="logo-subtitle">Sistem Informasi Desa</span>
            </div>
        </div>
        <button class="sidebar-close" id="sidebarClose"><i class="fas fa-times"></i></button>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <span class="nav-section-title">Menu Utama</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('desa.dashboard') }}"
                        class="nav-link {{ request()->is('desa/dashboard*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-th-large"></i></span>
                        <span class="nav-text">Dashboard Desa</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <span class="nav-section-title">Pembangunan</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('desa.ekbang.index') }}"
                        class="nav-link {{ request()->is('desa/ekbang*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-road"></i></span>
                        <span class="nav-text">Input Progres Fisik</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <span class="nav-section-title">Pelaporan & Telaah</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('desa.submissions.index') }}"
                        class="nav-link {{ request()->is('desa/submissions*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-file-export"></i></span>
                        <span class="nav-text">Kirim Laporan Baru</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar bg-success text-white"><i class="fas fa-user-check"></i></div>
            <div class="user-info">
                <span class="user-name text-truncate">{{ auth()->user()->nama_lengkap }}</span>
                <span
                    class="user-role small text-muted">{{ optional(auth()->user()->role)->nama_role ?? 'Operator Desa' }}</span>
            </div>
        </div>
    </div>
</aside>
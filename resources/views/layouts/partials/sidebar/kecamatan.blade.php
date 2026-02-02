<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <div class="logo-icon bg-brand-600 text-white shadow-premium">
                @if(appProfile()->logo_path)
                    <img src="{{ asset('storage/' . appProfile()->logo_path) }}" class="img-fluid rounded-1"
                        style="max-height: 24px;">
                @else
                    <i class="fas fa-landmark"></i>
                @endif
            </div>
            <div class="logo-text">
                <span class="logo-title fw-bold text-uppercase">{{ appProfile()->region_level }}</span>
                <span class="logo-subtitle tracking-wider">{{ strtoupper(appProfile()->region_name) }}</span>
            </div>
        </div>
        <button class="sidebar-close" id="sidebarClose"><i class="fas fa-times"></i></button>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <span class="nav-section-title">ADMINISTRASI & OTORITAS</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('kecamatan.dashboard') }}"
                        class="nav-link {{ request()->is('kecamatan/dashboard*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-layer-group"></i></span>
                        <span class="nav-text">Beranda Pusat</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kecamatan.verifikasi.index') }}"
                        class="nav-link {{ request()->is('kecamatan/verifikasi*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-check-double"></i></span>
                        <span class="nav-text">Verifikasi Desa</span>
                        @php $pendingCount = \App\Models\Submission::where('status', 'submitted')->count(); @endphp
                        @if($pendingCount > 0) <span
                        class="nav-badge bg-danger shadow-sm text-white">{{ $pendingCount }}</span> @endif
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <span class="nav-section-title">BIDANG PELAYANAN</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('kecamatan.pelayanan.inbox') }}"
                        class="nav-link {{ request()->is('kecamatan/pelayanan/inbox*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-inbox"></i></span>
                        <span class="nav-text">Inbox Pengaduan</span>
                        @php $unreadCount = \App\Models\PublicService::where('status', 'Menunggu Klarifikasi')->count(); @endphp
                        @if($unreadCount > 0)
                            <span class="nav-badge bg-teal-600 shadow-sm text-white">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kecamatan.pelayanan.visitor.index') }}"
                        class="nav-link {{ request()->is('kecamatan/pelayanan/visitor*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-clipboard-user"></i></span>
                        <span class="nav-text">Buku Tamu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kecamatan.pelayanan.faq.index') }}"
                        class="nav-link {{ request()->is('kecamatan/pelayanan/faq*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-robot"></i></span>
                        <span class="nav-text">FAQ Administrasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kecamatan.pelayanan.statistics') }}"
                        class="nav-link {{ request()->is('kecamatan/pelayanan/statistics*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-chart-line"></i></span>
                        <span class="nav-text">Statistik Layanan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kecamatan.announcements.index') }}"
                        class="nav-link {{ request()->is('kecamatan/announcements*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-bullhorn text-amber-500"></i></span>
                        <span class="nav-text">Pengumuman</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <span class="nav-section-title">BIDANG PENGAWASAN</span>
            <ul class="nav-menu">
                <!-- Pemerintahan -->
                <li class="nav-item">
                    <a href="{{ route('kecamatan.pemerintahan.index') }}"
                        class="nav-link {{ request()->is('kecamatan/pemerintahan*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-shield-halved"></i></span>
                        <span class="nav-text">Monev Tata Kelola</span>
                    </a>
                </li>

                <!-- Ekonomi & Pembangunan (Integrated Dropdown) -->
                <li class="nav-item has-submenu">
                    <a href="javascript:void(0)" class="nav-link submenu-toggle">
                        <span class="nav-icon"><i class="fas fa-chart-pie"></i></span>
                        <span class="nav-text">Ekonomi & Pembangunan</span>
                        <span class="ms-auto small"><i class="fas fa-chevron-right nav-arrow"></i></span>
                    </a>
                    <ul class="nav-submenu">
                        <li class="nav-submenu-item">
                            <a href="{{ route('kecamatan.pembangunan.index') }}"
                                class="nav-sublink {{ request()->routeIs('kecamatan.pembangunan.index') || request()->routeIs('kecamatan.pembangunan.show') ? 'active' : '' }}">
                                <i class="fas fa-display me-2 small"></i> Monitoring Utama
                            </a>
                        </li>
                        <li class="nav-submenu-item">
                            <a href="{{ route('kecamatan.pembangunan.referensi.ssh.index') }}"
                                class="nav-sublink {{ request()->is('kecamatan/pembangunan/referensi/ssh*') ? 'active' : '' }}">
                                <i class="fas fa-tags me-2 small"></i> Master SSH
                            </a>
                        </li>
                        <li class="nav-submenu-item">
                            <a href="{{ route('kecamatan.pembangunan.referensi.sbu.index') }}"
                                class="nav-sublink {{ request()->is('kecamatan/pembangunan/referensi/sbu*') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice-dollar me-2 small"></i> Master SBU
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Kesejahteraan Rakyat -->
                <li class="nav-item">
                    <a href="{{ route('kecamatan.kesra.index') }}"
                        class="nav-link {{ request()->is('kecamatan/kesra*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-dove"></i></span>
                        <span class="nav-text">Kesejahteraan Sosial</span>
                    </a>
                </li>

                <!-- Trantibum (Integrated Dropdown) -->
                <li class="nav-item has-submenu">
                    <a href="javascript:void(0)" class="nav-link submenu-toggle">
                        <span class="nav-icon"><i class="fas fa-masks-theater"></i></span>
                        <span class="nav-text">Trantibum & Linmas</span>
                        <span class="ms-auto small"><i class="fas fa-chevron-right nav-arrow"></i></span>
                    </a>
                    <ul class="nav-submenu">
                        <li class="nav-submenu-item">
                            <a href="{{ route('kecamatan.trantibum.index') }}"
                                class="nav-sublink {{ request()->routeIs('kecamatan.trantibum.index') ? 'active' : '' }}">
                                <i class="fas fa-display me-2 small"></i> Monitoring Wilayah
                            </a>
                        </li>
                        <li class="nav-submenu-item">
                            <a href="{{ route('kecamatan.trantibum.tagana.index') }}"
                                class="nav-sublink {{ request()->is('kecamatan/trantibum/tagana*') ? 'active' : '' }}">
                                <i class="fas fa-phone-volume me-2 small"></i> Data TAGANA Desa
                            </a>
                        </li>
                        <li class="nav-submenu-item">
                            <a href="{{ route('kecamatan.trantibum.emergency.index') }}"
                                class="nav-sublink {{ request()->is('kecamatan/trantibum/emergency*') ? 'active' : '' }}">
                                <i class="fas fa-headset me-2 small"></i> Pusat No. Darurat
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Modul Laporan -->
                <li class="nav-item">
                    <a href="{{ route('kecamatan.laporan.index') }}"
                        class="nav-link {{ request()->is('kecamatan/laporan*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-file-invoice"></i></span>
                        <span class="nav-text">Laporan Terpadu</span>
                    </a>
                </li>
            </ul>
        </div>

        @if(auth()->user()->isSuperAdmin() || auth()->user()->isOperatorKecamatan())
            <div class="nav-section">
                <span class="nav-section-title">KONFIGURASI SISTEM</span>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('kecamatan.users.index') }}"
                            class="nav-link {{ request()->routeIs('kecamatan.users.*') ? 'active' : '' }}">
                            <span class="nav-icon"><i class="fas fa-user-gear"></i></span>
                            <span class="nav-text">Manajemen Pengguna</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kecamatan.master.desa.index') }}"
                            class="nav-link {{ request()->routeIs('kecamatan.master.desa.*') ? 'active' : '' }}">
                            <span class="nav-icon"><i class="fas fa-map-location-dot"></i></span>
                            <span class="nav-text">Data Master Desa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kecamatan.settings.profile') }}"
                            class="nav-link {{ request()->routeIs('kecamatan.settings.profile') ? 'active' : '' }}">
                            <span class="nav-icon"><i class="fas fa-sliders"></i></span>
                            <span class="nav-text">Pengaturan Aplikasi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kecamatan.settings.features') }}"
                            class="nav-link {{ request()->routeIs('kecamatan.settings.features') ? 'active' : '' }}">
                            <span class="nav-icon"><i class="fas fa-toggle-on"></i></span>
                            <span class="nav-text">Manajemen Fitur</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon"><i class="fas fa-file-invoice"></i></span>
                            <span class="nav-text">Audit Aktivitas</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-card border-0 shadow-sm" style="background: rgba(255,255,255,0.03);">
            <div class="user-avatar bg-brand-600 text-white"><i class="fas fa-user-tie"></i></div>
            <div class="user-info">
                <span class="user-name text-truncate text-white">{{ auth()->user()->nama_lengkap }}</span>
                <span
                    class="user-role small text-muted text-uppercase tracking-tighter">{{ optional(auth()->user()->role)->nama_role }}</span>
            </div>
        </div>

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit"
                class="btn btn-danger btn-sm w-100 rounded-3 d-flex align-items-center justify-content-center gap-2 py-2 shadow-sm"
                onclick="return confirm('Konfirmasi Keluar\n\nApakah Anda yakin ingin keluar dari aplikasi?')"
                style="font-size: 13px;">
                <i class="fas fa-power-off"></i>
                <span>Keluar Aplikasi</span>
            </button>
        </form>
    </div>
</aside>
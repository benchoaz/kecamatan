@extends('layouts.kecamatan')

@section('title', 'Dashboard Monitoring')

@section('content')
    <div class="dashboard">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="welcome-content">
                <h1 class="welcome-title">Workspace Monitoring Kecamatan</h1>
                <h2 class="welcome-name">{{ auth()->user()->name }}</h2>
                <p class="welcome-subtitle">Otoritas penelaahan, pembinaan, dan pengawasan administratif desa.</p>
            </div>
            <div class="welcome-illustration">
                <div class="illustration-circle bg-primary"></div>
                <i class="fas fa-shield-halved text-primary"></i>
            </div>
        </div>

        <!-- Stats Grid (Administrative Context) -->
        <div class="stats-grid">
            <div class="stat-card stat-primary">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-content">
                    <span class="stat-value" data-count="{{ $stats['total_penduduk'] }}">0</span>
                    <span class="stat-label">Total Penduduk</span>
                </div>
            </div>

            <div class="stat-card stat-success">
                <div class="stat-icon"><i class="fas fa-file-signature"></i></div>
                <div class="stat-content">
                    <span class="stat-value" data-count="{{ $stats['laporan_masuk'] }}">0</span>
                    <span class="stat-label">Laporan Bulan Ini</span>
                </div>
            </div>

            <div class="stat-card stat-warning">
                <div class="stat-icon"><i class="fas fa-building"></i></div>
                <div class="stat-content">
                    <span class="stat-value" data-count="{{ $stats['jumlah_desa'] }}">0</span>
                    <span class="stat-label">Desa/Kelurahan</span>
                </div>
            </div>

            <div class="stat-card stat-info">
                <div class="stat-icon"><i class="fas fa-clipboard-user"></i></div>
                <div class="stat-content">
                    <span class="stat-value" data-count="{{ $stats['pengunjung_hari_ini'] }}">0</span>
                    <span class="stat-label">Pengunjung Hari Ini</span>
                </div>
            </div>
        </div>

        <!-- Monitoring Area Grid -->
        <div class="dashboard-grid">
            <!-- Global Activities -->
            <div class="dashboard-card activities-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clock-rotate-left"></i> Log Aktivitas Wilayah</h3>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        @foreach($activities as $activity)
                            <div class="activity-item">
                                <div class="activity-icon {{ $activity['type'] }}">
                                    <i class="fas {{ $activity['icon'] }}"></i>
                                </div>
                                <div class="activity-content">
                                    <span class="activity-text">{{ $activity['message'] }}</span>
                                    <span class="activity-time">{{ $activity['time'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Access Fields -->
            <div class="dashboard-card domains-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-th-large"></i> Bidang Pengawasan</h3>
                </div>
                <div class="card-body">
                    <div class="domains-grid">
                        <a href="{{ route('kecamatan.pemerintahan.index') }}" class="domain-item domain-pemerintahan">
                            <div class="domain-icon"><i class="fas fa-landmark"></i></div>
                            <span class="domain-name">Pemerintahan</span>
                        </a>
                        <a href="{{ route('kecamatan.ekbang.index') }}" class="domain-item domain-ekbang">
                            <div class="domain-icon"><i class="fas fa-chart-line"></i></div>
                            <span class="domain-name">Ekbang</span>
                        </a>
                        <a href="{{ route('kecamatan.kesra.index') }}" class="domain-item domain-kesra">
                            <div class="domain-icon"><i class="fas fa-hand-holding-heart"></i></div>
                            <span class="domain-name">Kesra</span>
                        </a>
                        <a href="{{ route('kecamatan.trantibum.index') }}" class="domain-item domain-trantibum">
                            <div class="domain-icon"><i class="fas fa-shield-halved"></i></div>
                            <span class="domain-name">Trantibum</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const counters = document.querySelectorAll('.stat-value');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 1500;
                const step = target / (duration / 16);
                let current = 0;
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        counter.textContent = target.toLocaleString('id-ID');
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current).toLocaleString('id-ID');
                    }
                }, 16);
            });
        });
    </script>
@endpush
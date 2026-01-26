<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Monitoring') - Kecamatan SAE</title>

    <!-- Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        :root {
            /* Professional Blue/Slate color scheme for Kecamatan Otoritas */
            --primary-900: #0f172a;
            --primary-800: #1e293b;
            --primary-700: #334155;
            --brand-color: #2563eb;
            /* Indigo/Blue */
            --brand-hover: #1d4ed8;
            --accent-blue: #3b82f6;
            --surface-bg: #f8fafc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--surface-bg);
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="app-container">
        <!-- Sidebar Khusus Kecamatan (Review & Kontrol) -->
        @include('layouts.partials.sidebar.kecamatan')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            @include('layouts.partials.header')

            <!-- Page Content -->
            <div class="page-content">
                @if(session('success'))
                    <div class="alert alert-success mt-4 mx-4">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    @stack('scripts')
</body>

</html>
document.addEventListener('DOMContentLoaded', function () {
    // -------------------------------------------------------------------------
    // Sidebar Toggle Logic
    // -------------------------------------------------------------------------
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const body = document.body;

    function toggleSidebar() {
        if (window.innerWidth >= 992) {
            // Desktop: Toggle collapsed state
            body.classList.toggle('sidebar-collapsed');
        } else {
            // Mobile: Toggle active state
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        }
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleSidebar();
        });
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', function () {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });
    }

    // -------------------------------------------------------------------------
    // Dropdown Management (Robust Event Delegation)
    // -------------------------------------------------------------------------
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.header-btn, .profile-pill');
        const dropdown = e.target.closest('.header-dropdown');

        // Handle Click on Toggle Button
        if (btn && dropdown) {
            console.log('Dropdown toggle clicked:', btn.id || btn.className);
            e.preventDefault();
            e.stopPropagation();

            // Close all other dropdowns
            document.querySelectorAll('.header-dropdown.active').forEach(openDropdown => {
                if (openDropdown !== dropdown) {
                    openDropdown.classList.remove('active');
                }
            });

            // Toggle current
            dropdown.classList.toggle('active');
            console.log('Toggle result:', dropdown.classList.contains('active'));
            return;
        }

        // Handle Logout Confirmation
        const logoutTrigger = e.target.closest('#logoutBtnTrigger');
        if (logoutTrigger) {
            e.preventDefault();
            e.stopPropagation();

            const isConfirmed = confirm(
                "Konfirmasi Keluar\n\nApakah Anda yakin ingin keluar dari aplikasi?\nPastikan semua pekerjaan Anda telah disimpan."
            );

            if (isConfirmed) {
                const form = document.getElementById('logout-form-header');
                if (form) form.submit();
            }
            return;
        }

        // Handle Click Outside (Close all)
        if (!dropdown) {
            document.querySelectorAll('.header-dropdown.active').forEach(openDropdown => {
                openDropdown.classList.remove('active');
            });
        }
    });

    // Submenu Toggle (Accordion) - Optimized
    document.querySelectorAll('.has-submenu > .nav-link').forEach(trigger => {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            this.parentElement.classList.toggle('open');
        });
    });

    // -------------------------------------------------------------------------
    // Theme Toggle
    // -------------------------------------------------------------------------
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        updateThemeIcon(savedTheme);

        themeToggle.addEventListener('click', function () {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    }

    function updateThemeIcon(theme) {
        const icon = themeToggle.querySelector('i');
        if (theme === 'dark') {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        } else {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
        }
    }
    // -------------------------------------------------------------------------
    // Page Transitions & Loading Bar
    // -------------------------------------------------------------------------
    const loadingBar = document.createElement('div');
    loadingBar.id = 'page-loading-bar';
    document.body.appendChild(loadingBar);

    function startLoading() {
        loadingBar.style.width = '0%';
        loadingBar.style.opacity = '1';
        setTimeout(() => {
            loadingBar.style.width = '70%';
        }, 10);
    }

    function completeLoading() {
        loadingBar.style.width = '100%';
        setTimeout(() => {
            loadingBar.style.opacity = '0';
            setTimeout(() => {
                loadingBar.style.width = '0%';
            }, 500);
        }, 300);
    }

    // Capture all link clicks for the loading effect
    document.addEventListener('click', function (e) {
        const link = e.target.closest('a');
        if (link &&
            link.href &&
            !link.href.startsWith('javascript') &&
            !link.href.includes('#') &&
            !link.getAttribute('target') &&
            link.hostname === window.location.hostname) {

            // Only show loader for actual page navigations
            startLoading();
        }
    });

    // Handle back/forward button
    window.addEventListener('pageshow', function (event) {
        completeLoading();
    });

    // Complete loader on initial load
    completeLoading();
});

<!DOCTYPE html>
<html>

<head>
    <title>Test Profile Dropdown</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div style="padding: 50px; background: #f8fafc;">
        <div class="gov-profile">
            <button class="gov-profile__trigger" onclick="this.parentElement.classList.toggle('is-active')">
                <div class="gov-profile__avatar bg-brand-600">AD</div>
                <div class="gov-profile__name">Admin User</div>
                <i class="fas fa-chevron-down gov-profile__chevron"></i>
            </button>

            <div class="gov-profile__menu">
                <div class="gov-profile__header">
                    <div class="gov-profile__avatar gov-profile__avatar--large">AD</div>
                    <div class="gov-profile__details">
                        <h6>Admin User</h6>
                        <span class="gov-profile__role">Super Admin</span>
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
                            <i class="fas fa-lock"></i> Ubah Password
                        </a>
                    </li>
                    <li>
                        <button type="button" class="gov-profile__item gov-profile__item--logout"
                            onclick="if(confirm('Keluar dari aplikasi?')) { document.getElementById('logout-form').submit(); }">
                            <i class="fas fa-power-off"></i> Keluar Aplikasi
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.gov-profile')) {
                document.querySelectorAll('.gov-profile').forEach(el => el.classList.remove('is-active'));
            }
        });
    </script>
</body>

</html>
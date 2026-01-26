<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kecamatan SAE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        body {
            background: radial-gradient(circle at top right, #1e293b 0%, #0f172a 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
            margin: 0;
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-logo {
            width: 72px;
            height: 72px;
            background: rgba(20, 184, 166, 0.1);
            border: 1px solid rgba(20, 184, 166, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
            color: #14b8a6;
            box-shadow: 0 0 40px rgba(20, 184, 166, 0.2);
        }

        .login-title {
            color: #ffffff;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            color: #94a3b8;
            font-size: 14px;
            font-weight: 400;
        }

        .login-form .form-group {
            margin-bottom: 24px;
        }

        .login-form label {
            display: block;
            color: #94a3b8;
            font-size: 13px;
            margin-bottom: 10px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-custom i {
            position: absolute;
            left: 18px;
            color: #64748b;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .login-input {
            width: 100%;
            padding: 14px 18px 14px 52px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .login-input::placeholder {
            color: #475569;
        }

        .login-input:focus {
            outline: none;
            border-color: #14b8a6;
            box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.15);
            background: rgba(15, 23, 42, 0.82);
        }

        .login-input:focus+i {
            color: #14b8a6;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(20, 184, 166, 0.4);
            filter: brightness(1.1);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-home {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 25px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        .back-home:hover {
            color: #14b8a6;
        }

        /* Ambient Lights */
        .ambient-light-1 {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(20, 184, 166, 0.12) 0%, rgba(20, 184, 166, 0) 70%);
            top: -100px;
            right: -100px;
            z-index: 1;
            pointer-events: none;
        }

        .ambient-light-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(20, 184, 166, 0.08) 0%, rgba(20, 184, 166, 0) 70%);
            bottom: -50px;
            left: -50px;
            z-index: 1;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="ambient-light-1"></div>
    <div class="ambient-light-2"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-landmark"></i>
                </div>
                <h2 class="login-title">Kecamatan SAE</h2>
                <p class="login-subtitle">Akses Internal Petugas & ASN</p>
            </div>

            @if (session('logout_success'))
                <div class="alert px-3 py-3 rounded-3 mb-4"
                    style="background: rgba(20, 184, 166, 0.1); border: 1px solid rgba(20, 184, 166, 0.2); color: #14b8a6; font-size: 14px; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-check-circle" style="font-size: 18px;"></i>
                    <div>
                        <strong>Logout Berhasil</strong>
                        <p class="mb-0 small">Anda telah berhasil keluar dari aplikasi. Terima kasih.</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-group-custom">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" class="login-input" placeholder="Masukkan username anda"
                            value="{{ old('username') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="login-input" placeholder="Masukkan password anda"
                            required>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <span>Sign In</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
            <a href="{{ url('/') }}" class="back-home">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>

</html>
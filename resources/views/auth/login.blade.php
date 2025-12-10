<! DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPER - Login</title>
    <link href="https://fonts.googleapis.com/css2? family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding:  0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #c0c0c0 0%, #ffa500 50%, #ff8c00 100%);
            background-size: 200% 200%;
            animation:  gradientShift 15s ease infinite;
            padding: 20px;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login-container {
            background-color: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 600;
            color: #1e1e2d;
            margin-bottom: 5px;
        }

        . form-group {
            margin-bottom: 20px;
        }

        . form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding:  12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline:  none;
            border-color:  #1e1e2d;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #666;
            font-size: 12px;
            text-decoration:  none;
            transition: color 0.3s ease;
        }

        . forgot-password a:hover {
            color: #1e1e2d;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color:  #1e1e2d;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight:  500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #333;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }

        .register-link a {
            color:  #1e1e2d;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        . register-link a:hover {
            color: #ffa500;
        }

        .alert {
            padding: 12px 15px;
            border-radius:  8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        . error-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .error-list li {
            margin-bottom: 5px;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            .login-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1 class="login-title">Login Pengguna</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">E-Mail (with @*. unsoed.ac.id)</label>
                <input 
                    type="email" 
                    class="form-input" 
                    name="email" 
                    placeholder="Masukkan email" 
                    value="{{ old('email') }}" 
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input 
                    type="password" 
                    class="form-input" 
                    name="password" 
                    placeholder="Masukkan password" 
                    required
                >
            </div>

            <div class="forgot-password">
                <a href="{{ route('show.register') }}">Belum punya akun? Daftar disini! </a>
            </div>

            <button type="submit" class="btn-login">Masuk</button>

            <div class="register-link">
                <a href="#" onclick="alert('Fitur reset password akan segera hadir.  Silakan hubungi administrator. '); return false;">Lupa password?</a>
            </div>
        </form>
    </div>

    <script>
        // Email validation - optional client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const emailInput = document.querySelector('input[name="email"]');
            const email = emailInput.value;

            // Check if email contains unsoed.ac.id (more flexible)
            if (email && ! email.includes('unsoed.ac.id')) {
                e.preventDefault();
                alert('Email harus menggunakan domain @*. unsoed.ac.id');
                emailInput.focus();
                return false;
            }
        });
    </script>
</body>
</html>
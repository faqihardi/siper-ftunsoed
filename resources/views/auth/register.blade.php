<! DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPER - Registrasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
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
            0% { background-position:  0% 50%; }
            50% { background-position:  100% 50%; }
            100% { background-position:  0% 50%; }
        }

        .register-container {
            background-color: #fff;
            border-radius:  20px;
            padding:  40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }

        . register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-title {
            font-size: 24px;
            font-weight:  600;
            color: #1e1e2d;
            margin-bottom: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #1e1e2d;
        }

        .login-link {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-link a {
            color: #666;
            font-size: 12px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color:  #1e1e2d;
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background-color:  #1e1e2d;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-register:hover {
            background-color:  #333;
        }

        .password-requirements {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
            line-height: 1.4;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        . alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .error-list li {
            margin-bottom: 5px;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
            }

            .register-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1 class="register-title">Registrasi Pengguna</h1>
        </div>

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

        <form action="{{ route('register') }}" method="POST" id="register-form">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input 
                    type="text" 
                    class="form-input" 
                    name="nama_user" 
                    placeholder="Masukkan nama lengkap" 
                    value="{{ old('nama_user') }}" 
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">NIM/NIP</label>
                <input 
                    type="text" 
                    class="form-input" 
                    name="no_induk" 
                    placeholder="Masukkan NIM/NIP" 
                    value="{{ old('no_induk') }}" 
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">E-Mail (with @*.unsoed.ac. id)</label>
                <input 
                    type="email" 
                    class="form-input" 
                    name="email" 
                    id="email" 
                    placeholder="Masukkan email" 
                    value="{{ old('email') }}" 
                    required
                >
                <div class="error-message" id="email-error">Email harus menggunakan domain @*. unsoed.ac.id</div>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor Telepon</label>
                <input 
                    type="tel" 
                    class="form-input" 
                    name="no_hp" 
                    id="no_hp" 
                    placeholder="Masukkan nomor telepon" 
                    value="{{ old('no_hp') }}" 
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input 
                    type="password" 
                    class="form-input" 
                    name="password" 
                    id="password" 
                    placeholder="Masukkan password" 
                    required
                >
                <div class="password-requirements">Minimal 8 karakter</div>
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input 
                    type="password" 
                    class="form-input" 
                    name="password_confirmation" 
                    id="confirm_password" 
                    placeholder="Konfirmasi password" 
                    required
                >
                <div class="error-message" id="password-error">Password tidak cocok</div>
            </div>

            <div class="login-link">
                <a href="{{ route('show.login') }}">Sudah punya akun? Login disini!</a>
            </div>

            <button type="submit" class="btn-register">Daftar</button>
        </form>
    </div>

    <script>
        // Email validation
        document.getElementById('email').addEventListener('blur', function() {
            const email = this. value;
            const errorMsg = document.getElementById('email-error');
            
            if (email && !email.includes('unsoed. ac.id')) {
                errorMsg.style.display = 'block';
                this.style. borderColor = '#dc3545';
            } else {
                errorMsg.style.display = 'none';
                this.style. borderColor = '#ddd';
            }
        });

        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const errorMsg = document.getElementById('password-error');
            
            if (confirmPassword && password !== confirmPassword) {
                errorMsg.style.display = 'block';
                this.style.borderColor = '#dc3545';
            } else {
                errorMsg.style.display = 'none';
                this.style.borderColor = '#ddd';
            }
        });

        // Register form submission validation
        document.getElementById('register-form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document. getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const no_hp = document.getElementById('no_hp').value;

            // Validate email domain
            if (!email.includes('unsoed.ac.id')) {
                e.preventDefault();
                alert('Email harus menggunakan domain @*. unsoed.ac.id');
                document.getElementById('email').focus();
                return false;
            }

            // Validate password length
            if (password.length < 8) {
                e. preventDefault();
                alert('Password minimal 8 karakter!');
                document.getElementById('password').focus();
                return false;
            }

            // Validate password confirmation
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                document.getElementById('confirm_password').focus();
                return false;
            }

            // Validate phone number
            if (!/^[0-9]{10,13}$/.test(no_hp)) {
                e.preventDefault();
                alert('Nomor telepon tidak valid!  Harus 10-13 digit angka.');
                document.getElementById('no_hp').focus();
                return false;
            }
        });
    </script>
</body>
</html>
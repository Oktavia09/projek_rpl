<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISMADU</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f1f1f1;
            padding: 20px;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 500px;
        }

        .logo-img {
            max-width: 320px;
            height: auto;
            margin-bottom: 15px;
        }

        .logo-text {
            font-size: 20px;
            color: #886e58;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
        }

        .wrapper {
            background: #fff;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 500px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header span {
            font-size: 28px;
            font-weight: bold;
            color: #b2a496;
        }

        .input_box {
            position: relative;
            margin-bottom: 25px;
        }

        .input-field {
            width: 100%;
            padding: 16px 50px 16px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            outline: none;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .input-field:focus {
            border-color: #b2a496;
        }

        .label {
            position: absolute;
            top: -12px;
            left: 16px;
            background: #fff;
            padding: 0 8px;
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }

        .icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #999;
        }

        .remember {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #b2a496;
        }

        .input-submit {
            width: 100%;
            padding: 16px;
            background-color: #b2a496;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .input-submit:hover {
            background-color: #886e58;
        }

        p {
            text-align: center;
            margin-top: 25px;
            font-size: 15px;
            color: #666;
        }

        p a {
            color: #b2a496;
            text-decoration: none;
            font-weight: 500;
        }

        p a:hover {
            color: #886e58;
            text-decoration: underline;
        }

        .alert {
            width: 100%;
            max-width: 500px;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        @media (max-width: 480px) {
            .wrapper {
                padding: 40px 30px;
            }

            .logo-img {
                max-width: 280px;
            }

            .login-header span {
                font-size: 24px;
            }

            .input-field {
                padding: 14px 45px 14px 14px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Alert messages would be handled by Laravel Blade -->
    <div class="login-container">
        <img src="{{ asset('img/logoSismadu.png') }}" alt="Logo Sekolah" class="logo-img">
        <p class="logo-text">Sistem Informasi Smart Education</p>

        <div class="wrapper">
            <div class="login_box">
                <div class="login-header">
                    <span>Login</span>
                </div>

                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <!-- CSRF token would be added by Laravel -->
                    <div class="input_box">
                        <input type="email" id="user" name="email" value="{{ old('email') }}" class="input-field" required>
                        <label for="user" class="label">email</label>
                        <i class="bx bx-user icon"></i>
                    </div>

                    <div class="input_box">
                        <input type="password" id="pass" name="password" class="input-field" required>
                        <label for="pass" class="label">Password</label>
                        <i class="bx bx-lock-alt icon"></i>
                    </div>

                    <div class="remember">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                    </div>

                    <div class="input_box">
                        <input type="submit" class="input-submit" value="Login">
                    </div>
                </form>
            </div>
            <p>Belum punya akun? <a href="register2.html">Register</a></p>
        </div>
    </div>
</body>

</html>



{{-- <form action="{{ route('login.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <button class="btn btn-primary">Login</button>
</form> --}}

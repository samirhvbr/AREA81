<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | AREA81</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #0a0a12;
            color: #f1f5f9;
            font-family: 'Inter', system-ui, sans-serif;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute; top: -40%; right: -20%;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.07) 0%, transparent 65%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: absolute; bottom: -30%; left: -15%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,0.04) 0%, transparent 65%);
            pointer-events: none;
        }

        .login-card {
            width: 100%; max-width: 400px;
            background: rgba(17,24,39,0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(99,102,241,0.15);
            border-radius: 18px;
            padding: 42px 36px;
            position: relative; z-index: 1;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-brand {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 8px;
        }
        .login-brand-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.82rem; font-weight: 700; color: #fff;
            font-family: 'Courier New', monospace; letter-spacing: -0.02em;
        }
        .login-eyebrow {
            font-size: 0.62rem; letter-spacing: 0.18em;
            color: #6366f1; font-family: 'Courier New', monospace;
            text-transform: uppercase; font-weight: 600;
        }
        .login-title {
            font-size: 1.3rem; font-weight: 700;
            margin-bottom: 32px; margin-top: 4px;
        }
        .form-group { margin-bottom: 18px; }
        label {
            display: block; font-size: 0.76rem; font-weight: 500;
            color: #94a3b8; margin-bottom: 6px; letter-spacing: 0.02em;
        }
        input[type=email], input[type=password] {
            width: 100%; padding: 11px 14px;
            background: rgba(13,13,20,0.7);
            border: 1px solid rgba(99,102,241,0.18);
            border-radius: 9px; color: #f1f5f9;
            font-family: inherit; font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        input:focus {
            outline: none; border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .error-msg { color: #f87171; font-size: 0.76rem; margin-top: 6px; }
        .btn-login {
            width: 100%; margin-top: 10px; padding: 12px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            color: #fff; border: none; border-radius: 9px;
            font-family: inherit; font-size: 0.9rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s ease;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(99,102,241,0.35);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-brand">
            <div class="login-brand-icon">A81</div>
            <div class="login-eyebrow">// AREA81</div>
        </div>
        <h1 class="login-title">Acesso ao painel</h1>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" autofocus required>
                @error('email')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Entrar</button>
        </form>
    </div>
</body>
</html>

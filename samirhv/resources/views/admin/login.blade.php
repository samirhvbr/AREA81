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
        body { background: #0d0d14; color: #f1f5f9; font-family: 'Inter', system-ui, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 100%; max-width: 380px; background: #111827; border: 1px solid rgba(99,102,241,0.2); border-radius: 14px; padding: 36px 32px; }
        .login-eyebrow { font-size: 0.65rem; letter-spacing: 0.18em; color: #6366f1; font-family: 'Courier New', monospace; margin-bottom: 8px; }
        .login-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 28px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 0.75rem; font-weight: 500; color: #94a3b8; margin-bottom: 5px; }
        input[type=email], input[type=password] {
            width: 100%; padding: 10px 12px; background: #0d0d14; border: 1px solid rgba(99,102,241,0.2);
            border-radius: 7px; color: #f1f5f9; font-family: inherit; font-size: 0.875rem;
        }
        input:focus { outline: none; border-color: #6366f1; }
        .error-msg { color: #f87171; font-size: 0.75rem; margin-top: 5px; }
        .btn-login { width: 100%; margin-top: 8px; padding: 10px; background: #6366f1; color: #fff; border: none; border-radius: 7px; font-family: inherit; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: background 0.15s; }
        .btn-login:hover { background: #4f46e5; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-eyebrow">// AREA81</div>
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
